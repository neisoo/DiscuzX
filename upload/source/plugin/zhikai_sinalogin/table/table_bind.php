<?php
/*
 * ��������-��-��
 * ����: Www.dashulai.com
 * ������ַ: www.dashulai.Com (���ղر���!)
 * ����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 * ����֧��/����ά����QQ 986692927
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_bind extends discuz_table{
	public function __construct() {
		$this->_table = 'zhikai_sinalogin_bind';
		$this->_pk    = 'openid';
		parent::__construct();
	}

	public function fetch_by_uid($uid){
		return DB::fetch_first("SELECT * FROM %t WHERE uid=%d",array($this->_table,$uid));
	}
	
	
}
//WWW.dashulai.com
?>