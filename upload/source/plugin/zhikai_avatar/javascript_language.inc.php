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
$jlang = $language['js'];
echo 'var lang_charset=lang={};lang_charset.set="'.$_GET['charset'].'";';
foreach ($language['js'] as $k => $v) {
	echo 'lang._'.$k.'="'.$v.'";';
}
//From:www_DASHULAI_COM
?>