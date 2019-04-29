<?php

/**
 *      [zzb7taobao!] (C)2009-2019 zZb7.taobao.Com.
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
ALTER TABLE `pre_qidou_assign_item` ADD `lt` int(11) NOT NULL COMMENT '0';
EOF;

runquery($sql);

$finish = TRUE;

?>