(function ($){
	$.extend({
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
		GetPercent: function (num, total){
			var num = parseFloat(num);
			var total = parseFloat(total);
			if (isNaN(num) || isNaN(total)){
				return "-";
			}
			return total <= 0 ? 0 : (Math.round(num / total * 10000) / 100.00);
		},
		RandomBy: function (under, over){
			switch(arguments.length){
				case 1: return parseInt(Math.random()*under+1);
				case 2: return parseInt(Math.random()*(over-under+1) + under);
				default: return 0;
			} 
		},
		upBar: function (s){
		    if (s <= 100){
			    $('.tz-bar').css('width',s+'%');
			    $('.tz-bar').next().html(s+'%');
		    }
		    if (s == 100){
			    setTimeout("jQuery(barid).html('').fadeOut()",1000);
			    upstr = upfinished;
			    $.zhikai_add();
		    }
		},
		zhikai_upload: function (){
			$(barid).show().html('<span class="tz-bar"></span><i></i>');
			$('.tz-bar').next().html('&#22788;&#29702;&#20013;&#46;&#46;&#46;');
            var succeed = 0, file = $('#'+upid)[0].files[0], name = file.name, size = file.size, file_id = $.RandomBy(1000,9999);
			var _shardSize = shardsize * 1024 * 1024;
			var shardCount = Math.ceil(size / _shardSize);
			if(size == 0){
				upstr = '&#25991;&#20214;&#22823;&#23567;&#19981;&#33021;&#20026;&#48;&#44;&#32487;&#32493;&#19978;&#20256;';
				$.zhikai_add();
				return false;
			}
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
			var i = 0;
			var xhr = new XMLHttpRequest();
			function ajaxStack(stack) {
				if (stack.hasOwnProperty(i)) {
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
						ajaxStack(stack);
					}
					xhr.onreadystatechange = function () {
						if (xhr.readyState == 4 && xhr.status == 200) {
							if (typeof upcallback == 'function'){
								upcallback(xhr.responseText);
							}
							++succeed;
							var cent = $.GetPercent(succeed, shardCount);
							$.upBar(cent);
						}
					}
					xhr.send(form);
					i++;
				}
			}
			ajaxStack(re);
		}
	})
})(jQuery);