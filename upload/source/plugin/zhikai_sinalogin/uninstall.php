<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_sinalogin_bind`;
DROP TABLE IF EXISTS `cdb_zhikai_sinalogin_guest`;
DROP TABLE IF EXISTS `cdb_zhikai_sinalogin_thread`;
EOF;
runquery($sql);
?>