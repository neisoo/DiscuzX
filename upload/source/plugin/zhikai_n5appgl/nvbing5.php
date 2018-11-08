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