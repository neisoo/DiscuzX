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
$send_type = daddslashes($_GET['send_type']);
$config = config();
$msgarr = array();

if($_GET['formhash'] != FORMHASH){
   $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms079');
   sms_arrjson($msgarr);
}

if(!$_GET['newusername']){//如果不是修改用户名在判断手机号必须存在
	if(empty($phone) || !isphone($phone)){
	   $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms064');
	   sms_arrjson($msgarr);
	}
}

if($motion == 'smssend' && $phone && $send_type){
	
	if(($config['dxbzh'] && $config['dxbkey']) || ($config['accessid'] && $config['accesskey'])){
		//限制验证码发送次数
		if(Code_Conunt($send_type, $phone)){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms093');
		}else if(sendsms($send_type, $phone)){
			$msgarr['succeed'] = 'ok';
		}else{
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms080');
		}
		sms_arrjson($msgarr);
	
	}else{
		$msgarr['error'] = 'no key';
		sms_arrjson($msgarr);
	}
	
}else if($motion == 'register' && $phone && $send_type){//手机号+密码注册
	$username = daddslashes($_GET['username']);
	
	if(!checkmobile()){
	  $username = diconv($_GET['username'], 'utf-8', CHARSET);
	}
	
	$password1 = daddslashes($_GET['password1']);
	$password2 = daddslashes($_GET['password2']);
	$code = daddslashes($_GET['code']);

	require_once libfile('function/member');
	loaducenter();
	$user = array();
	$user['email'] = 'phone_'.strtolower(random(10)).$config['emall'];

	//注册协议
	$bbrulehash = $_G['setting']['bbrules'] ? substr(md5(FORMHASH), 0, 8) : '';
	if($_G['setting']['bbrules'] && $bbrulehash != $_POST['smsagreebbrule']){
		$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms114');
		sms_arrjson($msgarr);
	}

	//短信验证码审核
	if(!CodeCheck($send_type, $phone, $code)){
		$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms063');
		sms_arrjson($msgarr);
	}

	list($seccodecheck, $secqaacheck) = seccheck('register');//注册是否开启验证
	//验证码验证 $config['seccode_open']
    if($config['seccode_open'] && !_submitcheck('smsregsubmit',1,$seccodecheck)){
	    $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms115');
        sms_arrjson($msgarr);
    }else if(submitcheck('smsregsubmit')){
		$isuid = get_useruid($phone);
		if(!empty($isuid)){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms116');
			sms_arrjson($msgarr);
		}

		if(!empty($username)){
			$usernamelen = dstrlen($username);
			if($usernamelen < 3) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms117');
				sms_arrjson($msgarr);
			}else if($usernamelen > 15) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms118');
				sms_arrjson($msgarr);
			}

			if(C::t('common_member')->fetch_uid_by_username($username) || C::t('common_member_archive')->fetch_uid_by_username($username)) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms119');
				sms_arrjson($msgarr);
			}
			$user['username'] = $username;
		}else{
			$uname = $config['prefix'].'_'.$phone;
			$user['username'] = get_regname($uname);
		}

		if($_G['setting']['pwlength']) {
			if(strlen($_GET['password1']) < $_G['setting']['pwlength']) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms086').$_G['setting']['pwlength'].lang('plugin/zhikai_sms', 'langssms087');
				sms_arrjson($msgarr);
			}
		}
		if($_G['setting']['strongpw']) {
			$strongpw_str = array();
			if(in_array(1, $this->setting['strongpw']) && !preg_match("/\d+/", $_GET['password1'])) {
				$strongpw_str[] = lang('member/template', 'strongpw_1');
			}
			if(in_array(2, $this->setting['strongpw']) && !preg_match("/[a-z]+/", $_GET['password1'])) {
				$strongpw_str[] = lang('member/template', 'strongpw_2');
			}
			if(in_array(3, $this->setting['strongpw']) && !preg_match("/[A-Z]+/", $_GET['password1'])) {
				$strongpw_str[] = lang('member/template', 'strongpw_3');
			}
			if(in_array(4, $this->setting['strongpw']) && !preg_match("/[^a-zA-z0-9]+/", $_GET['password1'])) {
				$strongpw_str[] = lang('member/template', 'strongpw_4');
			}
			if($strongpw_str) {
				$msgarr['error'] = lang('member/template', 'password_weak').implode(',', $strongpw_str);
				sms_arrjson($msgarr);
			}
		}
		if($_GET['password1'] !== $_GET['password2']) {
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms088');
			sms_arrjson($msgarr);
		}
		if(!$_GET['password1'] || $_GET['password1'] != $password1) {
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms120');
			sms_arrjson($msgarr);
		}

		if($_G['cache']['ipctrl']['ipregctrl']) {
			foreach(explode("\n", $_G['cache']['ipctrl']['ipregctrl']) as $ctrlip) {
				if(preg_match("/^(".preg_quote(($ctrlip = trim($ctrlip)), '/').")/", $_G['clientip'])) {
					$ctrlip = $ctrlip.'%';
					$_G['setting']['regctrl'] = $_G['setting']['ipregctrltime']; 
					break;
				} else {
					$ctrlip = $_G['clientip'];
				}
			}
		} else {
			$ctrlip = $_G['clientip'];
		}
		if($_G['setting']['regctrl']) {
			if(C::t('common_regip')->count_by_ip_dateline($ctrlip, $_G['timestamp']-$_G['setting']['regctrl']*3600)) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms121').$_G['setting']['regctrl'].lang('plugin/zhikai_sms', 'langssms122');
				sms_arrjson($msgarr);
			}
		}
		$setregip = null;
		if($_G['setting']['regfloodctrl']) {
			$regip = C::t('common_regip')->fetch_by_ip_dateline($_G['clientip'], $_G['timestamp']-86400);
			if($regip) {
				if($regip['count'] >= $_G['setting']['regfloodctrl']) {
					$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms123').$_G['setting']['regfloodctrl'].lang('plugin/zhikai_sms', 'langssms124');
					sms_arrjson($msgarr);
				} else {
					$setregip = 1;
				}
			} else {
				$setregip = 2;
			}
		}

		$uid = uc_user_register($user['username'], $password1, $user['email'], '', '', $_G['clientip']);
		if($uid <= 0) {
			if($uid == -1) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms125');
			} elseif($uid == -2) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms126');
			} elseif($uid == -3) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms127');
			} elseif($uid == -4) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms128');
			} elseif($uid == -5) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms129');
			} elseif($uid == -6) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms130');
			} else {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms131');
			}
			sms_arrjson($msgarr);
		}

		$id = get_smslist($send_type, $phone, $code);
		if($uid > 0 && $id){
			if($setregip !== null) {
				if($setregip == 1) {
					C::t('common_regip')->update_count_by_ip($_G['clientip']);
				} else {
					C::t('common_regip')->insert(array('ip' => $_G['clientip'], 'count' => 1, 'dateline' => $_G['timestamp']));
				}
			}
			$groupid = $config['groupid'] ? $config['groupid'] : 10;
			$init_arr = array('credits' => explode(',', $_G['setting']['initcredits']),'emailstatus' => 0);
			C::t('common_member')->insert($uid, $user['username'], md5(random(10)), $user['email'], $_G['clientip'], $groupid, $init_arr);

			if($_G['setting']['regctrl'] || $_G['setting']['regfloodctrl']) {
				C::t('common_regip')->delete_by_dateline($_G['timestamp']-($_G['setting']['regctrl'] > 72 ? $_G['setting']['regctrl'] : 72)*3600);
				if($_G['setting']['regctrl']) {
					C::t('common_regip')->insert(array('ip' => $_G['clientip'], 'count' => -1, 'dateline' => $_G['timestamp']));
				}
			}

			$result = uc_user_login($user['username'],$password1,0);
			if ($result[0] > 0) {
				$member = getuserbyuid($result[0], 1);
				if(isset($member['_inarchive'])) {
					C::t('common_member_archive')->move_to_master($result[0]);
				}
				$cookietime = 1296000;
				setloginstatus($member, $cookietime);
				dsetcookie('lip', $_G['member']['lastip'].','.$_G['member']['lastvisit']);
				C::t('common_member_status')->update($result[0], array('lastip' => $_G['clientip'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
				
				//
				include_once libfile('function/stat');
				updatestat('register');
				if(!function_exists('build_cache_userstats')) {
					require_once libfile('cache/userstats', 'function');
				}
				build_cache_userstats();
				//
				
				addphone($phone, $result[0]);
				update_smslist($id, $result[0]);
				if($config['setverify']){
					phone_setverify($result[0]);
				}

                Dz_welcome($result[0]);//欢迎通知

				$group = C::t('common_usergroup')->range();
				$msgarr['succeed'] = lang('plugin/zhikai_sms', 'langssms132').$group[$groupid]['grouptitle'];
				sms_arrjson($msgarr);
			}
		}
	}
	$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms133');
	sms_arrjson($msgarr);
}else if(($motion == 'bin' || $motion == 'upbin') && $phone){//绑定 修改绑定 

    if(submitcheck('binsubmit') && $_G['uid']){
		$code = daddslashes($_GET['code']);
		if(isphone_exist($phone)){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms081');
			sms_arrjson($msgarr);
		}
		if(CodeCheck($send_type, $phone, $code) == false){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms063');
			sms_arrjson($msgarr);
		}
		if(!empty($phone) && !isphone($phone)){
		   $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms064');
		   sms_arrjson($msgarr);
		}
		
		addphone($phone, $_G['uid']);//增加手机号

		$id = get_smslist($send_type, $phone, $code);//取到表ID

		if($id){

			if($config['setverify']){
				phone_setverify($_G['uid']);
			}

			update_smslist($id, $_G['uid']);
			
			if($motion == 'bin'){
				$msgarr['succeed'] = lang('plugin/zhikai_sms', 'langssms065');
			}else if($motion == 'upbin'){
				$msgarr['succeed'] = lang('plugin/zhikai_sms', 'langssms066');
			}
              sms_arrjson($msgarr);    
		}else{
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms067');
			sms_arrjson($msgarr);
		}
	  
	}
}else if($motion == 'verify' && $phone){//手机认证操作
    if(submitcheck('verifysubmit') && $_G['uid']){
		$code = daddslashes($_GET['code']);
		$Bin_state = CheckBinPlugin_state($_G['uid']);
		if(!isphone_exist($phone) || $Bin_state != 1){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms082');
			sms_arrjson($msgarr);
		}
		if(CodeCheck($send_type, $phone, $code) == false){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms063');
			sms_arrjson($msgarr);
		}
		if(!empty($phone) && !isphone($phone)){
		   $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms064');
		   sms_arrjson($msgarr);
		}
		if(isphone_verify($_G['uid'])){
		   $msgarr['error'] = lang('plugin/zhikai_sms', 'langssms083');
		   sms_arrjson($msgarr);
		}
		
		$id = get_smslist($send_type, $phone, $code);
		if($id){
			phone_setverify($_G['uid']);
			update_smslist($id, $_G['uid']);
			dsetcookie('remind_time', '');
			$msgarr['succeed'] = lang('plugin/zhikai_sms', 'langssms084');
		}else{
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms063');
		}
	   sms_arrjson($msgarr);
	}
}else if($motion == 'retrievepswd' && $phone){//手机验证重置密码
	if(submitcheck('retrievepswdsubmit')){
       $newpasswd1 = daddslashes($_GET['newpasswd1']);
       $newpasswd2 = daddslashes($_GET['newpasswd2']);
       $code = daddslashes($_GET['code']);
		if(!isphone_exist($phone)){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms085');
			sms_arrjson($msgarr);
		}
		if($_G['setting']['pwlength'] && strlen($newpasswd1) < $_G['setting']['pwlength']) {
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms086').$_G['setting']['pwlength'].lang('plugin/zhikai_sms', 'langssms087');
			sms_arrjson($msgarr);
		}
		if($newpasswd1 !== $newpasswd2){
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms088');
			sms_arrjson($msgarr);
		}
		if(!$_GET['newpasswd1'] || $_GET['newpasswd1'] != $newpasswd1) {
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms120');
			sms_arrjson($msgarr);
		}
		if($_G['setting']['strongpw']) {
			$strongpw_str = array();
			if(in_array(1, $_G['setting']['strongpw']) && !preg_match("/\d+/", $newpasswd1)) {
				$strongpw_str[] = lang('member/template', 'strongpw_1');
			}
			if(in_array(2, $_G['setting']['strongpw']) && !preg_match("/[a-z]+/", $newpasswd1)) {
				$strongpw_str[] = lang('member/template', 'strongpw_2');
			}
			if(in_array(3, $_G['setting']['strongpw']) && !preg_match("/[A-Z]+/", $newpasswd1)) {
				$strongpw_str[] = lang('member/template', 'strongpw_3');
			}
			if(in_array(4, $_G['setting']['strongpw']) && !preg_match("/[^a-zA-z0-9]+/", $newpasswd1)) {
				$strongpw_str[] = lang('member/template', 'strongpw_4');
			}
			if($strongpw_str) {
				$msgarr['error'] = lang('member/template', 'password_weak').implode(',', $strongpw_str);
				sms_arrjson($msgarr);
			}
		}
		//手机短信验证码是否过期
		if(CodeCheck($send_type, $phone, $code) == false) {
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms063');
			sms_arrjson($msgarr);
		}
	    $uid = get_useruid($phone);
		$id = get_smslist($send_type, $phone, $code);
		if($uid && $id){
			loaducenter();
			$member = getuserbyuid($uid);
			uc_user_edit($member['username'], $newpasswd1, $newpasswd1, '', 1, 0);
			notification_add($uid, 'system', lang('plugin/zhikai_sms', 'langssms089').$member['username'].lang('plugin/zhikai_sms', 'langssms090'), array(), 1);
			update_smslist($id, $uid);
			$password = md5(random(10));
			C::t('common_member')->update($uid, array('password' => $password));
	        $msgarr['succeed'] = 'ok';
			sms_arrjson($msgarr);
		}else{
			$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms094');
			sms_arrjson($msgarr);
		}
	}
}else if($motion == 'nameedit' && $_G['uid']){//修改用户名
	$newusername = urldecode(daddslashes($_GET['newusername']));
	$newusername = diconv($newusername, 'utf-8', CHARSET);

	if(submitcheck('namesubmit') && $newusername){
		include_once libfile('function/editusername','plugin/zhikai_sms');
		loaducenter();
		
		if(!empty($newusername)){
			$namelen = dstrlen($newusername);
			if($namelen < 3) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms117');
				sms_arrjson($msgarr);
			}else if($namelen > 15) {
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms118');
				sms_arrjson($msgarr);
			}
		}

        $checkname = uc_user_checkname($newusername);

 		if($checkname == 1 && $newusername){
			$phone = isphone_exist($_G['uid'], true);
            $cid = CheckBinPlugin($_G['uid']);//判断zhikai_userdata表数据必须存在
			if(empty($phone) && !$cid){//尚未绑定手机
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms141');
				sms_arrjson($msgarr);
			}

			$usnamecut = DB::result_first('select upusnamecut from %t where uid=%d', array('zhikai_userdata',$_G['uid']));
			if($usnamecut < $config['username_amend']){//如果修改次数小于限制次数 可更新

				if(DZ_modification_name($_G['uid'], $newusername)){
					//更新修改次数
					DB::query('update %t set upusnamecut=%d where uid=%d',array('zhikai_userdata', $usnamecut + 1, $_G['uid']));
					$msg = lang('plugin/zhikai_sms', 'langssms134').$newusername;
					notification_add($rename_info['uid'],'system', $msg, array(), 1);
					$msgarr['succeed'] = $msg;
				}else{
					$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms135');
				}
				sms_arrjson($msgarr);

			}else{
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms142');
				sms_arrjson($msgarr);
			}

		}else{
			if($checkname == -1){
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms136');
			}else if($checkname == -2){
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms137');
			}else if($checkname == -3){
				$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms138');
			}
			sms_arrjson($msgarr);
		}
	}else{
		$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms079');
		sms_arrjson($msgarr);
	}
}

$msgarr['error'] = lang('plugin/zhikai_sms', 'langssms092');
sms_arrjson($msgarr);
?>