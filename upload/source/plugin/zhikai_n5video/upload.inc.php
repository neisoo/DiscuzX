<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5video/zhikai_upload.class.php';
    global $_G;
	$fid = intval($_GET['fid']);
	$uid = intval($_GET['uid']);
	if(empty($fid) && empty($uid)) { return;}
	$upfhash = md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']);
	$aid = 0;
	$file = isset($_FILES['file_data']) ? $_FILES['file_data'] : null;
	$total = isset($_POST['file_total']) ? $_POST['file_total'] : 0;
	$index = isset($_POST['file_index']) ? $_POST['file_index'] : 0;
	$upsize = isset($_POST['file_size']) ? $_POST['file_size'] : 0;
	$file_name = isset($_POST['file_name']) ? $_POST['file_name'] : null;
	$file_id = isset($_POST['file_id']) ? $_POST['file_id'] : 0;
	if(strtoupper(CHARSET) == 'GBK' && !checkmobile()){
		$file_name = diconv($file_name, 'UTF-8');
	}
	if($_GET['hash'] != $upfhash ){ zhikai_upmsg(10);}
		$zhikai_upload = new zhikai_upload($total,$index,$upsize,$file_name,$file_id);
		$zhikai_upload->init($file, 'forum');
		$zhikai_upload->save();
        $attach = &$zhikai_upload->attach;

		if ($index >= $total){
			if($zhikai_upload->error()) {
				zhikai_upmsg(2);
			}

			$allowupload = !$_G['group']['maxattachnum'] || $_G['group']['maxattachnum'] && $_G['group']['maxattachnum'] > getuserprofile('todayattachs');;
			if(!$allowupload) {
				zhikai_upmsg(6);
			}

			if($_G['group']['attachextensions'] && (!preg_match("/(^|\s|,)".preg_quote($zhikai_upload->attach['ext'], '/')."($|\s|,)/i", $_G['group']['attachextensions']) || !$zhikai_upload->attach['ext'])) {
				zhikai_upmsg(1);
			}

			if(empty($zhikai_upload->attach['size'])) {
				zhikai_upmsg(2);
			}

			if($_G['group']['maxattachsize'] && $zhikai_upload->attach['size'] > $_G['group']['maxattachsize']){
				$error_sizelimit = $_G['group']['maxattachsize'];
				zhikai_upmsg(3);
			}//fr o  m ww w.m  o qu8.c om

			loadcache('attachtype');
			if($_G['fid'] && isset($_G['cache']['attachtype'][$_G['fid']][$zhikai_upload->attach['ext']])){
				$maxsize = $_G['cache']['attachtype'][$_G['fid']][$zhikai_upload->attach['ext']];
			} else if(isset($_G['cache']['attachtype'][0][$zhikai_upload->attach['ext']])) {
				$maxsize = $_G['cache']['attachtype'][0][$zhikai_upload->attach['ext']];
			}
			if(isset($maxsize)){
				if(!$maxsize) {
					$error_sizelimit = 'ban';
					zhikai_upmsg(4);
				} elseif($zhikai_upload->attach['size'] > $maxsize) {
					$error_sizelimit = $maxsize;
					zhikai_upmsg(5);
				}
			}

			if($zhikai_upload->attach['size'] && $_G['group']['maxsizeperday']) {
				$todaysize = getuserprofile('todayattachsize') + $zhikai_upload->attach['size'];
				if($todaysize >= $_G['group']['maxsizeperday']) {
					$error_sizelimit = 'perday|'.$_G['group']['maxsizeperday'];
					zhikai_upmsg(11);
				}
			}
			    if($zhikai_upload->error() == -103) {
					zhikai_upmsg(8);
				} elseif($zhikai_upload->error()) {
					zhikai_upmsg(9);
				}
				$thumb = $remote = $width = 0;
				if($_GET['type'] == 'image' && !$zhikai_upload->attach['isimage']) {
					zhikai_upmsg(7);
				}
				if($zhikai_upload->attach['isimage']) {
					if(!in_array($zhikai_upload->attach['imageinfo']['2'], array(1,2,3,6))) {
						zhikai_upmsg(7);
					}
					if($_G['setting']['showexif']) {
						require_once libfile('function/attachment');
						$exif = getattachexif(0, $zhikai_upload->attach['target']);
					}
					if($_G['setting']['thumbsource'] || $_G['setting']['thumbstatus']) {
						require_once libfile('class/image');
						$image = new image;
					}
					if($_G['setting']['thumbsource'] && $_G['setting']['sourcewidth'] && $_G['setting']['sourceheight']) {
						$thumb = $image->Thumb($zhikai_upload->attach['target'], '', $_G['setting']['sourcewidth'], $_G['setting']['sourceheight'], 1, 1) ? 1 : 0;
						$width = $image->imginfo['width'];
						$zhikai_upload->attach['size'] = $image->imginfo['size'];
					}
					if($_G['setting']['thumbstatus']) {
						$thumb = $image->Thumb($zhikai_upload->attach['target'], '', $_G['setting']['thumbwidth'], $_G['setting']['thumbheight'], $_G['setting']['thumbstatus'], 0) ? 1 : 0;
						$width = $image->imginfo['width'];
					}
					if($_G['setting']['thumbsource'] || !$_G['setting']['thumbstatus']) {
						list($width) = @getimagesize($zhikai_upload->attach['target']);
					}
				}

			if ($attach['accomplish'] && $attach['accomplish'] == 1 ){
				updatemembercount($_G['uid'], array('todayattachs' => 1, 'todayattachsize' => $zhikai_upload->attach['size']));
				if($_GET['type'] != 'image' && $attach['isimage']){
					$zhikai_upload->attach['isimage'] = -1;
				}
				$aid = getattachnewaid($_G['uid']);
				$insert = array(
					'aid' => $aid,
					'dateline' => $_G['timestamp'],
					'filename' => dhtmlspecialchars(censor($zhikai_upload->attach['name'])),
					'filesize' => $zhikai_upload->attach['size'],
					'attachment' => $zhikai_upload->attach['attachment'],
					'isimage' => $zhikai_upload->attach['isimage'],
					'uid' => $_G['uid'],
					'thumb' => $thumb,
					'remote' => $remote,
					'width' => $width,
				);
				C::t('forum_attachment_unused')->insert($insert);
				if($zhikai_upload->attach['isimage'] && $_G['setting']['showexif']) {
					C::t('forum_attachment_exif')->insert($aid, $exif);
				}
				if ($zhikai_upload->attach['isimage'] && $zhikai_upload->attach['isimage'] == 1){$simple = $zhikai_upload->attach['isimage'];}
				zhikai_upmsg(0);
			}else{
				$attachurl = $_G['siteurl'].$_G['setting']['attachurl'].'forum/';
				@unlink($attachurl.$attach['attachment']);
				zhikai_upmsg($attach['accomplish']);
			}
		}

	function zhikai_upmsg($statusid) {
		global $_G,$error_sizelimit,$aid,$simple,$attach;
		$error_sizelimit = !empty($error_sizelimit) ? $error_sizelimit : 0;
		if($simple == 1){
			echo 'DISCUZUPLOAD|'.$statusid.'|'.$aid.'|'.$attach['isimage'].'|'.($attach['isimage'] ? $attach['attachment'] : '').'|'.$attach['name'].'|'.$attach['size'].'|'.$attach['ext'].'|'.$error_sizelimit;
		}else{
			echo $statusid ? $statusid : 'DISCUZUPLOAD|'.$statusid.'|'.$aid.'|'.$attach['isimage'].'|'.$attach['attachment'].'|'.$attach['name'].'|'.$attach['size'].'|'.$attach['ext'].'|'.$error_sizelimit;
		}
		exit;
	}
?>