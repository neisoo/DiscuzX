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
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=qidou_assign&pmod=link', 'enctype');
showtableheader();
showsetting(lang('plugin/qidou_assign', 'link'), 'link', $_G['siteurl'] . 'plugin.php?id=qidou_assign', 'text');
showtablefooter();
showformfooter();
?>