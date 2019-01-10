/*
 * jQuery One Page Nav Plugin
 * http://github.com/davist11/jQuery-One-Page-Nav
 *
 * Copyright (c) 2010 Trevor Davis (http://trevordavis.net)
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://jquery.org/license
 *
 * @version 3.0.0
 *
 * Example usage:
 * $('#nav').onePageNav({
 *   currentClass: 'current',
 *   changeHash: false,
 *   scrollSpeed: 750
 * });
 
 		// 按config中的设置初始化。
		// 参数：
		//	shardSize 上传文件的切片大小，默认为2M；
		//	uploadUrl 上传到哪个url。
		//	progressCallback 上传进度回调。
		//	stepCallback 切片上传成功回调。
		//	userData 用户数据。

 */

;(function($, window, document, undefined){

	// our plugin constructor
	var ShardUpload = function(elem, options){
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;
		this.metadata = this.$elem.data('plugin-options');
		this.$win = $(window);
		this.$doc = $(document);
	};

	// the plugin prototype
	ShardUpload.prototype = {
		// 默认参数。
		defaults: {
			shardSize: 2,
			uploadUrl: null,
			progressCallback: null,
			stepCallback: null,
			userData: null
		},

		// 初始化。
		init: function() {
			// Introduce defaults that can be extended either
			// globally or using an object literal.
			this.config = $.extend({}, this.defaults, this.options, this.metadata);

			// 绑定事件，触发上传操作。
			this.$elem.on('change.shardUpload', $.proxy(this.onchange, this))

			return this;
		},

		// 计算百分数。
		getPercent: function (num, total) {
			var num = parseFloat(num);
			var total = parseFloat(total);
			if (isNaN(num) || isNaN(total)) {
				return "-";
			}
			return total <= 0 ? 0 : (Math.round(num / total * 10000) / 100.00);
		},

		// 产生随机数。
		randomBy: function (under, over) {
			switch(arguments.length) {
				case 1: return parseInt(Math.random() * under + 1);
				case 2: return parseInt(Math.random() * (over - under + 1) + under);
				default: return 0;
			} 
		},

		onchange: function (e, blob, filename) {
			var self = this;
			var succeed = 0;

			var file;
			var name;
			if (typeof blob == 'undefined') {
				// 从input中取文件
				file = self.$elem[0].files[0];
				name = file.name;
			}
			else {
				// 从参数中取文件
				file = blob;
				name = filename || 'file_' + Date.now();
			}

			// 用户可以在这里修改图片文件大小。
			if (typeof self.config.fileCallback == 'function') {
				self.config.fileCallback(self, file, name, self.upload);
			}
			else {
				self.upload(self, file, name);
			}
		},

		// 使用切片上传方式，且js不会阻塞。
		upload: function (self, file, name){
			var succeed = 0;
			var size = file.size;
			var file_id = self.randomBy(1000,9999);

			if (self.config.uploadUrl == null){
				return false;
			}

			// 切片大小和切片数量
			var _shardSize = self.config.shardSize * 1024 * 1024;
			var shardCount = Math.ceil(size / _shardSize);
			if(size == 0){
				return false;
			}

			// 回调：显示进度条。
			if (typeof self.config.progressCallback == 'function') {
				self.config.progressCallback(self.$elem, 0, self.config.userData);
			}

			// 将文件切片，分成几块放在re数组中上传。
			var re = [], start, end = null, URL = self.config.uploadUrl;
			for (var i = 0; i < shardCount; ++i){
				re[i] = [];
				start = i * _shardSize,
				end = Math.min(size, start + _shardSize);
				re[i]["file_data"] = file.slice(start, end);
				re[i]["file_name"] = name;
				re[i]["file_size"] = size;
				re[i]["file_id"] = file_id;
				re[i]["file_total"] = shardCount;
				re[i]["file_index"] = i + 1;
			}

			// 将数组中的切片依次上传。
			var i = 0;
			var xhr = new XMLHttpRequest();
			function ajaxStack(stack) {
				// 数组中是否还要有要上传的切片。
				if (stack.hasOwnProperty(i)) {
					// 新建表单来上传当前切片。
					var fcs = stack[i];
					var form = new FormData();
					form.append("file_data", fcs['file_data']);
					form.append("file_name", fcs['file_name']);
					form.append("file_total", fcs['file_total']);
					form.append("file_index", fcs['file_index']);
					form.append("file_size", fcs['file_size']);
					form.append("file_id", fcs['file_id']);
					xhr.open('POST', URL, true);
					xhr.onload = function () {
						// 当前切片上传完成，继续上传下一切片。
						ajaxStack(stack);
					}
					xhr.onreadystatechange = function () {
						// 更新状态信息和上传进度。
						if (xhr.readyState == 4 && xhr.status == 200) {
							// 回调：显示状态信息。
							if (typeof self.config.stepCallback == 'function'){
								self.config.stepCallback(self.$elem, xhr.responseText, self.config.userData);
							}

							++succeed;

							// 回调：更新进度条进度显示。
							if (typeof self.config.progressCallback == 'function') {
								var percnt = self.getPercent(succeed, shardCount);
								self.config.progressCallback(self.$elem, percnt, self.config.userData);
							}
						}
					}
					// 上传记录了切片数据的表单。
					xhr.send(form);
					// 下一切片。
					i++;
				}
			}
			// 开始上传第一个切片。
			ajaxStack(re);
		}
	};

	ShardUpload.defaults = ShardUpload.prototype.defaults;

	$.fn.shardUpload = function(options) {
		return this.each(function() {
			new ShardUpload(this, options).init();
		});
	};

})( jQuery, window , document );