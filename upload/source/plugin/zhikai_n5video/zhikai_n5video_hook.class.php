<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if (file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_n5video/function.inc.php')) {
	@include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5video/function.inc.php';
}

class plugin_zhikai_n5video {

    public static $config;
    public static $upfhash;
    public static $attachurl;
    public static $zkv1;

	public function __construct(){
        global $_G;
		if(empty($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		self::$config = $_G['cache']['plugin']['zhikai_n5video'];
        self::$upfhash = md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']);
        self::$attachurl = $_G['siteurl'].$_G['setting']['attachurl'].'forum/';
		self::$zkv1 = zkv1();
	}

	function global_header(){
        global $_G;
		$style = '';
		$config = self::$config;
		$height = explode('|',$config['height']);
		$width = explode('|',$config['width']);
		$height = $height[0] ? $height[0] : '430px';
		$width = $width[0] ? $width[0] : '100%';
		if(CURMODULE == 'viewthread' || CURMODULE == 'post'){
			$style ='<link rel="stylesheet" href="source/plugin/zhikai_n5video/static/audio/APlayer.min.css">
					<script type="text/javascript" src="//player.youku.com/jsapi"></script>
					<script src="source/plugin/zhikai_n5video/static/audio/APlayer.min.js"></script>
					<link rel="stylesheet" href="source/plugin/zhikai_n5video/video-js/video-js.min.css">
					<script type="text/javascript" src="source/plugin/zhikai_n5video/video-js/video.min.js"></script>';
					
			if($_G['basescript'] == 'forum' && $_G['gp_mod'] == 'viewthread'){
				$style .='<style type="text/css">
						   .zhikai-player{position:relative;width:100%;display:inline-flex;}
						   .zhikai-player iframe.iframevideo{width:'.$width.';height:'.$height.';margin:10px 5px;}
						   .zhikai-player iframe.iframe{width:'.$width.';height:80px;margin:10px 5px;}
						   .zhikai-player .aplayers{width:'.$width.';background:#494A5F;margin:10px 5px;padding:2px 0px;color:#cfcfcf;border-radius:3px;}
						   .zhikai-player .video{width:'.$width.';height:'.$height.';margin:10px 5px;}
						</style>';
			}
			return $style;
		}
    }//fr om w  w w.mo q  u8.c om

	function discuzcode($param){
		global $_G;
        $config = self::$config;

		if(in_array($_G['fid'],dunserialize($config['forum_media'])) || $config['isgroup']){
			if($param['caller'] == 'discuzcode' && CURMODULE == 'viewthread'){
				if(strexists($_G['discuzcodemessage'],'[/media]') !== FALSE){
					$_G['discuzcodemessage'] = preg_replace_callback("/\[media(.*?)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is","concentrate_replace",$_G['discuzcodemessage']);
				}
				if(strexists($_G['discuzcodemessage'],'[/zhikai_youku]') !== FALSE){
					$_G['discuzcodemessage'] = preg_replace_callback("/\[zhikai_youku(.*?)\]\s*([^\[\<\r\n]+?)\s*\[\/zhikai_youku\]/is","youku_replace",$_G['discuzcodemessage']);
				}
				if(strexists($_G['discuzcodemessage'],'[/audio]') !== FALSE){
					$_G['discuzcodemessage'] = preg_replace_callback("/\[audio(=1)*\]\s*([^\[\<\r\n]+?)\s*\[\/audio\]/is","audio_replace",$_G['discuzcodemessage']);
				}
				if(strexists($_G['discuzcodemessage'],'[/attach]') !== FALSE){
					$_G['discuzcodemessage'] = preg_replace_callback("/\[attach(.*?)\](\d+,\d+,\d*,\d*)\[\/attach\]/i","attach_replace",$_G['discuzcodemessage']);
				}
				if($config['img_parse'] && checkmobile()){
					preg_match_all("/\[img(.*?)\](.*?)\[\/img\]/", $param['param'][0], $match);
					if(count($match[0])){
						$replace = array();
						foreach ($match[2] as $value){
							$replace[] = '<img src="'.$value.'" style="width:'.$config['imgw'].';height:'.$config['imgh'].';" />';
						}
						$_G['discuzcodemessage'] = str_replace($match[0], $replace, $param['param'][0]);
					}
				}
			}else if($param['caller'] == 'messagecutstr'){
				if($config['subject_show']){
					$_G['discuzcodemessage'] = '';
				}
			}
		}
	}

}

class plugin_zhikai_n5video_forum extends plugin_zhikai_n5video{
	
    function post_attach_btn_extra(){
		global $_G;
		$config = self::$config;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || !in_array($_G['fid'],dunserialize($config['forum_open'])) || $config['youkuup_open'] == 2) return;
        return "<li id=\"e_btn_attachlists\"><a href=\"javascript:;\" onclick=\"switchAttachbutton('attachlists');\">".lang('plugin/zhikai_n5video', 'lang_vdo001')."</a></li>";
    }

    function post_attach_tab_extra(){
        global $_G;
		$config = self::$config;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || !in_array($_G['fid'],dunserialize($config['forum_open'])) || $config['youkuup_open'] == 2) return;
		loadcache('groupreadaccess');
        $upfhash = self::$upfhash;
        $attachurl = self::$attachurl;
		$video = json_encode(explode('|',$config['video_bmp']));
		$voice = json_encode(explode('|',$config['voice_bmp']));
		include template('zhikai_n5video:up_file');
	    return $file;
    }

	function post_editorctrl_left(){
		global $_G;
		$config = self::$config;
        if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || !in_array($_G['fid'],dunserialize($config['forum_open'])) || $config['youkuup_open'] == 1) return;
        include template('zhikai_n5video:youkuups');
        return $return;
	}

