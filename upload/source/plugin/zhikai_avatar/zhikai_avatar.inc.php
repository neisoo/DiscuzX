<?php
/**
 * 
 * ��������Ʒ ������Ʒ
 * ������ Դ����̳ ȫ���׷� http://www.dashulai.Com
 * ����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 * ��л֧�֣�����֧�����������Ķ���������������ر�վ������Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * �������û�����Ⱥ: ��Ⱥ454393969
 * ����������http://www.dashulai.Com/ (���ղر���!)
 * 
 */

if( !defined('IN_DISCUZ') ) {
	exit('Access Denied');
}

include 'language/'.currentlang().'.php';
$plang = $language['php'];
$hlang = $language['html'];

if (!$_G['uid']) {
	showmessage($plang['001'],null,array(),array('login' =>1));
}

define('APP_ID','zhikai_avatar');
define('APP_DIR','source/plugin/'.APP_ID);
define('APP_URL',$_G['siteurl'].'plugin.php?id='.APP_ID);
define('CUR_PAGE','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$config = $_G['cache']['plugin'][APP_ID];
include 'common.func.php';
include 'core.inc.php';

?>