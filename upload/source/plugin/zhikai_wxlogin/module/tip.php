<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$op = $_GET['op'];
$url ="index.php";
$tip = lang('plugin/zhikai_wxlogin', 'slang15');
$alert = 'error';
$closetime = 1;
if($op=='bindsuccess'){
	$tip = lang('plugin/zhikai_wxlogin', 'slang16');
	$alert = 'right';
	$url = "home.php?mod=spacecp&ac=plugin&id=zhikai_wxlogin:wechat";
	$closetime = 0;
}elseif($op=='loginsuccess'){
	$tip = lang('plugin/zhikai_wxlogin', 'slang17');
	$url = "index.php";
	$alert = 'right';
	$closetime = 0;
}elseif($op=='error'){
	$tip = lang('plugin/zhikai_wxlogin', 'slang18');
	$url = "index.php";
	$alert = 'error';
	$closetime = 1;
}elseif($op=='binderror'){
	$tip = lang('plugin/zhikai_wxlogin', 'slang19');
	$url = "index.php";
	$alert = 'error';
	$closetime = 1;
}
$ext = array('alert' => $alert, 'showdialog' => 1);
if($closetime){
	$ext['closetime'] =3;
}else{
	$ext['locationtime'] =3;
}
showmessage($tip, $url, array(), $ext);
?>