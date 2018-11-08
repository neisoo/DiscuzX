<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_sinalogin_bind`;
CREATE TABLE `cdb_zhikai_sinalogin_bind` (
  `uid` int(11) NOT NULL,
  `openid` varchar(32) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `cdb_zhikai_sinalogin_guest`;
CREATE TABLE `cdb_zhikai_sinalogin_guest` (
  `openid` varchar(32) NOT NULL,
  `connect_uid` int(11) DEFAULT NULL,
  `screen_name` varchar(100) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `extend` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`openid`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `cdb_zhikai_sinalogin_thread`;
CREATE TABLE `cdb_zhikai_sinalogin_thread` (
  `tid` int(11) NOT NULL,
  `mid` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM;
EOF;
runquery($sql);
?>