<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function checkGroupJoin($fid){
	global $_G;
    if(!$_G['uid']) return false;
    $fids = C::t('forum_groupuser')->fetch_all_fid_by_uids($_G['uid']);
    return in_array($fid,$fids)?true:false;
}
?>