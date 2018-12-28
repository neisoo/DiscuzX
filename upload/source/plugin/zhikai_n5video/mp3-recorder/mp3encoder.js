/*
* recorder.js 录制音频并输出为MP3格式
* https://github.com/devin87/mp3-recorder
* author:devin87@qq.com  
* update:2015/12/30 08:58
*/
(function (window, undefined) {
    "use strict";

    //MP3编码
    function MP3Encoder(ops) {
        ops = ops || {};

        var self = this;
        self.bitRate = ops.bitRate || 128;

        self.ops = ops;

        self.init();
    }

    MP3Encoder.prototype = {
        constructor: MP3Encoder,

        //初始化
        init: function () {
            var self = this;

            var ops = self.ops,
                onComplete = ops.complete,
                onError = ops.error,
                worker = new Worker(ops.WORKER_PATH || 'js/recorder-worker.js');

            worker.onmessage = function (e) {
                var obj = e.data, data = obj.data;

                switch (obj.cmd) {
                    case "complete":
                        if (onComplete) onComplete(data, "audio/mp3");
                        break;

                    case "error":
                        if (onError) onError(data);
                        break;
                }
            };

            self.worker = worker;
        },

        //开始编码
        encode: function (audioBuffer) {
            var self = this;

			var worker = self.worker;

            worker.postMessage({
                cmd: "init",
                data: {
                    numChannels: audioBuffer.numberOfChannels,
                    inputSampleRate: audioBuffer.sampleRate,
                    outputSampleRate: audioBuffer.sampleRate,
                    bitRate: self.bitRate
                }
            });

			var data = [], i = 0;
			for (; i < audioBuffer.numberOfChannels; i++) {
				data.push(audioBuffer.getChannelData(i));
			}

			worker.postMessage({ cmd: "encode", data: data });
			worker.postMessage({ cmd: "stop" });
        },
    };

    //---------------- export ----------------
    window.MP3Encoder = MP3Encoder;

})(window);