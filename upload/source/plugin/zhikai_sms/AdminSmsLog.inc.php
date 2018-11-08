<?php
/**
 * 
 * 大-叔-来提醒：为保证大叔来资源的更新维护保障，防止大叔来首发资源被恶意泛滥，
 *             希望所有下载大叔来资源的会员不要随意把大叔来首发资源提供给其他人;
 *             如被发现，将取消大叔来VIP会员资格，停止一切后期更新支持以及所有补丁BUG等修正服务；
 *          
 * 大.叔.来出品 必属精品
 * 大叔来 全网首发 https://Www.dashulai.com
 * 官网：www.dashulai.com (请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：QQ 9866 92927
 * 谢谢支持，感谢你对.大叔来.的关注和信赖！！！   
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once libfile('function/common','plugin/zhikai_sms');

if(submitcheck('submit')){
		if(empty($_GET['delete'])){
			cpmsg(lang('plugin/zhikai_sms', 'langssms012'), dreferer(), 'error');
		}else{
			foreach ($_GET['delete'] as $del){
				C::t('#zhikai_sms#zhikai_smslog')->delete(array('id' => $del));
			}
			cpmsg(lang('plugin/zhikai_sms', 'langssms013'), dreferer(), 'succeed');
		}
}else if(submitcheck('submitall')){
	
	C::t('#zhikai_sms#zhikai_smslog')->delete(array('send_state' => 2));
	cpmsg(lang('plugin/zhikai_sms', 'langssms014'),dreferer(), 'success');
}else if(submitcheck('submitverify_state')){

	C::t('#zhikai_sms#zhikai_smslog')->delete(array('verify_state' => 2));
	cpmsg(lang('plugin/zhikai_sms', 'langssms015'),dreferer(), 'success');
}

$perpage = 15;
$curpage = empty($_GET['page']) ? 1 : intval($_GET['page']);
$start = ($curpage-1)*$perpage;

$uid = dintval($_GET['uid']);
$mobile = dintval($_GET['mobile']);
$send_state = dintval($_GET['send_state']);
$send_typeval = dintval($_GET['send_type']);

$send_date1 = dmktime($_GET['send_date1']);
$send_date2 = dmktime($_GET['send_date2']);

    $where = array();
	if($uid){
		$where['uid'] = $uid;
	}
	if($mobile){
		$where['mobile'] = $mobile;
	}
	if($send_state){
		$where['send_state'] = $send_state;
	}
	if($send_typeval){
		$where['send_type'] = $send_typeval;
	}
	
	if($send_date1){
		$date = strtotime(date('Y-m-d',$send_date1));
		$where['send_date1'] = $date;
	}
	if($send_date2){
		$date2 = strtotime(date('Y-m-d',strtotime( "+1 day",$send_date2)));
		$where['send_date2'] = $date2;
	}

$count = C::t('#zhikai_sms#zhikai_smslog')->get_zhikai_smslog_count($where);
$mpurl = ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=zhikai_sms&pmod=AdminSmsLog&uid=".$uid."&send_state=".$send_state."&send_type=".$send_typeval."&send_date1=".$send_date1."&send_date2=".$send_date2."&mobile=".$mobile;

$multipage = multi($count, $perpage,$curpage,$mpurl, 0, 5);
$log_list = C::t('#zhikai_sms#zhikai_smslog')->get_zhikai_smslog_list($start,$perpage,$where);

$bnt = lang('plugin/zhikai_sms', 'langssms002');
$uid = lang('plugin/zhikai_sms', 'langssms001');
$mobile = lang('plugin/zhikai_sms', 'langssms003');
$log_data = lang('plugin/zhikai_sms', 'langssms016');

$screen = lang('plugin/zhikai_sms', 'langssms017');
$send_states = array();
$send_states[] = array(1,lang('plugin/zhikai_sms', 'langssms018'));
$send_states[] = array(2,lang('plugin/zhikai_sms', 'langssms019'));
$send_stat = sms_get_select('send_state', $send_states, $send_state, array(0, lang('plugin/zhikai_sms', 'langssms020')));

$send_type = lang('plugin/zhikai_sms', 'langssms021');
$send_types = array();
$send_types[] = array(1,lang('plugin/zhikai_sms', 'langssms022'));
$send_types[] = array(2,lang('plugin/zhikai_sms', 'langssms023'));
$send_types[] = array(3,lang('plugin/zhikai_sms', 'langssms024'));
$send_types[] = array(4,lang('plugin/zhikai_sms', 'langssms025'));
$send_types[] = array(5,lang('plugin/zhikai_sms', 'langssms026'));
$send_types[] = array(6,lang('plugin/zhikai_sms', 'langssms027'));
$state = sms_get_select('send_type', $send_types, $send_typeval, array(0, lang('plugin/zhikai_sms', 'langssms020')));

echo <<<SEARCH
        <script src="static/js/calendar.js" type="text/javascript"></script>
		<form method="post" autocomplete="off" id="tb_search" action="$mpurl">
		<table style="padding:10px 0;">
			<tbody>
			<tr>
			<th>
			    <td>&nbsp;$screen&nbsp;</td><td>$send_stat</td>
				<td>&nbsp;&nbsp;&nbsp;$send_type</td><td>&nbsp;$state&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;$mobile</td><td>&nbsp;<td><input type="text" name="mobile" value="" style="width:180px;"></td>
                <td>&nbsp;&nbsp;&nbsp;$uid</td><td>&nbsp;<td><input type="text" name="uid" value="" style="width:80px;"></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$log_data</td><td>&nbsp;<td>
                  <input type="text" class="txt" name="send_date1" value="{$_GET['send_date1']}" onclick="showcalendar(event, this)">~
                  <input type="text" class="txt" name="send_date2" value="{$_GET['send_date2']}" onclick="showcalendar(event, this)">
				</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="submit" class="btn" value="$bnt"></td>
			</th>
			</tr>
			</tbody>
		</table>
		</form>
SEARCH;

showformheader('plugins&operation=config&do='.$pluginid.'&identifier=zhikai_sms&pmod=AdminSmsLog','enctype');
	showtableheader(lang('plugin/zhikai_sms', 'langssms028'));
		showsubtitle(array(
		    lang('plugin/zhikai_sms', 'langssms029'),
			'ID',
			'UID',
			lang('plugin/zhikai_sms', 'langssms004'),
			lang('plugin/zhikai_sms', 'langssms003'),
			lang('plugin/zhikai_sms', 'langssms030'),
			lang('plugin/zhikai_sms', 'langssms031'),
			lang('plugin/zhikai_sms', 'langssms032'),
			lang('plugin/zhikai_sms', 'langssms033'),
			lang('plugin/zhikai_sms', 'langssms034'),
			lang('plugin/zhikai_sms', 'langssms035'),
			lang('plugin/zhikai_sms', 'langssms036'),
			lang('plugin/zhikai_sms', 'langssms037'),
			lang('plugin/zhikai_sms', 'langssms038')
		));
		foreach ($log_list as $k => $v) {
			$name = getuserbyuid($v['uid']);
				switch ($v['send_type']) {
					case 1:
                        $send_type = lang('plugin/zhikai_sms', 'langssms022');
						break;
					case 2:
                        $send_type = lang('plugin/zhikai_sms', 'langssms023');
						break;
					case 3:
                        $send_type = lang('plugin/zhikai_sms', 'langssms024');
						break;
					case 4:
                        $send_type = lang('plugin/zhikai_sms', 'langssms025');
						break;
					case 5:
                        $send_type = lang('plugin/zhikai_sms', 'langssms026');
						break;
					default:
                        $send_type = lang('plugin/zhikai_sms', 'langssms027');
						break;
				}
			showtablerow('', array('class="td25"','', 'class="td25"', 'class="td25"'), array(
			    '<input type="checkbox" class="txt" name="delete[]" value="'.$v['id'].'" />',
				$v['id'],
				$v['uid'],
				$name['username'],
			    $v['mobile'],
				$v['send_state'] == 1 ? '<em style="color:#FF5722;">'.lang('plugin/zhikai_sms', 'langssms039').'</em>' : lang('plugin/zhikai_sms', 'langssms040'),
				$send_type,
				$v['smscode'],
				$v['mobile_province'],
				$v['mobile_carrier'],
				$v['userip1'].'.'.$v['userip2'].'.'.$v['userip3'].'.'.$v['userip4'],
				$v['verify_state'] == 1 ? lang('plugin/zhikai_sms', 'langssms041'): '<em style="color:#4CAF50;">'.lang('plugin/zhikai_sms', 'langssms042').'</em>',
				$v['return_servicer'],
				dgmdate($v['send_date'],'Y-m-d H:i:s')
			));
		}
		echo '<td colspan="5"><input type="checkbox" onclick="checkAll(\'prefix\', this.form, \'delete\',\'chkall\')" class="checkbox" id="chkall" name="chkall"><label for="chkall">'.lang('plugin/zhikai_sms', 'langssms043').'</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="'.lang('plugin/zhikai_sms', 'langssms044').'" name="submitall" id="submitall" class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="'.lang('plugin/zhikai_sms', 'langssms045').'" name="submitverify_state" id="submitverify_state" class="btn"></td>';
		showsubmit('submit', lang('plugin/zhikai_sms', 'langssms046'),'','',$multipage);
	showtablefooter();
showformfooter();
?>