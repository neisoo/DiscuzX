<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * ΢���ֻ����½
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
 * �ж��Ƿ���΢�������
 */
function checkIsWechat(){
	$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if (strpos($user_agent, 'micromessenger') === false) {
	    // ��΢���������ֹ���
	    showmessage(lang('plugin/zhikai_wxlogin', 'slang20'),"index.php");
	} 
}

?>