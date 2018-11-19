// 这是文件上传的前端脚本，后端脚本在upload.inc.php。
(function ($){
	$.extend({
		// 按config中的设置初始化。
		// 参数：
		//	upstr 上传按钮的字符串；
		//	upid 上传按钮的ID，默认为upid；
		//	updom 放置上传按钮的元素class，默认为.zhikai-ups；
		//	barid 放置上传进度条的元素class，默认为.zhikai-bar；
		//	shardsize 上传文件的切片大小，默认为2M；
		//	upfinished 上传完成后，上传按钮要显示的文字；
		//	upurl 上传到哪个url。
		//	errtype ?
		//	upcallback 上传状态变化时的回调。可选
		zhikai: function (config){
			upstr = config.upstr ? config.upstr : '&#19978;&#20256;&#25991;&#20214;';
			upid = config.upid ? config.upid : 'upid';
			updom = config.updom ? config.updom : '.zhikai-ups';
			barid = config.barid ? config.barid : '.zhikai-bar';
			shardsize = config.shardsize ? config.shardsize : 2;
			upfinished = config.upfinished;
			upurl = config.upurl;
			errtype = config.errtype;
			upcallback = config.upcallback;
			if (updom && upurl){
				$.zhikai_add();
			}
		},
		// 向ID为updom的元素中添加上传按钮。
		zhikai_add: function (){
			var uphtml = '<div class="zhikai-button">'+upstr+
			             '<input type="file" id="'+upid+'" name="'+upid+'" value="" onchange="jQuery.zhikai_upload()" '+
						 'style="opacity:0;display:block;position:relative;top: -28px;width:100%;line-height:26px;">'+
                         '</div>';
			$(updom).html(uphtml);
		},
		RndNum: function (n){
			var rnd = null;
			for(var i = 0; i < n; i++)
				rnd += Math.floor(Math.random() * 10);
			return rnd;
		},
		// 计算百分数。
		GetPercent: function (num, total){
			var num = parseFloat(num);
			var total = parseFloat(total);
			if (isNaN(num) || isNaN(total)){
				return "-";
			}
			return total <= 0 ? 0 : (Math.round(num / total * 10000) / 100.00);
		},
		// 产生随机数。
		RandomBy: function (under, over){
			switch(arguments.length){
				case 1: return parseInt(Math.random()*under+1);
				case 2: return parseInt(Math.random()*(over-under+1) + under);
				default: return 0;
			} 
		},
		// 上传时更新ID为barid的进度条，进度为s%。
		upBar: function (s){
		    if (s <= 100){
				// 更新进度条。
			    $('.tz-bar').css('width',s+'%');
			    $('.tz-bar').next().html(s+'%');
		    }
		    if (s == 100){
				// 隐藏进度条。
			    setTimeout("jQuery(barid).html('').fadeOut()",1000);
			    upstr = upfinished;
			    $.zhikai_add();
		    }
		},
		// 上传ID为upid元素中的文件，使用切片上传方式，且js不会阻塞。
		zhikai_upload: function (){
			$(barid).show().html('<span class="tz-bar"></span><i></i>');
			$('.tz-bar').next().html('&#22788;&#29702;&#20013;&#46;&#46;&#46;');
            var succeed = 0, file = $('#'+upid)[0].files[0], name = file.name, size = file.size, file_id = $.RandomBy(1000,9999);
			// 切片大小和切片数量
			var _shardSize = shardsize * 1024 * 1024;
			var shardCount = Math.ceil(size / _shardSize);
			if(size == 0){
				upstr = '&#25991;&#20214;&#22823;&#23567;&#19981;&#33021;&#20026;&#48;&#44;&#32487;&#32493;&#19978;&#20256;';
				$.zhikai_add();
				return false;
			}
			// 将文件切片，分成几块放在re数组中上传。
			var re = [], start, end = null, URL = upurl;
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
						// 更新上传进度。
						if (xhr.readyState == 4 && xhr.status == 200) {
							if (typeof upcallback == 'function'){
								upcallback(xhr.responseText);
							}
							++succeed;
							var cent = $.GetPercent(succeed, shardCount);
							$.upBar(cent);
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
	})
})(jQuery);