<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

Class zhikai_upload{

	var $attach = array();
	var $type = '';
	var $extid = 0;
	var $errorcode = 0;
	var $forcename = '';
	var $total = 0;
	var $upsize = 0;
	var $index = 0;
	var $file_name = null;
	var $file_id = 0;

	public function __construct($total,$index,$upsize,$file_name,$file_id) {
		$this->total = intval($total);
		$this->index = intval($index);
		$this->upsize = intval($upsize);
		$v = array("'","\"",",");$s = array("","","");
		$this->file_name = trim(str_replace($v,$s,$file_name));
		$this->file_id = intval($file_id);
	}

	function init($attach, $type = 'temp', $extid = 0, $forcename = ''){
		if(!is_array($attach) || empty($attach) || !$this->is_upload_file($attach['tmp_name']) || $this->file_name == null || $attach['size'] == 0 ) {
			$this->attach = array();
			$this->errorcode = -1;
			return false;
		} else {
			$this->type = $this->check_dir_type($type);
			$this->extid = intval($extid);
			$this->forcename = $forcename;

			$attach['size'] = $this->upsize;
			$attach['name'] =  $this->file_name;
			$attach['thumb'] = '';
			$attach['ext'] = $this->fileext($attach['name']);
			$attach['name'] =  dhtmlspecialchars($attach['name']);
			if(strlen($attach['name']) > 90) {
				$attach['name'] = cutstr($attach['name'], 80, '').'.'.$attach['ext'];
			}
			$attach['isimage'] = $this->is_image_ext($attach['ext']);
			$attach['extension'] = $this->get_target_extension($attach['ext']);
			$attach['attachdir'] = $this->get_target_dir($this->type, $extid);
			$attach['attachment'] = $attach['attachdir'].$this->get_target_filename($this->type, $this->extid, $this->forcename, $attach['ext']).'.'.$attach['extension'];
			$attach['target'] = getglobal('setting/attachdir').'./'.$this->type.'/'.$attach['attachment'];
			$attach['accomplish'] = '';
			$this->attach = &$attach;
			$this->errorcode = 0;
			return true;
		}
	}

	function save(){
		if(empty($this->attach) || empty($this->attach['tmp_name']) || empty($this->attach['target'])) {
			$this->errorcode = -101;
		} elseif(in_array($this->type, array('group', 'album', 'category')) && !$this->attach['isimage']) {
			$this->errorcode = -102;
		} elseif(in_array($this->type, array('common')) && (!$this->attach['isimage'] && $this->attach['ext'] != 'ext')) {
			$this->errorcode = -102;
		} elseif(!$this->save_to_local($this->attach['tmp_name'], $this->attach['target'])) {
			$this->errorcode = -103;
		} elseif(($this->attach['isimage'] || $this->attach['ext'] == 'swf') && (!$this->attach['imageinfo'] = $this->get_image_info($this->attach['target'], true))) {
			$this->errorcode = -104;
			@unlink($this->attach['target']);
		} else {
			$this->errorcode = 0;
			return true;
		}
		return false;
	}

	function error() {
		return $this->errorcode;
	}

	function errormessage() {
		return lang('error', 'file_upload_error_'.$this->errorcode);
	}

	function fileext($filename) {
		return addslashes(strtolower(substr(strrchr($filename, '.'), 1, 10)));
	}

	function is_image_ext($ext) {
		static $imgext  = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
		return in_array($ext, $imgext) ? 1 : 0;
	}

	function get_image_info($target, $allowswf = false) {
		$ext = zhikai_upload::fileext($target);
		$isimage = zhikai_upload::is_image_ext($ext);
		if(!$isimage && ($ext != 'swf' || !$allowswf)) {
			return false;
		} elseif(!is_readable($target)) {
			return false;
		} elseif($imageinfo = @getimagesize($target)) {
			list($width, $height, $type) = !empty($imageinfo) ? $imageinfo : array('', '', '');
			$size = $width * $height;
			if($size > 16777216 || $size < 16 ) {
				return false;
			} elseif($ext == 'swf' && $type != 4 && $type != 13) {
				return false;
			} elseif($isimage && !in_array($type, array(1,2,3,6,13))) {
				return false;
			} elseif(!$allowswf && ($ext == 'swf' || $type == 4 || $type == 13)) {
				return false;
			}
			return $imageinfo;
		} else {
			return false;//fr o  m w  w w.m  o qu8.c om
		}
	}

	function is_upload_file($source) {
		return $source && ($source != 'none') && (is_uploaded_file($source) || is_uploaded_file(str_replace('\\\\', '\\', $source)));
	}
	
	function get_target_filename($type, $extid = 0, $forcename = '',$attach_ext) {
		global $_G;
		if($type == 'group' || ($type == 'common' && $forcename != '')) {
			$filename = $type.'_'.intval($extid).($forcename != '' ? "_$forcename" : '');
		} else {
			$filename = 'zhikai_'.$this->file_id.$attach_ext.'_'.date("Ymd").'_'.$this->total.'_'.$_G['uid'].'_'.$this->upsize;
		}
		return $filename;
	}

	function get_target_extension($ext) {
		return strtolower($ext);
	}

	function get_target_dir($type, $extid = '', $check_exists = true){
		$subdir = $subdir1 = $subdir2 = '';
		if($type == 'album' || $type == 'forum' || $type == 'portal' || $type == 'category' || $type == 'profile') {
			$subdir1 = date('Ym');
			$subdir2 = date('d');
			$subdir = $subdir1.'/'.$subdir2.'/';
		} elseif($type == 'group' || $type == 'common') {
			$subdir = $subdir1 = substr(md5($extid), 0, 2).'/';
		}
		$check_exists && zhikai_upload::check_dir_exists($type, $subdir1, $subdir2);
		return $subdir;
	}

	function check_dir_type($type){
		return !in_array($type, array('forum', 'group', 'album', 'portal', 'common', 'temp', 'category', 'profile')) ? 'temp' : $type;
	}

	function check_dir_exists($type = '', $sub1 = '', $sub2 = ''){
		$type = zhikai_upload::check_dir_type($type);
		$basedir = !getglobal('setting/attachdir') ? (DISCUZ_ROOT.'./data/attachment') : getglobal('setting/attachdir');
		$typedir = $type ? ($basedir.'/'.$type) : '';
		$subdir1  = $type && $sub1 !== '' ?  ($typedir.'/'.$sub1) : '';
		$subdir2  = $sub1 && $sub2 !== '' ?  ($subdir1.'/'.$sub2) : '';
		$res = $subdir2 ? is_dir($subdir2) : ($subdir1 ? is_dir($subdir1) : is_dir($typedir));
		if(!$res){
			$res = $typedir && zhikai_upload::make_dir($typedir);
			$res && $subdir1 && ($res = zhikai_upload::make_dir($subdir1));
			$res && $subdir1 && $subdir2 && ($res = zhikai_upload::make_dir($subdir2));
		}
		return $res;
	}

	function save_to_local($source, $target){
  		if(!zhikai_upload::is_upload_file($source)){
			$succeed = false;
		}else if(function_exists('move_uploaded_file')){
			if(!file_exists($target)){
				if (!move_uploaded_file($source, $target)){ $this->errorcode = -1;}
			}else{
				$content = file_get_contents($source);
				if (!file_put_contents($target, $content, FILE_APPEND)){ $this->errorcode = -1;}
			}
			$succeed = true;
		}
		if($succeed){
            @unlink($source);
			$fsize = filesize($target);
			if($this->upsize == $fsize){
			    $this->errorcode = 0;
				$this->attach['accomplish'] = 1;
				@chmod($target, 0644);
			}else{
			    $this->errorcode = 0;
				$this->attach['accomplish'] = -5;
			}
			clearstatcache();
		}else{
			@unlink($source);
			$this->errorcode = -1;
		}
		return $succeed;
	}

	function make_dir($dir, $index = true) {
		$res = true;
		if(!is_dir($dir)){
			$res = @mkdir($dir, 0777);
			$index && @touch($dir.'/index.html');
		}
		return $res;
	}
}

?>