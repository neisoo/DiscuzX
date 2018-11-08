function GetFxList(){
	var metas = document.getElementsByTagName('meta'),keywords='',description ='',imgs=[];
	for(var i=0; i< metas.length; i++ ){
		if(metas[i].name == 'keywords'){
			keywords = metas[i].content;
		}
		if(metas[i].name == 'description'){
			description = metas[i].content;
		}
	}
	var picurl = document.getElementsByTagName('img');
	for(var i=0; i < picurl.length; i++){
		if(picurl[i].naturalWidth < 130 || picurl[i].naturalHeight < 130){continue;}
		imgs = picurl[i].src;
		break;
	}
	return {
		title:keywords,
		desc:description,
		link: location.href.replace('&mobile=2',''),
		imgUrl: imgs
	};
}