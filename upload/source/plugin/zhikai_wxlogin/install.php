<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_wxlogin_code`;
CREATE TABLE `cdb_zhikai_wxlogin_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  `uid` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `cdb_zhikai_wxlogin_users`;
CREATE TABLE `cdb_zhikai_wxlogin_users` (
  `uid` int(8) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`uid`,`openid`)
) ENGINE=MyISAM;
EOF;
runquery($sql);
$finish = true;
?>