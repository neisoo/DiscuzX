<?php


if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

class mobileplugin_zhikai_n5video {
	function discuzcode($value){
		global $_G;


		if($value['caller'] == 'discuzcode'){
			$message = $_G['discuzcodemessage'];

			$pattern = "/(\[media|\[flash)(.*?)\](http|https)\:\/\/([a-zA-Z0-9\.]+)\.qq\.com\/(.*?)vid=(.*?)\[\/(media|flash)\]/";
			$replacement = '<iframe frameborder="0" src="http://v.qq.com/iframe/player.html?vid=\6&auto=0" style="'.$this->default_style().'"></iframe>';
			$message = preg_replace($pattern, $replacement, $message);
			/* MP3解析 */
			$pattern = '/\[audio(.*?)\](.*?)\.mp3\[\/audio\]/';
			$message = preg_replace_callback($pattern, array($this, 'parse_mp3'),$message );
			/* 土豆解析 */
			$pattern = '/\[flash(.*?)\]http:\/\/www\.tudou\.com(.*?)\[\/flash\]/';
			$message = preg_replace_callback($pattern, array($this, 'parse_tudou'),$message );
			/* 优酷解析 */
			$pattern = "/(\[media|\[flash)(.*?)\]http\:\/\/(v|player)\.youku\.com(.*?)(id_|sid\/)(.*?)(\.|\/)(.*?)\[\/(media|flash)\]/";
			$replacement = '<iframe src="http://player.youku.com/embed/\6" frameborder=0 allowfullscreen style="'.$this->default_style().'"></iframe>';
			$message = preg_replace($pattern, $replacement, $message);
			/* iqiyi解析 */
			$pattern = "/(\[media|\[flash)(.*?)\]http\:\/\/player\.video\.qiyi\.com\/(.*?)\/(.*?)\/(.*?)\/(.*?)\.swf(.*?)\[\/(media|flash)\]/";
			$message = preg_replace_callback($pattern, array($this, 'parse_iqiyi'),$message );

			$_G['discuzcodemessage'] = $message;
		}
	}

	public function default_style(){
		global $_G;
		$set = $_G['cache']['plugin']['zhikai_n5video'];
		$width = $set['width']?$set['width']."px":"100%";
		$height = $set['height']?$set['height']."px":"230px";
		return "width:{$width};height:{$height}; margin:10px 0;";
	}

	public function parse_iqiyi($matches){
		if(count($matches) == 9 && $matches[3] && $matches[6]){
			$url = 'http://www.iqiyi.com/'.$matches[6].'.html';
			$html = dfsockopen($url);
			preg_match('/tvId:(\d+),/',$html,$tvid);
			if(!$tvid || !$tvid[1]) return $matches[0];
			$tvid = $tvid[1];
			return '<iframe src="http://open.iqiyi.com/developer/player_js/coopPlayerIndex.html?vid='.$matches[3].'&tvId='.$tvid.'" frameborder="0" allowfullscreen="true" style="'.$this->default_style().'"></iframe>';
		}else{
			return $matches[0];
		}
	}

	public function parse_tudou($matches){
		global $_G;
		if($matches[2]){
			$url  = 'http://www.tudou.com'.$matches[2];
			$parse_url = $this->parse_tudouicode($url);
			if($parse_url){
				return '<iframe src="'.$parse_url.'" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0" style="'.$this->default_style().'"></iframe>';
			}else{
				return $matches[0];
			}
		}else{
			return $matches[0];
		}
	}

	public function parse_tudouicode($url){
		global $_G;
		$url = html_entity_decode($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$content = curl_exec($ch);
		$info = curl_getinfo($ch);
		if(!$info['url'] || $info['url'] == $url){
			preg_match('/Location: (.*?)\n/',$content,$ma);
			$info['url'] = $ma[1];
		}
		$p = '/(.*?)&code=(\w+)&(.*?)/';
		preg_match($p,$info['url'],$matches);
		if(!$matches || !$matches[2]) return false;
		return 'http://www.tudou.com/programs/view/html5embed.action?code='.$matches[2];
	}

	public function parse_mp3($matches){
		global $_G;
		if($matches[2]){
			$url  = $matches[2].".mp3";
			return '<audio controls="controls" style="width:100%;margin:10px 0;"><source src="'.$url.'" type="audio/mpeg"></audio>';
			
		}else{
			return $matches[0];
		}
	}
}

?>