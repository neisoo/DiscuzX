<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_topic`;
CREATE TABLE `cdb_zhikai_topic` (
  `topicid` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `entitle` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `blocks` text,
  `html` text,
  `seo` text,
  PRIMARY KEY (`topicid`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

$finish = TRUE;
?>