	function viewthread_postbottom_output(){
		global $_G,$postlist;
		$config = self::$config;
		if(empty($postlist) || !in_array($_G['fid'],dunserialize($config['forum_media']))) return;
		foreach($postlist as $key =>$val){
            $postlist[$key] = noattach_replace($val);
		}
    }
}

class plugin_zhikai_n5video_group extends plugin_zhikai_n5video{
	
    function post_attach_btn_extra(){
		global $_G;
		$config = self::$config;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || $config['youkuup_open'] == 2) return;
        return "<li id=\"e_btn_attachlists\"><a href=\"javascript:;\" onclick=\"switchAttachbutton('attachlists');\">".lang('plugin/zhikai_n5video', 'lang_vdo001')."</a></li>";
    }

    function post_attach_tab_extra(){
        global $_G;
		$config = self::$config;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || $config['youkuup_open'] == 2) return;
		loadcache('groupreadaccess');
        $upfhash = self::$upfhash;
        $attachurl = self::$attachurl;
		$video = json_encode(explode('|',$config['video_bmp']));
		$voice = json_encode(explode('|',$config['voice_bmp']));
		include template('zhikai_n5video:up_file');
	    return $file;
    }

	function post_editorctrl_left(){
		global $_G;
		$config = self::$config;
        if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || $config['youkuup_open'] == 1) return;
        include template('zhikai_n5video:youkuups');
        return $return;
	}
}

