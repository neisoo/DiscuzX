<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_wxlogin_code`;
DROP TABLE IF EXISTS `cdb_zhikai_wxlogin_users`;
EOF;
runquery($sql);
$finish = true;
?>