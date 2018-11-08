<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_code extends discuz_table
{
	public function __construct() {

		$this->_table = 'zhikai_wxlogin_code';
		$this->_pk    = '';
		parent::__construct();
	}
	
	public function delete_by_openid($openid){
		return DB::query("DELETE FROM %t WHERE openid=%s",array($this->_table,$openid) );
	}

	public function fetch_by_code($hash){
		return DB::fetch_first("SELECT * FROM %t WHERE code=%s",array($this->_table,$hash));
	}

	public function update_by_code($openid,$hash){
		return DB::query("UPDATE %t SET openid=%s WHERE code=%s",array($this->_table,$openid,$hash));
	}

	public function update_notify_openid_by_code($hash,$openid){
		return DB::query("UPDATE %t SET notify=1 , openid=%s WHERE code=%s",array($this->_table,$openid,$hash));
	}
	
}

?>