class mobileplugin_zhikai_n5video extends plugin_zhikai_n5video{
	function global_header_mobile(){
        global $_G;
		$style ='';
		$config = self::$config;
		$zkv1 = self::$zkv1;
		$height = explode('|',$config['height']);
		$width = explode('|',$config['width']);
		$height = $height[1] ? $height[1] : '200px';
		$width = $width[1] ? $width[1] : '100%';
		if(CURMODULE == 'viewthread' || CURMODULE == 'forumdisplay' || CURMODULE == 'guide' || CURMODULE == 'post'){
			$style ='<link rel="stylesheet" href="source/plugin/zhikai_n5video/static/audio/APlayer.min.css">
			        <script type="text/javascript" src="//player.youku.com/jsapi"></script>
					<script src="source/plugin/zhikai_n5video/static/audio/APlayer.min.js"></script>
					<link rel="stylesheet" href="source/plugin/zhikai_n5video/video-js/video-js.min.css">
					<script type="text/javascript" src="source/plugin/zhikai_n5video/video-js/video.min.js"></script>';
			if( CURMODULE == 'guide' || CURMODULE == 'forumdisplay'){
				$style .='<style type="text/css">
						   .zhikai-player{position:relative;width:100%;}
						   .zhikai-player iframe.iframevideo{width:100%;height:235px;margin:10px 0px;}
						   .zhikai-player iframe.iframe{width:100%;height:80px;margin:10px 0px;}
						   .zhikai-player .aplayers{width:100%;background:#494A5F;margin:10px 0px;padding:2px 0px;color:#cfcfcf;border-radius:3px;}
						   .zhikai-player .video{width:100%;height:235px;margin:10px 0px;}
						</style>';
			}else if(CURMODULE == 'viewthread'){
				$style .='<style type="text/css">
						   .zhikai-player{position:relative;width:100%;}
						   .zhikai-player iframe.iframevideo{width:'.$width.';height:'.$height.';margin:10px 0px;}
						   .zhikai-player iframe.iframe{width:'.$width.';height:80px;margin:10px 0px;}
						   .zhikai-player .aplayers{width:'.$width.';background:#494A5F;margin:10px 0px;padding:2px 0px;color:#cfcfcf;border-radius:3px;}
						   .zhikai-player .video{width:'.$width.';height:'.$height.';margin:10px 0px;}
						   .attnm{margin-bottom:3px;overflow:hidden;white-space:nowrap;}
						   .attnm a{color:#2684ce;text-decoration:underline;}
						   .xglc{display:block;font-size: 13px;color:#999;}
						   .xglc strong{color:#F26C4F;font-weight:400;}
						</style>'; 
			}
			return $style;
		}
    }

}//fr o  m ww w.mo qu  8.c o m

class mobileplugin_zhikai_n5video_forum extends mobileplugin_zhikai_n5video {

	function post_bottom_mobile(){
		global $_G;
		$config = self::$config;
		if(in_array('zhikai_n5appgl',$_G['setting']['plugins']['available']))return;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || !in_array($_G['fid'],dunserialize($config['forum_open']))) return;
		if($config['youkuup_open'] == 1){
			loadcache('groupreadaccess');
			$upfhash = self::$upfhash;
			$attachurl = self::$attachurl;
			$video = json_encode(explode('|',$config['video_bmp']));
			$voice = json_encode(explode('|',$config['voice_bmp']));
			include template('zhikai_n5video:up_file');
			return $file;
		}else if($config['youkuup_open'] == 2){
			youku_access_token($config);
			$youku_refresh = unserialize($_G['setting']['youku_refresh']);
			include template('zhikai_n5video:youkuup');
            return $return;
		}
	}

	function post_n5bottom_mobile(){
		global $_G;
		$config = self::$config;
		if(!in_array('zhikai_n5appgl',$_G['setting']['plugins']['available']))return;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) || !in_array($_G['fid'],dunserialize($config['forum_open']))) return;
		if($config['youkuup_open'] == 1){
			loadcache('groupreadaccess');
			$upfhash = self::$upfhash;
			$attachurl = self::$attachurl;
			$video = json_encode(explode('|',$config['video_bmp']));
			$voice = json_encode(explode('|',$config['voice_bmp']));
			if($_GET['action'] == 'reply') {
				$attachInfo = reply_replace($_G['tid']);
				include template('zhikai_n5video:up_reply_file');
			}
			else {
				include template('zhikai_n5video:up_file');
			}
			return $file;
		}else if($config['youkuup_open'] == 2){
			youku_access_token($config);
			$youku_refresh = unserialize($_G['setting']['youku_refresh']);
			include template('zhikai_n5video:youkuup');
            return $return;
		}
	}

	function forumdisplay_mobile_output(){
        global $_G;
		$config = self::$config;
		if(!in_array($_G['fid'],dunserialize($config['forum_media']))) return;
        if(!$_G['forum_threadlist'] || !$config['media_open']){return;}
	    if(!in_array('zhikai_n5appgl',$_G['setting']['plugins']['available']))return;
	
		if (file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_forumdisplay.php')) {
			@include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_forumdisplay.php';
		}
 		if(function_exists('zknvbing5_v1')){
		    zknvbing5_v1();
		}
    }

	function guide_mobile_output(){
        global $_G,$data;
		$config = self::$config;
		if(!$config['guide_open']) return;
	    if(!in_array('zhikai_n5appgl',$_G['setting']['plugins']['available']))return;
		if (file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_guide.php')) {
			@include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_guide.php';
		}
 		if(function_exists('zknvbing5_v2')){
		   zknvbing5_v2($data);
		}
    }

	function viewthread_postbottom_mobile_output(){
		global $_G,$postlist;
		$config = self::$config;
		if(empty($postlist) || !in_array($_G['fid'],dunserialize($config['forum_media']))) return;
		foreach($postlist as $key =>$val){
            $postlist[$key] = noattach_replace($val);
		}
    }
}

class mobileplugin_zhikai_n5video_group extends mobileplugin_zhikai_n5video {
	
	function post_bottom_mobile(){
		global $_G;
		$config = self::$config;
		if(in_array('zhikai_n5appgl',$_G['setting']['plugins']['available']))return;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) ) return;
		if($config['youkuup_open'] == 1){
			loadcache('groupreadaccess');
			$upfhash = self::$upfhash;
			$attachurl = self::$attachurl;
			$video = json_encode(explode('|',$config['video_bmp']));
			$voice = json_encode(explode('|',$config['voice_bmp']));
			include template('zhikai_n5video:up_file');
			return $file;
		}else if($config['youkuup_open'] == 2){
			youku_access_token($config);
			$youku_refresh = unserialize($_G['setting']['youku_refresh']);
			include template('zhikai_n5video:youkuup');
            return $return;
		}
	}

