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

class plugin_qidou_assign {

    public function common() {
        
    }

//global_cpnav_extra2
    public function global_usernav_extra1() {
        global $_G;

        $date = date('Y-m-d');
        $config = $_G['cache']['plugin']['qidou_assign'];
        if ($_G['uid'] && $config['is_pc']) {
            // if(!$_COOKIE['signdate']){
            //  $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($_G['uid']);
            //$signdate = $mysign['signdate'];
            //}else{
            //  $signdate = $_COOKIE['signdate'];
            // }
            // $expire  = time() + 86400 ;
            // if ($signdate == $date) {
            //    setcookie('signdate',$mysign['signdate'],$expire);
            //    include_once template('qidou_assign:top');
            //}else{

            include_once template('qidou_assign:top1');
            //}
            return $assign;
        } else {
            return '';
        }
    }

}
