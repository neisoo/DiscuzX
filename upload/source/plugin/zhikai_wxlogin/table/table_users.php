<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_users extends discuz_table
{
	public function __construct() {

		$this->_table = 'zhikai_wxlogin_users';
		$this->_pk    = 'uid';
		parent::__construct();
	}
	
	public function fetch_by_uid($uid){
		return DB::fetch_first("SELECT * FROM %t WHERE uid=%d",array($this->_table,$uid) );
	}

	public function fetch_by_openid($openid){
		return DB::fetch_first("SELECT * FROM %t WHERE openid=%s",array($this->_table , $openid));
	}

	public function delete_by_openid($openid){
		return DB::query("DELETE FROM %t WHERE openid=%s",array($this->_table , $openid));
	}

	public function update_status_by_uid($uid){
		return DB::query("UPDATE %t SET status = 1 WHERE uid=%s",array($this->_table , $uid));
	}
	
}

?>