	function post_n5bottom_mobile(){
		global $_G;
		$config = self::$config;
		if(!in_array('zhikai_n5appgl',$_G['setting']['plugins']['available']))return;
		if(!in_array($_G['groupid'],dunserialize($config['forum_upus'])) ) return;
		if($config['youkuup_open'] == 1){
			loadcache('groupreadaccess');
			$upfhash = self::$upfhash;
			$attachurl = self::$attachurl;
			$video = json_encode(explode('|',$config['video_bmp']));
			$voice = json_encode(explode('|',$config['voice_bmp']));
			include template('zhikai_n5video:up_file');
			return $file;
		}else if($config['youkuup_open'] == 2){
			youku_access_token($config);
			$youku_refresh = unserialize($_G['setting']['youku_refresh']);
			include template('zhikai_n5video:youkuup');
            return $return;
		}
	}

	
	

	function forumdisplay_mobile_output(){
        global $_G;
		$config = self::$config;

		$tids = array();
		foreach($_G['forum_threadlist'] as $k => $v){
				$tids[] = $v['tid'];
		}
		if(empty($tids))return '';
		$result = DB::fetch_all('SELECT fid,pid,tid,message FROM '.DB::table('forum_post').' WHERE first=1 and tid in('.dimplode($tids).')');
		$resultlist = sortbytids($result, $tids);
		unset($tids);
		unset($result);
			foreach($_G['forum_threadlist'] as $key => $thread){
				$_G['setting']['pluginhooks']['forumdisplay_threadguide_mobile'][$key] = forumdisplay_replace(
						$resultlist[$thread['tid']]['message'],
						$resultlist[$thread['tid']]['tid'],
						$resultlist[$thread['tid']]['pid'],
						$resultlist[$thread['tid']]['fid']
				
				);
			}
    }
	
	function viewthread_postbottom_mobile_output(){
		global $_G,$postlist;
		$config = self::$config;
		if(empty($postlist) || !in_array($_G['fid'],dunserialize($config['forum_media']))) return;
		foreach($postlist as $key =>$val){
            $postlist[$key] = noattach_replace($val);
		}
    }
	
}

?>