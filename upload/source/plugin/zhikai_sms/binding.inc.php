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

if (!$_G['uid']){//请先登录 
	showmessage(lang('plugin/zhikai_sms', 'langssms061'), 'member.php?mod=logging&action=login&referer='.dreferer(),'error');
}

$config = config();
$phone = isphone_exist($_G['uid'], true);
$Bin_state = CheckBinPlugin_state($_G['uid']);
$phones = substr($phone, 0, 2).'*******'.substr($phone, -2);
$usnamecut = DB::result_first('select upusnamecut from %t where uid=%d', array('zhikai_userdata',$_G['uid']));

$usnamecut = $config['username_amend'] - $usnamecut;
?>