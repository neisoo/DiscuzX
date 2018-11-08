<?php
/*
 * 出处：大-叔-来
 * 官网: Www.dashulai.com
 * 备用网址: www.dashulai.Com (请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：QQ 986692927
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function send_post($url,$post_data = array() ) {
	$headers = array(
		"content-type: application/x-www-form-urlencoded",
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_ENCODING, '');
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}



function duserlogin($uid,$msg,$referer){
	$user = getuserbyuid($uid);
	require_once libfile('function/member');
	setloginstatus($user, 2592000);
	dsetcookie('zhikai_sinalogin',2);
	showmessage($msg,$referer);
}

function get_access_token(){
	global $pvars,$_G;
	$url = 'https://api.weibo.com/oauth2/access_token?client_id='.$pvars['appkey'];
	$url .= '&client_secret='.$pvars['appsecret'].'&grant_type=authorization_code&redirect_uri='.urlencode($_G['siteurl']."plugin.php?id=zhikai_sinalogin").'&code='.$_GET['code'];
	$json = send_post($url);
	$data = json_decode($json,true);
	return $data;
}

function users_show($access_token , $uid = ''){
	$getway = 'https://api.weibo.com/2/users/show.json?';
	$getway .= 'access_token='.$access_token;
	$getway .= ($uid?'&uid='.$uid:'');
	$json = dfsockopen($getway);
	$data = json_decode($json,true);
	return $data;
}
//WWW.dashulai.com
?>