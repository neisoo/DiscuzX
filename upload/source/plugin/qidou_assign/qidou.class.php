<?php
/*
 * CopyRight  : [Zzb7taobao!] (C)2009-2019
 * Document   : վ���zZb7.taoBao.com
 * Created on : 2019-01-02,10:23:46
 * Author     : վ����(������http://url.cn/5xEd1qK) ZzB7.taobao.Com $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              ����Դ��Դ�������ռ�,��������ѧϰ�о����ͣ�����������ҵ��;����������24Сʱ��ɾ��!
 *              վ.��.�� ȫ���׷� https://ZZb7.taobao.Com��
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
