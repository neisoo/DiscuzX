<?php
/**
 * 
 * 大叔来出品 必属精品
 * 大叔来 源码论坛 全网首发 http://www.dashulai.Com
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！永久免费下载本站所有资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * 大叔来用户交流群: ①群454393969
 * 永久域名：http://www.dashulai.Com/ (请收藏备用!)
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