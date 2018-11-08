<?php
/*
 * CopyRight  : [dashulai.com!] (C)2014-2018
 * Document   : 大叔来：www.dashulai.com，www.dashulai.Com
 * Created on : 2018-04-16,10:01:59
 * Author     : 大叔来(QQ：986692927) wWw.dashulai.com $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              大.叔.来出品 必属精品。
 *              大.叔.来 全网首发 https://Www.dashulai.com；
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once libfile('function/common','plugin/zhikai_sms');
$config = config();

if(!$_G['uid'] && checkmobile()){
	
	include template('zhikai_sms:getpass');
}else{
	
	dheader('location: '.$_G['siteurl']);
}
//From:www_dashulai.com
?>