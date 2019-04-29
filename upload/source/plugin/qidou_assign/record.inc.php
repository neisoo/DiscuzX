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
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$act = addslashes($_GET['act']);
require_once dirname(__FILE__) . '/qidou.class.php';
/* 列表展示 */
$baseUrl = rawurldecode(cpurl());
if (!$act) {
    
	$perpage = max(20, empty($_GET['perpage']) ? 20 : intval($_GET['perpage']));
	$start_limit = ($page - 1) * $perpage;
    
    $all_list = C::t('#qidou_assign#qidou_assign_item')->record($start_limit, $perpage);
    $sql = 'SELECT count(*) as num FROM ' . DB::table('qidou_assign_item') . ' where totaltian > 0';
    $count = DB::fetch_first($sql);
    showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=qidou_assign&pmod=record&act=del', 'enctype');
    showtableheader();
    echo '<tr class="header"><th></th><th>' .
    lang('plugin/qidou_assign', 'id') . '</th><th>' .
    lang('plugin/qidou_assign', 'name') . '</th><th>' .
    lang('plugin/qidou_assign', 'date') . '</th><th>' .
    lang('plugin/qidou_assign', 'time') . '</th><th>' .
    lang('plugin/qidou_assign', 'lxqd') .
    '</th><th></th></tr>';
    foreach ($all_list as $list) {

        if (!$list['code_time']) {
            $list['code_time'] = lang('plugin/qidou_assign', 'wyq');
        } else {
            $list['code_time'] = date("Y-m-d H:i:s", $list['code_time']);
        }
        echo'<tr class="hover">' .
        '<th class="td25"><input class="checkbox" type="checkbox" name="delete[' . $list['id'] . ']" value="' . $list['id'] . '"></th>' .
        '<th>' . $list['uid'] . '</th>' .
        '<th>' . $list['username'] . '</th>' .
        '<th>' . $list['signdate'] . '</th>' .
        '<th>' . date("Y-m-d H:i:s", $list['signtime']) . '</th>' .
        '<th>' . $list['liantian'] . '</th>' .
        '</tr>';
    }
    $mpurl = ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=qidou_assign&pmod=record";
    $multipage = multi($count['num'], $perpage, $page, $mpurl, 0, 3);
   
    showsubmit('submit', lang('plugin/qidou_assign', 'del'), '', '', $multipage);
    showtablefooter();
    showformfooter();
}
/* 删除 */ 
elseif ($act == 'del') {
    if (submitcheck('submit')) {
        foreach ($_POST['delete'] as $delete) {
            DB::delete('qidou_assign_item', array('id' => $delete));
        }
        cpmsg(lang('plugin/qidou_assign', 'success_info'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=qidou_assign&pmod=record', 'succeed');
    }
}
//ZZb7.taobao.com
?>