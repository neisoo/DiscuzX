<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$hash = addslashes($_GET['hash']);
$codeInfo = C::t("#zhikai_wxlogin#code")->fetch_by_code($hash);
if($_G['uid']){//登陆过
	$checkUser = C::t("#zhikai_wxlogin#users")->fetch_by_uid($_G['uid']);//检查是否绑定成功
	if($codeInfo['openid']){
		$user = C::t("#zhikai_wxlogin#users")->fetch_by_openid($codeInfo['openid']);
		if($user['uid'] != $_G['uid']){
			echo '<root>4</root>';exit;
		}
	}
	if($checkUser){
		dsetcookie("zhikai_wxlogin_bind",$checkUser['openid']);
		echo '<root>1</root>';exit;
	}else{
		echo '<root>0</root>';exit;
	}
}else{
	if($codeInfo['openid']){
		$checkUser = C::t("#zhikai_wxlogin#users")->fetch_by_openid($codeInfo['openid']);
		//登陆
		require_once libfile('function/member');
		$uid = $checkUser['uid'];
		//登陆
		if(!($member = getuserbyuid($uid, 1))) {
			echo '<root>3</root>';exit;
		} else {
			if(isset($member['_inarchive'])) {
				C::t('common_member_archive')->move_to_master($uid);
			}
		}
		$cookietime = 1296000;
		setloginstatus($member, $cookietime);
		dsetcookie("zhikai_wxlogin_bind",$checkUser['openid']);
		//更改通知状态
		C::t("#zhikai_wxlogin#code")->delete_by_openid($codeInfo['openid']);
		echo '<root>2</root>';exit;
	}else{
		echo '<root>0</root>';exit;
	}
}

?>