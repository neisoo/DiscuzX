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
$bindinfo = C::t("#zhikai_sinalogin#bind")->fetch_by_uid($_G['uid']);
if(submitcheck('unbind') && $bindinfo){
	C::t("#zhikai_sinalogin#bind")->delete($bindinfo['openid']);
	showmessage(lang('plugin/zhikai_sinalogin','AD4CKk'),dreferer());
}
//From:www_Dashulai_co
?>