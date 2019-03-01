/*
* audioSourcePlayer.js 利用Audio Web API实现的AudioScheduledSource音频的播放、暂停和停止功能 。
*/
(function (window, undefined) {
    "use strict";

    //浏览器兼容
    window.AudioContext = window.AudioContext || window.webkitAudioContext || window.mozAudioContext || window.msAudioContext;

    // 构造函数
    function AudioSourcePlayer(ops) {
        ops = ops || {};

        var self = this;
        self.ops = ops;
		self.currentTime = 0;
		self.startTime = 0;
		self.isPlaying = false;

        //支持检测
        self.support = !!(window.AudioContext);

        self.init();
    }

    AudioSourcePlayer.prototype = {
        constructor: AudioSourcePlayer,

        //初始化
        init: function () {

            var self = this;
			var ops = self.ops;

            if (!self.support) return;
            self.context = new AudioContext();
        },

		setBuffer: function(buffer) {
			var self = this;
			self.currentTime = 0;
			self.audioBuffer = buffer;
		},

		// 重新开始播放。
		start: function(buffer) {
			var self = this;

			if (self.isPlaying) {
				self.source.stop();
				self.isPlaying = false;
			}

			self.audioBuffer = buffer;
			self.source = self.context.createBufferSource();
			self.source.buffer = self.audioBuffer;
			self.source.loop = false;
			self.source.connect(self.context.destination);
			self.source.onended = function(event) {
				self.isPlaying = false;
				self.currentTime = 0;
			}

			self.currentTime = 0;
			self.startTime = self.context.currentTime;
			self.source.start(self.startTime, self.currentTime);
			self.isPlaying = true;
		},

		// 恢复或重新开始播放。
		play: function() {
			var self = this;

			if (!self.isPlaying) {
				self.startTime = self.context.currentTime;

				self.source = self.context.createBufferSource();
				self.source.buffer = self.audioBuffer;
				self.source.loop = false;
				self.source.connect(self.context.destination);
				self.source.onended = function(event) {
					self.isPlaying = false;
					self.currentTime = 0;
				}

				self.startTime = self.context.currentTime;
				self.source.start(self.startTime, self.currentTime);
				self.isPlaying = true;
			}
		},
		
		// 暂停
		pause: function() {
			var self = this;

			if (self.isPlaying) {
				self.source.stop();
				// 记录暂停的位置，下次恢得播放时从这个位置开始播放。
				self.currentTime = self.context.currentTime - self.startTime;
			}
		},

		// 停止。
		stop: function() {
			var self = this;

			if (self.isPlaying) {
				self.source.stop();
				self.currentTime = 0;
				self.isPlaying = false;
			}
		}
    };

    //---------------- export ----------------
    window.AudioSourcePlayer = AudioSourcePlayer;

})(window);