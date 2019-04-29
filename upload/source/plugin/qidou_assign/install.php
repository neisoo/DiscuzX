<?php

/**
 *      [zzb7taobao!] (C)2009-2019 zZb7.taobao.Com.
 *      This is gold plugin
 *
 *      install.php 2016-07-21 20:49 41Z gold 
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

CREATE TABLE  IF NOT EXISTS `cdb_qidou_assign_item` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `signdate` date NOT NULL,
  `signtime` int(11) NOT NULL,
  `tian` int(4) NOT NULL DEFAULT '0',
  `totaltian` int(4) NOT NULL,
  `totalmoney` int(4) NOT NULL,
  `liantian` int(4) NOT NULL,
  `lt` int(4) NOT NULL,
  `date` text,
  `bu_date` text,
  `endtotal` int(11) DEFAULT NULL,
  `buqian` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
)  ENGINE=MyISAM;
        
EOF;

runquery($sql);

$finish = TRUE;
?>