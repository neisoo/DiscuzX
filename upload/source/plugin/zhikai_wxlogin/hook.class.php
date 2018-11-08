<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_zhikai_wxlogin {

	function global_usernav_extra1(){
		global $_G;
		$return = '';
		if($_G['uid']){
			$bind = getcookie("zhikai_wxlogin_bind");
			if(!$bind){//检查是否查询过
				$check = C::t("#zhikai_wxlogin#users")->fetch_by_uid($_G['uid']);
				if(!$check){//没绑定过
					$return = '
					<span class="pipe">|</span><a id="zhikai_wxlogin" href="javascript:;" onclick="showWindow(\'zhikai_wxlogin\', \'plugin.php?id=zhikai_wxlogin&mod=qrcode\');return false;"><img class="qq_bind" align="absmiddle" src="source/plugin/zhikai_wxlogin/static/image/wechat_bind.png"></a>
					';
					dsetcookie("zhikai_wxlogin_bind",1);
				}else{
					dsetcookie("zhikai_wxlogin_bind",$check['openid']);
				}
			}else{//查询过
				if(intval($bind)==1){//查询过没绑定过
					$return = '
					<span class="pipe">|</span><a id="zhikai_wxlogin" href="javascript:;" onclick="showWindow(\'zhikai_wxlogin\', \'plugin.php?id=zhikai_wxlogin&mod=qrcode\');return false;"><img class="qq_bind" align="absmiddle" src="source/plugin/zhikai_wxlogin/static/image/wechat_bind.png"></a>
					';
				}
			}
		}
		return $return;
	}

	function global_login_text(){
		$return = '
					<span class="pipe">|</span><a id="zhikai_wxlogin" href="javascript:;" onclick="showWindow(\'zhikai_wxlogin\', \'plugin.php?id=zhikai_wxlogin&mod=qrcode\');return false;"><img align="absmiddle" src="source/plugin/zhikai_wxlogin/static/image/wechat_login.png"></a>
					';
		return $return;
	}

	function global_login_extra(){
		global $_G;
		$retrun= '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">
	<p><a href="javascript:;" onclick="showWindow(\'zhikai_wxlogin\', \'plugin.php?id=zhikai_wxlogin&mod=qrcode\');return false;"><img src="source/plugin/zhikai_wxlogin/static/image/wechat_login.png"></a></p>
	<p class="hm xg1" style="padding-top: 2px;">'.lang('plugin/zhikai_wxlogin', 'slang01').'</p>
	</div>';
		return $retrun;
	}

	function register_message(){
		global $_G;
		$messageparam = $_G['messageparam'];
		$uid = $messageparam[2]['uid'];
		if($uid && $_GET['openid']){
			$data['openid'] = addslashes($_GET['openid']);
			$data['uid'] = 	$uid;
			$checkUser = C::t("#zhikai_wxlogin#users")->fetch_by_openid($openid);
			if(!$checkUser){
				C::t("#zhikai_wxlogin#users")->insert($data);
			}
		}
		$_G['messageparam']=$messageparam;
	}

}

class plugin_zhikai_wxlogin_member extends plugin_zhikai_wxlogin{
	function register_input() {
		global $_G;
		$openid = getcookie("openid");
		$return = '';
		if($openid){
			$return = '<input type="hidden" value="'.$openid.'" name="openid">';
		}

		return $return;
	}

	function logging_method(){
		global $_G;
		$return = '
					<a id="zhikai_wxlogin" href="javascript:;" onclick="showWindow(\'zhikai_wxlogin\', \'plugin.php?id=zhikai_wxlogin&mod=qrcode\');return false;"><img align="absmiddle" src="source/plugin/zhikai_wxlogin/static/image/wechat_login.png"></a><span class="pipe">|</span>
					';
		return $return;
	}

	function register_logging_method(){
		global $_G;
		$return = '
					<span class="pipe">|</span><a id="zhikai_wxlogin" href="javascript:;" onclick="showWindow(\'zhikai_wxlogin\', \'plugin.php?id=zhikai_wxlogin&mod=qrcode\');return false;"><img align="absmiddle" src="source/plugin/zhikai_wxlogin/static/image/wechat_login.png"></a>
					';
		return $return;
	}
}

?>