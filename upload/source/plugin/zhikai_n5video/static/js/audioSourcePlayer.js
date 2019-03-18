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
		self.isStart = false;

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
			self.attached = false;
        },

		// 绑定播放器和声音数据，
		// offset表示声音数据在播放器的多少秒处开始播放。
		attach: function(player, buffer, offset) {
			var self = this;
			self.player = player;
			self.audioBuffer = buffer;
			self.offset = offset;
			if (self.source != null) {
				self.source.stop();
				self.source = null;
			}
			self.attached = true;
            console.log('AudioSourcePlayer: attach.');
		},

		// 播放。
		start: function() {
			var self = this;

			if (self.attached) {
				if (self.source != null) {
					self.source.stop();
					self.source = null;
				}

				var duration = self.player.duration();
				var currentTime = self.player.currentTime();
				if (!isNaN(duration) && !isNaN(currentTime) ) {
					try {
						self.source = self.context.createBufferSource();
						self.source.buffer = self.audioBuffer;
						self.source.loop = false;
						self.source.connect(self.context.destination);
						console.log('AudioSourcePlayer: start. currentTime=', currentTime, " duration=", duration, " offset=", self.offset);
						self.source.start(0, currentTime - self.offset, duration - currentTime);
						self.isStart = true;
					}
					catch (ex) {
						console.log('AudioSourcePlayer: ' + ex);
					}
				}
			}
		},

		// 停止。
		stop: function() {
			var self = this;

			if (self.attached && self.source != null && self.isStart) {
				console.log('AudioSourcePlayer: stop.');
				try {
					self.source.stop();
					self.isStart = false;
					self.source = null;
				}
				catch (ex) {
					console.log('AudioSourcePlayer:' + ex);
				}
			}
		}
    };

    //---------------- export ----------------
    window.AudioSourcePlayer = AudioSourcePlayer;

})(window);