<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$mod = $_GET['mod'];
$modArray = array("qrcode","access","check","tip");
$pvars = $_G['cache']['plugin']['zhikai_wxlogin'];
if(in_array($mod, $modArray)){
	$file = DISCUZ_ROOT . './source/plugin/zhikai_wxlogin/module/'.$mod.'.php';
	require $file;
}else{
	showmessage("undefined_action");
}

?>