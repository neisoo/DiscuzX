<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 微信手机版登陆
 */
checkIsWechat();
$data = array();
if($_G['uid']){
	$data['uid'] = $_G['uid'];
}
$data['dateline'] = $_G['timestamp'];
$data['code'] = $hash = random(10);
C::t("#zhikai_wxlogin#code")->insert($data);
$url = $_G['siteurl']."plugin.php?id=zhikai_wxlogin&mod=access&hash=".$hash;
dheader("Location: ".$url);

/**
 * 判断是否是微信浏览器
 */
function checkIsWechat(){
	$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if (strpos($user_agent, 'micromessenger') === false) {
	    // 非微信浏览器禁止浏览
	    showmessage(lang('plugin/zhikai_wxlogin', 'slang20'),"index.php");
	} 
}

?>