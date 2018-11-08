<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$data = array();
if($_G['uid']){//检查是否绑定过
	$checkUser = C::t("#zhikai_wxlogin#users")->fetch_by_uid($_G['uid']);
	if($checkUser){
		showmessage(lang('plugin/zhikai_wxlogin', 'slang14'));
	}
	$data['uid'] = $_G['uid'];
}
$data['dateline'] = $_G['timestamp'];
$data['code'] = $hash = random(10);
C::t("#zhikai_wxlogin#code")->insert($data);
$url = $_G['siteurl']."plugin.php?id=zhikai_wxlogin&mod=access&hash=".$hash;
$qrsize = 5;
$dir = 'data/cache/qrcode/';//存储路径
$file = $dir.'zhikai_wxlogin_'.$random.'.jpg';
if(!file_exists($file) || !filesize($file)) {
	dmkdir($dir);
	require_once DISCUZ_ROOT.'source/plugin/mobile/qrcode.class.php';
	QRcode::png($url, $file, QR_ECLEVEL_Q, $qrsize);
}
$qrcode = base64_encode(file_get_contents($file));
unlink($file);
include template("zhikai_wxlogin:qrcode");
?>