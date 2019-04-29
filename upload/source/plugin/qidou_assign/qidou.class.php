<?php
/*
 * CopyRight  : [Zzb7taobao!] (C)2009-2019
 * Document   : 站长帮：zZb7.taoBao.com
 * Created on : 2019-01-02,10:23:46
 * Author     : 站长帮(旺旺：http://url.cn/5xEd1qK) ZzB7.taobao.Com $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 *              站.长.帮 全网首发 https://ZZb7.taobao.Com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class Qidou {
    const PLUGIN_ID = 'qidou_assign';
    public static function lang($key, $params = array()) {
        return lang('plugin/' . self::PLUGIN_ID, $key, $params);
    }

    public static function output($status, $msg = '') {
        $data['status'] = $status;
        $data['msg'] = $msg;
        echo json_encode($data);
        exit;
    }

}
