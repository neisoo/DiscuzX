<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$checkUser = C::t("#zhikai_wxlogin#users")->fetch_by_uid($_G['uid']);
$url = "home.php?mod=spacecp&ac=plugin&id=zhikai_wxlogin:wechat";
if(submitcheck("unbindsubmit")){
	C::t("#zhikai_wxlogin#users")->delete($_G['uid']);
	$tip = lang('plugin/zhikai_wxlogin', 'slang02');
	dsetcookie("zhikai_wxlogin_bind",1);
	showmessage($tip, $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));
}elseif(submitcheck("editsubmit")){
	$data['username'] = $username = addslashes($_GET['username']);
	if(C::t('common_member')->fetch_uid_by_username($username) || C::t('common_member_archive')->fetch_uid_by_username($username)) {
		showmessage(lang('plugin/zhikai_wxlogin', 'slang03'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
	}
	$data['pwd'] = addslashes($_GET['password']);
	if(!$data['pwd'])
		showmessage(lang('plugin/zhikai_wxlogin', 'slang04'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
	if($data['pwd'] != $_GET['password1'])
		showmessage(lang('plugin/zhikai_wxlogin', 'slang05'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
	$data['email'] = strtolower(addslashes(trim($_GET['email'])));
	if(C::t('common_member')->fetch_by_email($data['email']) ){
		showmessage(lang('plugin/zhikai_wxlogin', 'slang06'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
	}
	loaducenter();
	$ucresult = uc_user_edit($_G['username'], $data['pwd'], $data['pwd'], $data['email'], 1, '');
	if($ucresult < 0) {
		if($ucresult == -4) {
			showmessage(lang('plugin/zhikai_wxlogin', 'slang07'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
		} elseif($ucresult == -5) {
			showmessage(lang('plugin/zhikai_wxlogin', 'slang07'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
		} elseif($ucresult == -6) {
				showmessage(lang('plugin/zhikai_wxlogin', 'slang06'), $url, array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => 3));	
		}
	}
	if($data['username']){
		changename($_G['username'],$data['username']);
		changename_for_uc($_G['username'], $data['username']);
	}
	C::t("#zhikai_wxlogin#users")->update_status_by_uid($_G['uid']);
	showmessage(lang('plugin/zhikai_wxlogin', 'slang09'),$url);
}

function changename($oldname, $newname){
	$member = DB::fetch_first("SELECT * FROM " . DB::table('common_member') . " WHERE username='$oldname'");
	if($member){
		DB::query("UPDATE " . DB::table('common_adminnote') . " SET admin='$newname' WHERE admin='$oldname'");
		DB::query("UPDATE " . DB::table('common_block') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_block_item') . " SET title='$newname' WHERE title='$oldname'");
		DB::query("UPDATE " . DB::table('common_block_item_data') . " SET title='$newname' WHERE title='$oldname'");
		DB::query("UPDATE " . DB::table('common_card_log') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_failedlogin') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_grouppm') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('common_invite') . " SET fusername='$newname' WHERE fusername='$oldname'");
		DB::query("UPDATE " . DB::table('common_member') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_member_security') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_member_validate') . " SET admin='$newname' WHERE admin='$oldname'");
		DB::query("UPDATE " . DB::table('common_member_verify_info') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_member_security') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_mytask') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_report') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_session') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('common_word') . " SET admin='$newname' WHERE admin='$oldname'");
		DB::query("UPDATE " . DB::table('forum_activityapply') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_announcement') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collection') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collectioncomment') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collectionfollow') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collectionteamworker') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_forumrecommend') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('forum_groupuser') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_imagetype') . " SET name='$newname' WHERE name='$oldname'");
		DB::query("UPDATE " . DB::table('forum_order') . " SET buyer='$newname' WHERE buyer='$oldname'");
		DB::query("UPDATE " . DB::table('forum_order') . " SET admin='$newname' WHERE admin='$oldname'");
		DB::query("UPDATE " . DB::table('forum_pollvoter') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_post') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('forum_postcomment') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('forum_promotion') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_ratelog') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_rsscache') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('forum_thread') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('forum_threadmod') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_trade') . " SET seller='$newname' WHERE seller='$oldname'");
		DB::query("UPDATE " . DB::table('forum_tradelog') . " SET seller='$newname' WHERE seller='$oldname'");
		DB::query("UPDATE " . DB::table('forum_tradelog') . " SET buyer='$newname' WHERE buyer='$oldname'");
		DB::query("UPDATE " . DB::table('forum_warning') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('home_album') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_blog') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_clickuser') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_comment') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('home_docomment') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_doing') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_feed') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_feed_app') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow') . " SET fusername='$newname' WHERE fusername='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow_feed') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow_feed_archiver') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_friend') . " SET fusername='$newname' WHERE fusername='$oldname'");
		DB::query("UPDATE " . DB::table('home_friend_request') . " SET fusername='$newname' WHERE fusername='$oldname'");
		DB::query("UPDATE " . DB::table('home_notification') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('home_pic') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_poke') . " SET fromusername='$newname' WHERE fromusername='$oldname'");
		DB::query("UPDATE " . DB::table('home_share') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_show') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_specialuser') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_visitor') . " SET vusername='$newname' WHERE vusername='$oldname'");
		DB::query("UPDATE " . DB::table('home_specialuser') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('portal_article_title') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('portal_comment') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('portal_rsscache') . " SET author='$newname' WHERE author='$oldname'");
		DB::query("UPDATE " . DB::table('portal_topic') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('portal_topic_pic') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collection') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collectioncomment') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collectionfollow') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('forum_collectionteamworker') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow') . " SET username='$fusername' WHERE username='$fusername'");
		DB::query("UPDATE " . DB::table('home_follow_feed') . " SET username='$newname' WHERE username='$oldname'");
		DB::query("UPDATE " . DB::table('home_follow_feed_archiver') . " SET username='$newname' WHERE username='$oldname'");
	}
	return $member;
}

function changename_for_uc($oldname, $newname){
	DB::query("UPDATE " . UC_DBTABLEPRE . "admins SET username='$newname' WHERE username='$oldname'");
	DB::query("UPDATE " . UC_DBTABLEPRE . "badwords SET admin='$newname' WHERE admin='$oldname'");
	DB::query("UPDATE " . UC_DBTABLEPRE . "feeds SET username='$newname' WHERE username='$oldname'");
	DB::query("UPDATE " . UC_DBTABLEPRE . "members SET username='$newname' WHERE username='$oldname'");
	DB::query("UPDATE " . UC_DBTABLEPRE . "mergemembers SET username='$newname' WHERE username='$oldname'");
	DB::query("UPDATE " . UC_DBTABLEPRE . "protectedmembers SET username='$newname' WHERE username='$oldname'");
}

?>