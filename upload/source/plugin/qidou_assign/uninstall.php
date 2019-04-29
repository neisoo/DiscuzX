<?php

/**
 * 插件卸载时执行此文件
 *
 * @author 谢建平 <jianping_xie@aliyun.com>
 * @copyright 2012-2014 Appbyme
 * @license http://opensource.org/licenses/LGPL-3.0
 */
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `cdb_qidou_assign_item`;

EOF;

runquery($sql);

$finish = TRUE;
?>