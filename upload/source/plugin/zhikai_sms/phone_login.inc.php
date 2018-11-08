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

$motion = daddslashes($_GET['motion']);
$phone = daddslashes($_GET['phone']);
$code = daddslashes($_GET['code']);
$send_type = daddslashes($_GET['send_type']);
$config = config();
$msgarr = array();

if(!$motion){
	include template('zhikai_sms:phone_login');
}else if($motion == 'phonelogin' && $_GET['formhash'] == FORMHASH){
	if(empty($phone) || !isphone($phone)){
	   $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms064');
	   sms_arrjson($msgarr);
	}

    if(CodeCheck($send_type, $phone, $code) == false){
		$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms063');
		sms_arrjson($msgarr);
	}
	list($seccodecheck, $secqaacheck) = seccheck('login');//登录是否开启验证
	//验证码验证 $config['seccode_open']
    if($config['seccode_open'] && !_submitcheck('phoneloginsubmit',1,$seccodecheck)){
	    $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms0115');
        sms_arrjson($msgarr);
    }else if(submitcheck('phoneloginsubmit')){

	    $retarr = phone_login($send_type, $phone, $code);
		if($retarr['state'] && $retarr['login']){
		    $msgarr['succeed'] = $retarr['statemsg'];
		    sms_arrjson($msgarr);
		}else if($retarr['state'] && $retarr['register']){
		    $msgarr['succeed'] = $retarr['statemsg'];
		    sms_arrjson($msgarr);
		}else{

			$msgarr['error'] = $retarr['statemsg'];
			sms_arrjson($msgarr);
		}
	}
	$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms070');
    sms_arrjson($msgarr);
}
//From:www_dashulai.com
?>