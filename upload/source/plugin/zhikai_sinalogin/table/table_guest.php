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

class table_guest extends discuz_table{
	public function __construct() {
		$this->_table = 'zhikai_sinalogin_guest';
		$this->_pk    = 'openid';
		parent::__construct();
	}
	
}
//WWW.dashulai.com
?>