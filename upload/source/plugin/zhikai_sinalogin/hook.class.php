<?php

/**
 * 
 * 大叔来出品 必属精品
 * 大叔来  全网首发 https://www.dashulai.com
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！永久免费下载本站所有资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * [大叔来]用户交流群: ①群306115775
 * 永久域名：http://www.dashulai.Com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_zhikai_sinalogin {
	function global_login_extra(){
		global $_G;
		return $this->zhikai_sinalogin_show(2);
	}

	function global_login_text(){
		global $_G;
		return $this->zhikai_sinalogin_show(3);
	}

	function global_usernav_extra4(){
		global $_G;
		if(getcookie("zhikai_sinalogin") == 2){
			return '';
		}elseif(!getcookie("zhikai_sinalogin") ){
			$bindinfo = C::t("#zhikai_sinalogin#bind")->fetch_by_uid($_G['uid']);
			if($bindinfo){
				dsetcookie('zhikai_sinalogin',2);//绑定
				return '';
			}else{
				dsetcookie('zhikai_sinalogin',1);//未绑定
			}
		}
		return $this->zhikai_sinalogin_show(4);
	}

	public function zhikai_sinalogin_show($type = 1){
		global $_G;
		if($_G['uid'] && $type != 4) return '';
		include template("zhikai_sinalogin:login".$type);
		return $return;
	}
}

class plugin_zhikai_sinalogin_member extends plugin_zhikai_sinalogin{
	function logging_method(){
		global $_G;
		return $this->zhikai_sinalogin_show();
	}
	function register_logging_method(){
		global $_G;
		return $this->zhikai_sinalogin_show();
	}

	function post_btn_extra(){
		global $_G;
		if(!file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/postsend.php') && $_G['cache']['plugin']['zhikai_sinalogin']['postsend'] ) return '';
		include template("zhikai_sinalogin:postsend");
		return $return;
	}
}
class plugin_zhikai_sinalogin_forum extends plugin_zhikai_sinalogin{
	function post_btn_extra(){
		global $_G;
		if(getcookie("zhikai_sinalogin") != 2 || !$_G['uid']) return '';//没绑定
		if(!in_array($_GET['action'] ,array( 'newthread' , 'reply') ) ) return '';//非发帖
		if(
			(!file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/postsend.php') || !$_G['cache']['plugin']['zhikai_sinalogin']['postsend'])
			||
			(!file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/replysend.php') || !$_G['cache']['plugin']['zhikai_sinalogin']['replysend'])
			
		) return '';//未设置
		if($_GET['action'] == 'reply'){
			if(!C::t("#zhikai_sinalogin#thread")->fetch($_G['tid'])) return '';
		}
		$template = $_GET['action'] == 'reply'?'replysend':'postsend';
		include template("zhikai_sinalogin:".$template);
		return $return;
	}

	function viewthread_fastpost_btn_extra(){
		global $_G;
		if(getcookie("zhikai_sinalogin") != 2 || !$_G['uid']) return '';//没绑定
		if(!file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/replysend.php') || !$_G['cache']['plugin']['zhikai_sinalogin']['replysend']) return '';//未设置
		if(!C::t("#zhikai_sinalogin#thread")->fetch($_G['tid'])) return '';
		include template("zhikai_sinalogin:replysend");
		return $return;
	}

	function forumdisplay_fastpost_btn_extra(){
		global $_G;
		if(getcookie("zhikai_sinalogin") != 2) return '';//没绑定
		if(!file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/postsend.php') || !$_G['cache']['plugin']['zhikai_sinalogin']['postsend']) return '';//未设置
		include template("zhikai_sinalogin:postsend");
		return $return;
	}

	function post_message($value){
		global $_G;
		$param = $value['param'];
		if($param[0] == 'post_newthread_succeed'){
			if(file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/postsend.php') && $_G['cache']['plugin']['zhikai_sinalogin']['postsend']){
				include DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/postsend.php';
			}
		}elseif($param[0] == 'post_reply_succeed'){
			if(file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/replysend.php') && $_G['cache']['plugin']['zhikai_sinalogin']['replysend']){
				include DISCUZ_ROOT.'./source/plugin/zhikai_sinalogin/extends/replysend.php';
			}
		}
		return '';
	}
}
//From:www_Dashulai_co
?>