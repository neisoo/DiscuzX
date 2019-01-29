<?php
// by 大叔来 http://www.dashulai.com/
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$addonid = "zhikai_n5app.template";
$n5app = init_n5app();
function n5app_template()
{
    global $_G;
    global $n5app;
    return in_array("zhikai_n5appgl", $_G["setting"]["plugins"]["available"]);
}

// 是否应该按配音方式显示。
function n5video_is_dubbing_forum()
{
	global $_G;
	global $n5app;

	if (in_array("zhikai_n5video", $_G["setting"]["plugins"]["available"])) {
		if (in_array($_G['fid'], dunserialize($_G['cache']['plugin']['zhikai_n5video']['forum_dubbing']))
			|| $_G['fid'] == $_G['cache']['plugin']['zhikai_n5video']['forum_userdubbing']) {
			return true;
		}
	}
	return false;
}

// 返回存放用户已发布的配音帖子版块
function n5video_forum_userdubbing()
{
	global $_G;
	global $n5app;

	if (in_array("zhikai_n5video", $_G["setting"]["plugins"]["available"])) {
		return $_G['cache']['plugin']['zhikai_n5video']['forum_userdubbing'];
	}

	return null;
}

function JudgeVideo($tid)
{
	global $_G;
	if (!$tid) {
		return false;
	}
	if (empty($_G['cache']['plugin'])) {
		loadcache('plugin');
	}
	$config = $_G['cache']['plugin']['zhikai_n5video'];
	$video = explode('|', $config['video_bmp']);
	$voice = explode('|', $config['voice_bmp']);
	$post = DB::fetch_first('SELECT pid,message FROM %t WHERE tid=%d AND first=1 ', array('forum_post', $tid));
	if (strexists($post['message'], '[/media]') !== false) {
		return true;
	}
	if (strexists($post['message'], '[/zhikai_youku]') !== false) {
		return true;
	}
	if (strexists($post['message'], '[/audio]') !== false) {
		return true;
	}
	$aidtb = getattachtablebytid($tid);
	if ($aidtb == 'forum_attachment_unused') {
		return false;
	}
	$attachlist = DB::fetch_all('SELECT filename FROM %t WHERE tid=%d AND pid=%d', array($aidtb, $tid, $post['pid']));
	foreach ($attachlist as $k => $attach) {
		$attachext = strtolower(fileext($attach['filename']));
		if (in_array($attachext, $voice) || in_array($attachext, $video)) {
			return true;
		}
	}
	return false;
}