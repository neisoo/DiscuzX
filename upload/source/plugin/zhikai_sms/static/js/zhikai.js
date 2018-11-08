
var zksResizeNeedDo = new Array();
var zks = (function(selector){
	/* 语言包 */
	var _lang = {
		domEmpty : 'NO dom',
	};
	var _zksDeputes = new Array();
	/* 选择器 */
	var _zks = function(selector){
		if(!selector){selector = document;}
		var selectorType = typeof(selector);
		switch(selectorType){
			case 'string':
			var doms = document.querySelectorAll(selector);
			var reObj = {dom:doms, length:doms.length};
			break;
			case 'object':
			var reObj = {dom:[selector], length:1};
			break;
			default:
			return null;
		}
		reObj.__proto__ = hcExtends;
		return reObj;
	}
	function addFuns(doms){var reObj = {dom:doms, length:doms.length}; reObj.__proto__ = hcExtends; return reObj;}
	_zks.import = function(funName, path){
		if(!path){path = './js/';}
		new_element=document.createElement("script"); 
		new_element.setAttribute("type","text/javascript"); 
		new_element.setAttribute("src", path+'zhikai-'+funName+'.js'); 
		document.body.appendChild(new_element);
	}
	/* dom 操作扩展 */
	var hcExtends = {
		size : function(){return this.length},
		/* 值、属性、HTML、操作 */
		val : function(vars){
			if(typeof(vars) != 'undefined'){for(var i = 0; i < this.length; i++){this.dom[i].value = vars;} return this;}
			try{return this.dom[0].value;}catch(e){console.log(_lang.domEmpty); return null;}
		},
		html : function(html){
			if(this.length < 1){return this;}
			if(typeof(html) != 'undefined'){for(var i = 0; i < this.length; i++){this.dom[i].innerHTML = html;} return this;}
			try{return this.dom[0].innerHTML;}catch(e){console.log(_lang.domEmpty); return null;}
		},
		attr:function(attrName, val){
			if(val){this.setAttr(attrName, val);}else{return this.getAttr(attrName);}
		},
		getAttr : function(attrName){
			try{return this.dom[0].getAttribute(attrName);}catch(e){console.log(_lang.domEmpty); return null;}
		},
		setAttr : function(attrName, val){
			for(var i = 0; i < this.length; i++){this.dom[i].setAttribute(attrName, val);} return this;
		},
		removeAttr : function(attrName){
			for(var i = 0; i < this.length; i++){this.dom[i].removeAttribute(attrName);}
			return this;
		},
		/* 样式操作 */
		css : function(csses){
			for(var i = 0; i < this.length; i++){var styles = this.dom[i].style; for(var k in csses){styles[k] = csses[k];}}
			return this;
		},
		hasClass : function(cls){
			if(this.length != 1){return false;}
			return this.dom[0].className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
		},
		addClass : function(cls){
			for(var i = 0; i < this.length; i++){
				if(!this.dom[i].className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'))){this.dom[i].className += " " + cls;}
			}
			return this;
		},
		removeClass : function(cls){
			var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
			for(var i = 0; i < this.length; i++){this.dom[i].className = this.dom[i].className.replace(reg, ' ');}
			return this;
		},
		hide : function(isAnimate){
			for(var i = 0; i < this.length; i++){
				if(isAnimate){
					var ctdom = zks(this.dom[i]);
					ctdom.addClass('zhikai-fade-out');
					setTimeout(function(){
						ctdom.dom[0].style.display = 'none';
						ctdom.removeClass('zhikai-fade-out');
					},300);
				}else{
					this.dom[i].style.display = 'none';
				}
			}
			return this;
		},
		show : function(isAnimate){
			for(var i = 0; i < this.length; i++){
				if(isAnimate){
					var ctdom = zks(this.dom[i]);
					ctdom.addClass('zhikai-fade-in');
					setTimeout(function(){
						ctdom.dom[0].style.display = 'block';
						ctdom.removeClass('zhikai-fade-in');
					},300);
				}else{
					this.dom[i].style.display = 'block';
				}
			}
			return this;
		},
		/*事件*/
		click : function(callBack){
			for(var i = 0; i < this.length; i++){
				if(callBack == undefined){_zks(this.dom[i]).trigger('click');}
				this.dom[i].addEventListener('click', callBack);
			}
		},
		change : function(callBack){
			for(var i = 0; i < this.length; i++){this.dom[i].addEventListener('change',callBack);}
		},
		focusIn : function(callBack){
			for(var i = 0; i < this.length; i++){this.dom[i].addEventListener('focus',callBack);}
		},
		focusOut : function(callBack){
			for(var i = 0; i < this.length; i++){this.dom[i].addEventListener('focusout',callBack);}
		},
		on : function(eventType, sonSelector, callBack){
			_zksDeputes.push({selector:sonSelector, cb:callBack});
			for(var i = 0; i < this.length; i++){
				this.dom[i].addEventListener('click', function(e){this.ondo(e);}.bind(this));
			}
		},
		ondo : function(e){
			if(!e.target){return false;}
			for(var i = 0; i < _zksDeputes.length; i++){
				var objs = zks(_zksDeputes[i].selector);
				for(var ii = 0; ii < objs.length; ii++){
					if(objs.dom[ii] === e.target){objs.dom[ii].index = ii; _zksDeputes[i].cb(objs.dom[ii]); break;}
				}
			}
		},
		longTap : function(callBack){
			if(this.length < 1){return;}
			var timer = null, timerNum = 0, _self = this.dom[0];
			_self.addEventListener('longTapDo', callBack);
			_self.addEventListener('touchstart',function(){
				timer = setInterval(function(){
					if(timerNum >= 1000){
						_zks(_self).trigger('longTapDo'); timerNum = 0; clearInterval(timer);
					}else{
						timerNum += 100;
					}
				}, 100);
			});
			this.dom[0].addEventListener('touchend',function(){clearInterval(timer);});
		},
		scroll : function(callBack){
			for(var i = 0; i < this.length; i++){
				this.dom[i].addEventListener('scroll', callBack);
			}
		},
		trigger : function(eventType, eventData){
			var element = this.dom[0];
			element.dispatchEvent(new CustomEvent(eventType,{detail:eventData,bubbles:true, cancelable:true}));
		},
		/* dom 元素遍历 */
		each : function(callBack){
			if(!callBack){return;}
			for(var i = 0; i < this.length; i++){this.dom[i].index = i; callBack(this.dom[i]);}
		},
		/* 筛选器 */
		eq : function(index){return _zks(this.dom[index]);},
		last : function(){return _zks(this.dom[this.length - 1]);},
		first : function(){return _zks(this.dom[0]);},
		next : function(){return _zks(this.dom[0].nextElementSibling || this.dom[0].nextSibling);},
		parent : function(){return _zks(this.dom[0].parentNode);},
		siblings : function(){
			if(!this.dom[0]){return this;}
			var nodes=[], startNode = this.dom[0], nextNode, preNode;
			var currentNode = startNode;
			while(nextNode = currentNode.nextElementSibling){nodes.push(nextNode); currentNode = nextNode;}
			currentNode = startNode;
			while(preNode = currentNode.previousElementSibling){nodes.push(preNode); currentNode = preNode;}
			return addFuns(nodes);
		},
		even : function(){
			var doms = new Array();
			for(var i = 0; i < this.length; i++){if(i % 2 == 0){doms.push(this.dom[i]);}}
			return addFuns(doms);
		},
		odd : function(){
			var doms = new Array();
			for(var i = 0; i < this.length; i++){if(i % 2 == 1){doms.push(this.dom[i]);}}
			return addFuns(doms);
		},
		index : function(){
			if(this.length != 1){return null;}
			var nodes=[], startNode = this.dom[0],  preNode;
			while(preNode = startNode.previousElementSibling){nodes.push(preNode); startNode = preNode;}
			return nodes.length;
		},
		find : function(selector){
			if(this.length < 1){return this;}
			var doms = new Array();
			for(var i = 0; i < this.length; i++){
				var domsquery = this.dom[i].querySelectorAll(selector);
				for(var ii = 0; ii < domsquery.length; ii++){
					doms.push(domsquery[ii]);
				}
			}
			return addFuns(doms);
		},
		/*dom操作 */
		clone : function(){
			var doms = new Array();
			for(var i = 0; i < this.length; i++){doms.push(this.dom[i].cloneNode(true));}
			return addFuns(doms);
		},
		remove : function(){
			for(var i = 0; i < this.length; i++){this.dom[i].parentNode.removeChild(this.dom[i]);}
		}
	}

	/*zks toast*/
	_zks.toast = function(msg, timer){
		if(timer == undefined){timer = 'short';}
		if(typeof(plus) != 'undefined'){plus.nativeUI.toast(msg, {duration:timer}); return;}
		var toast = zks('#zhikai-toast');
		if(toast.length > 0){toast.remove();}
		var div = document.createElement('div');
		div.setAttribute('id','zhikai-toast');
		div.setAttribute('class', 'zhikai-fade-in');
		document.body.appendChild(div);
		toast = zks('#zhikai-toast');
		toast.html('<div id="zhikai-toast-msg">'+msg+'</div>');
		if(_zks.ToastTimer){clearTimeout(_zks.ToastTimer);}
		if(timer == 'short'){timer = 2000;}else{timer = 3500;}
		_zks.ToastTimer = setTimeout(function(){toast.remove();}, timer);
	};
	/* icon Toast */
	_zks.iconToast = function(msg, icon){
		if(icon == undefined){icon = 'success';}
		var iconToast = zks('#zhikai-icon-toast');
		if(iconToast.length < 1){
			var div = document.createElement('div');
			div.setAttribute('id','zhikai-icon-toast');
			div.innerHTML = '<div class="zhikai-icons"></div><div class="zhikai-text-center"></div>';
			document.body.appendChild(div);
			iconToast = zks('#zhikai-icon-toast');
		}else{return false;}
		iconToast.find('div').eq(0).addClass('zhikai-icons-'+icon);
		iconToast.find('div').eq(1).html(msg);
		setTimeout(function(){iconToast.remove();}, 2000);
	};
	_zks.ToastTimer = null;
	_zks.upToast = function(msg){
		var toast = zks('#zhikai-up-toast');
		if(toast.length > 0){toast.remove();}
		var div = document.createElement('div');
		div.setAttribute('id','zhikai-up-toast');
		document.body.appendChild(div);
		toast = zks('#zhikai-up-toast');
		toast.html(msg);
		if(_zks.ToastTimer){clearTimeout(_zks.ToastTimer);}
		_zks.ToastTimer = setTimeout(function(){toast.remove();}, 2500);
	};
	/* dialog */
	_zks.maskShow = function(){
		_zks.mask = document.getElementById('zhikai-mask');
		if(!_zks.mask){
			_zks.mask = document.createElement('div');
			_zks.mask.setAttribute('id', 'zhikai-mask');
			document.body.appendChild(_zks.mask);
		}
	};
	_zks.maskHide = function(){if(_zks.mask){document.body.removeChild(_zks.mask);}}
	_zks.maskTap  = function(callBack){_zks.mask.addEventListener('click', callBack);}
	_zks.dialogBase  = function(){
		zks.dialogDom = document.getElementById('zhikai-dialog');
		if(zks.dialogDom){document.body.removeChild(zks.dialogDom);}
		zks.dialogDom = document.createElement('div');
		zks.dialogDom.setAttribute('id', 'zhikai-dialog');
		zks.dialogDom.setAttribute('class', 'zhikai-fade-in');
		document.body.appendChild(zks.dialogDom);
		zks.maskShow();
	}
	_zks.dialogClose = function(){document.body.removeChild(zks.dialogDom); zks.maskHide();};
	_zks.dialogCallBack = null;
	_zks.alert = function(msg, btnName, callBack){
		zks.dialogCallBack = callBack;
		if(!btnName){btnName = 'yes';}
		zks.dialogBase();
		zks.dialogDom.innerHTML = '<div id="zhikai-dialog-in"><div id="zhikai-dialog-msg">'+msg+'</div><div id="zhikai-dialog-btn-line">'+btnName+'</div></div>';
		var btn = document.getElementById('zhikai-dialog-btn-line');
		btn.onclick = function(){zks.dialogClose(); if(zks.dialogCallBack){zks.dialogCallBack();}}
	};
	_zks.confirm = function(msg, btnName, callBack, callBack2){
		if(!btnName){btnName = ['no','yes'];}
		zks.dialogBase();
		zks.dialogDom.innerHTML = '<div id="zhikai-dialog-in"><div id="zhikai-dialog-msg">'+msg+'</div><div id="zhikai-dialog-btn-line"><div>'+btnName[0]+'</div><div>'+btnName[1]+'</div></div></div>';
		var btns = document.getElementById('zhikai-dialog-btn-line').getElementsByTagName('div');
		btns[0].onclick = function(){zks.dialogClose(); if(callBack2){callBack2();}};
		btns[1].onclick = function(){zks.dialogClose(); if(callBack){callBack();}};
	};

	/* loading */
	_zks.loading = function(msg, isClose){
		if(msg){var loadingText = '<div id="zhikai-loading-text">'+msg+'</div>';}else{var loadingText = '';}
		var CK8_LoadingMask = document.getElementById('zhikai-transparent-mask');
		if(isClose){if(CK8_LoadingMask){CK8_LoadingMask.parentNode.removeChild(CK8_LoadingMask);} return false;}
		if(!CK8_LoadingMask){
			var CK8_LoadingMask = document.createElement('div');
			CK8_LoadingMask.setAttribute('id', 'zhikai-transparent-mask');
			CK8_LoadingMask.innerHTML = '<div id="zhikai-loading"><div id="zhikai-loading-in"><div></div><div></div><div></div><div></div><div></div></div>'+loadingText+'</div>';
			document.body.appendChild(CK8_LoadingMask);
		}
	};
	_zks.closeLoading = function(){
		var CK8_LoadingMask = document.getElementById('zhikai-transparent-mask');
		if(CK8_LoadingMask){CK8_LoadingMask.parentNode.removeChild(CK8_LoadingMask);}
	};
	_zks.resize  = function(callBack){zksResizeNeedDo.push(callBack);};
	/* ready */
	_zks.readyRe = /complete|loaded|interactive/;
	_zks.ready = function(callBack){
		if(document.addEventListener){
			document.addEventListener('DOMContentLoaded', function(){
				var backBtn = document.getElementById('zhikai-back');
				if(backBtn){backBtn.onclick = _zks.Back;} if(callBack){callBack();}
			});
		}else if(document.attachEvent){
			document.attachEvent("onreadystatechange", function(){
				if(_zks.readyRe.test(document.readyState)){
					var backBtn = document.getElementById('zhikai-back');
					if(backBtn){backBtn.onclick = _zks.Back;} if(callBack){callBack();}
				}
			});
		}
	};
	return _zks;
})(document);