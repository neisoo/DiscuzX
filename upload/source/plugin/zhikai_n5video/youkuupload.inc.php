<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (file_exists(DISCUZ_ROOT.'./source/plugin/zhikai_n5video/function.inc.php')) {
	@include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5video/function.inc.php';
}
	if(empty($_G['cache']['plugin'])){
		loadcache('plugin');
	}
    $config = $_G['cache']['plugin']['zhikai_n5video'];
	if(!in_array($_G['groupid'],dunserialize($config['forum_upus']))){
		showmessage(lang('plugin/zhikai_n5video','lang_vdo007'));
	}

	if(empty($config['client_id']) || empty( $config['client_secret']) || empty($config['Access_token']) || empty( $config['refresh_token'])){
		showmessage(lang('plugin/zhikai_n5video','lang_vdo006'));
	}
    youku_access_token($config);
	$youku_refresh = unserialize($_G['setting']['youku_refresh']);
    include template('zhikai_n5video:youkuup');
?>