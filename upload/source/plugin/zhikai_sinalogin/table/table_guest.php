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

class table_guest extends discuz_table{
	public function __construct() {
		$this->_table = 'zhikai_sinalogin_guest';
		$this->_pk    = 'openid';
		parent::__construct();
	}
	
}
//WWW.dashulai.com
?>