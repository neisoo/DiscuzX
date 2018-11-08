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
$bind = $_G['uid'] ? true : false;
$pvars = $_G['cache']['plugin']['zhikai_sinalogin'];
include_once libfile("function/core",'plugin/zhikai_sinalogin');
$referer = $_GET['referer']?urldecode($_GET['referer']):dreferer();
if($_GET['code']){
	if($_GET['state']) $referer = urldecode($_GET['state']);
	$data = get_access_token();
	if(!$data['access_token']){
		showmessage(lang('plugin/zhikai_sinalogin','XE3YAi').$data['error_code']);
	}
	$access_token = daddslashes($data['access_token']);
	$connect_uid = dintval( $data['uid']);
	$guest = C::t("#zhikai_sinalogin#guest")->fetch($access_token);
	if(!$guest){
		$userinfo = users_show($access_token,$connect_uid);
		$userinfo['gender'] = strtolower($userinfo['gender']);
		$guest = array();
		$guest['openid'] 		= $access_token;
		$guest['connect_uid'] 	= $connect_uid;
		$guest['screen_name'] 	= strtolower($_G['charset']) != 'utf-8' ? mb_convert_encoding($userinfo['screen_name'],$_G['charset'],'utf-8') :$userinfo['screen_name'];
		$guest['gender'] 		= $userinfo['gender'] == 'm' ? 1 : ($userinfo['gender'] == 'f' ? 2 : 0);
		$guest['avatar'] 		= $userinfo['avatar_hd'];
		C::t("#zhikai_sinalogin#guest")->insert($guest);
	}
	if($_G['uid']){//绑定
		$bindinfo = C::t("#zhikai_sinalogin#bind")->fetch($access_token);
		if($bindinfo){
			showmessage(lang('plugin/zhikai_sinalogin','Lk0Ys8'));
		}
		$user = array();
		$user['uid'] = $_G['uid'];
		$user['openid'] = $guest['openid'];
		C::t("#zhikai_sinalogin#bind")->insert($user);
		dsetcookie('zhikai_sinalogin',2);
		showmessage(lang('plugin/zhikai_sinalogin','D3iAEt'),$referer);
	}else{//未登录
		$bindinfo = C::t("#zhikai_sinalogin#bind")->fetch($access_token);
		if($bindinfo['uid']){
			duserlogin($bindinfo['uid'],lang('plugin/zhikai_sinalogin','LEmEM3'),$referer);
		}else{
			dheader('location:plugin.php?id=zhikai_sinalogin&mod=reg&openid='.urlencode($access_token).'&referer='.urlencode($referer));
		}
	}
}elseif($_GET['mod'] == 'reg'){
	$openid = urldecode($_GET['openid']);
	$bindinfo = C::t("#zhikai_sinalogin#bind")->fetch($openid);
	if($bindinfo['uid']){
		duserlogin($bindinfo['uid'],lang('plugin/zhikai_sinalogin','LEmEM3'),$referer);
	}
	$guest = C::t("#zhikai_sinalogin#guest")->fetch($openid);
	if(!$guest) showmessage(lang('plugin/zhikai_sinalogin','XE3YAi')."0");
	if(submitcheck('regsubmit')){
		if($_GET['pwd1'] != $_GET['pwd2'] ) showmessage(lang('plugin/zhikai_sinalogin','bclU84'));
		if(strlen($_GET['pwd1']) < 6) showmessage(lang('plugin/zhikai_sinalogin','S54L8e'));
		if(!isemail($_GET['email'])) showmessage(lang('plugin/zhikai_sinalogin','Q4GCl8'));
		$password = addslashes($_GET['pwd1']);
		//添加用户
		$ip = $_G['clientip'];
		$user = array();
		$user['name'] = addslashes($_GET['username']);
		$user['pwd'] = $password;
		$user['email'] = daddslashes($_GET['email']);
		loaducenter();
		$uid = uc_user_register($user['name'], $user['pwd'], $user['email']);
		$errors = array(
			'-1'=>lang('plugin/zhikai_sinalogin','fZGc7a'),
			'-2'=>lang('plugin/zhikai_sinalogin','K7Ulk4'),
			'-3'=>lang('plugin/zhikai_sinalogin','w7Gg8E'),
			'-4'=>lang('plugin/zhikai_sinalogin','g44CsC'),
			'-5'=>lang('plugin/zhikai_sinalogin','Pmzl4u'),
			'-6'=>lang('plugin/zhikai_sinalogin','DZ7vva')
		);
		if($uid<=0){
			showmessage($errors[$uid]);
		}  
		C::t('common_member')->insert($uid, $user['name'], md5(random(10)), $user['email'], $ip, $_G['setting']['newusergroupid'], null);
		//推广注册
		if($_G['cookie']['promotion']){
			$fromuid = $_G['cookie']['promotion'];
			if($fromuid) {
				updatecreditbyaction('promotion_register', $fromuid);
				dsetcookie('promotion', '');
			}
		}
		//初始化积分
		$defaultext = array();
		$initcredits = explode(",",$_G['setting']['initcredits']);
		foreach($initcredits as $keyNum => $initcredit){
			if($keyNum>0 && $initcredit){
				$defaultext['extcredits'.$keyNum] = $initcredit;
			}
		}
		updatemembercount($uid, $defaultext, 1);
		$user = array();
		$user['uid'] = $uid;
		$user['openid'] = $openid;
		C::t("#zhikai_sinalogin#bind")->insert($user);
		//更新
		require_once libfile('cache/userstats', 'function');
		build_cache_userstats();
		//登陆
		duserlogin($uid,lang('plugin/zhikai_sinalogin','LEmEM3'),$referer);
	}elseif(submitcheck('loginsubmit')){//绑定
		loaducenter();
		list($uid, $username, $password, $email) = uc_user_login(daddslashes($_GET['username']), daddslashes($_GET['password']),0,1,intval($_GET['questionid']),daddslashes($_GET['answer']));
		if($uid > 0) {
			$user = array();
			$user['uid'] = $uid;
			$user['openid'] = $openid;
			C::t("#zhikai_sinalogin#bind")->insert($user);
			duserlogin($uid,lang('plugin/zhikai_sinalogin','W1WBs2'),$referer);
		} elseif($uid == -1) {
			showmessage(lang('plugin/zhikai_sinalogin','s26lW6'));
		} elseif($uid == -2) {
			showmessage(lang('plugin/zhikai_sinalogin','Wwmj8l'));
		} else {
		}
	}else{
		include template("zhikai_sinalogin:reg");		
	}
}else{
	$url = 'https://api.weibo.com/oauth2/authorize?client_id=';
	$url .= $pvars['appkey'].'&response_type=code&redirect_uri='.urlencode($_G['siteurl']."plugin.php?id=zhikai_sinalogin");
	$url .= '&state='.urlencode($referer);
	dheader("location:".$url);
}
//From:www_Dashulai_co
?>