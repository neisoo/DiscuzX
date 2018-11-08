<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$code = $_GET['code'];
$hash = addslashes($_GET['hash']);
if(!$hash){
	showmessage(lang('plugin/zhikai_wxlogin', 'slang10'));
}
$snsapi = $_GET['snsapi']?$_GET['snsapi']:"base";
if(!$code){//获取授权
	$appid 			= $pvars['appid'];
	$REDIRECT_URI 	= $_G['siteurl']."plugin.php?id=zhikai_wxlogin&mod=access&snsapi=".$snsapi."&hash=".$hash;
	$scope			= 'snsapi_'.$snsapi;
	$url 			= 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid;
	$url 		   .= '&redirect_uri='.urlencode($REDIRECT_URI);
	$url 		   .= '&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
	dheader("Location:".$url);
}else{
	$appid = $pvars['appid']; 
	$secret = $pvars['appsecret']; 
	$code = $_GET["code"]; 
	$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
	$res = dfsockopen($get_token_url);
	$json_obj = json_decode($res,true); 
	$openid = $json_obj['openid'];
	if(!$json_obj['access_token']){
		showmessage(lang('plugin/zhikai_wxlogin', 'slang11'));
	}
	$access_token = $json_obj['access_token'];
	if(!$openid){
		showmessage(lang('plugin/zhikai_wxlogin', 'slang11'));
	}
	//检查是否绑定过
	$checkUser = C::t("#zhikai_wxlogin#users")->fetch_by_openid($openid);
	if(!$checkUser){//拉用户信息
		if($snsapi == 'base'){
			dheader("Location: ".$_G['siteurl']."plugin.php?id=zhikai_wxlogin&mod=access&snsapi=userinfo&hash=".$hash);
		}
		$codeInfo = C::t("#zhikai_wxlogin#code")->fetch_by_code($hash);
		if(!$codeInfo['uid']){//非绑定
			$info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&=zh_CN';
			$content = dfsockopen($info_url);
			$info = json_decode($content,true);
			if(strtolower($_G['charset']) != 'utf-8'){
				$info['nickname'] = mb_convert_encoding($info['nickname'], $_G['charset'], "UTF-8"); 
			}
			$username = trim($info['nickname']);
			$username = str_replace(array(" ","\r","\n","?"), '', $username);
			if(!$username){
				$username = "wx_".random(6);
			}
			$user['name'] 	= checkUsername($username);
			$avatar = addslashes($info['headimgurl']);
			$user['pwd'] 	= md5(random(10));
			$user['email'] 	= 'wechat_'.strtolower(random(10)).'@null.null';
			loaducenter();
			$uid = uc_user_register($user['name'], $user['pwd'], $user['email'],'', '', $_G['clientip']);
			C::t('common_member')->insert($uid, $user['name'], md5(random(10)), $user['email'], $_G['clientip'], $_G['setting']['newusergroupid'], null);
			C::t("#zhikai_wxlogin#users")->insert(array("uid"=>$uid,"openid"=>$openid));
			$dir = './data/cache/';//存储路径
			$file = $dir.'zhikai_avatar_'.$uid.'.jpg';
			$image = DISCUZ_ROOT.$file;	
			file_put_contents($file, dfsockopen($avatar));
			createavatarimg($uid,$image);
			unlink($image);
			DB::update('common_member',array('avatarstatus'=>1),array('uid'=>$uid));

		}else{
			C::t("#zhikai_wxlogin#users")->insert(array("uid"=>intval($codeInfo['uid']),"openid"=>$openid,"status"=>1));
			$uid = $codeInfo['uid'];
		}
		
		
	}else{
		$uid = $checkUser['uid'];
	}
	//登陆
	require_once libfile('function/member');
	if(!($member = getuserbyuid($uid, 1))) {
		C::t("#zhikai_wxlogin#users")->delete_by_openid($openid);//删除绑定用户
		showmessage(lang('plugin/zhikai_wxlogin', 'slang12'));
	} else {
		if(isset($member['_inarchive'])) {
			C::t('common_member_archive')->move_to_master($uid);
		}
	}
	$cookietime = 1296000;
	setloginstatus($member, $cookietime);
	//更改状态通知
	C::t("#zhikai_wxlogin#code")->update_by_code($openid,$hash);
	showmessage(lang('plugin/zhikai_wxlogin', 'slang13'),"index.php");
}

function checkUsername($username){
	if(C::t('common_member')->fetch_uid_by_username($username) || C::t('common_member_archive')->fetch_uid_by_username($username)) {
		$username = $username."_".random(3);
		if($username>15){
			$username = mb_substr($username,strlen($username)-15);
		}
		return checkUsername($username);
	}else{
		return addslashes($username);
	}
}

function createavatarimg($uid,$image) {
		$uid = abs(intval($uid)); //UID取整数绝对值
		$uid = sprintf("%09d", $uid); //前边加0补齐9位，例如UID为31的用户变成 000000031
		$dir1 = substr($uid, 0, 3);  //取左边3位，即 000
		$dir2 = substr($uid, 3, 2);  //取4-5位，即00
		$dir3 = substr($uid, 5, 2);  //取6-7位，即00
		$avatar_save_path = DISCUZ_ROOT.'uc_server/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3;	
		if(!file_exists($avatar_save_path)) {
			mkdir($avatar_save_path,0755,true);
		}
		$avatar_save_name_id = substr($uid, -2);
		
		$pic_info = array();
		$pic_size = getimagesize($image,$pic_info);
		$pic_img = imagecreatefromjpeg($image);		
		
		$bg_color_white = imagecolorallocate($bg_img_big,255, 255, 255);//底色
		
		$avas = array('big'=>145,'middle'=>120,'small'=>48);
		foreach($avas as $n=>$s) {
			$bg_img = imagecreatetruecolor($s,$s);
			imagefill($bg_img,$bg_color_white);
			imagecopyresampled( $bg_img , $pic_img , 0 , 0 , 0 , 0 , $s , $s , $pic_size[0] , $pic_size[1]);
			imagejpeg($bg_img, $avatar_save_path.'/'.$avatar_save_name_id.'_avatar_'.$n.'.jpg');
		}
}

?>