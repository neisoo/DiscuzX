<?php
/**
 * 
 * ��-��-�����ѣ�Ϊ��֤��������Դ�ĸ���ά�����ϣ���ֹ�������׷���Դ�����ⷺ�ģ�
 *             ϣ���������ش�������Դ�Ļ�Ա��Ҫ����Ѵ������׷���Դ�ṩ��������;
 *             �类���֣���ȡ��������VIP��Ա�ʸ�ֹͣһ�к��ڸ���֧���Լ����в���BUG����������
 *          
 * ��.��.����Ʒ ������Ʒ
 * ������ ȫ���׷� https://Www.dashulai.com
 * ������www.dashulai.com (���ղر���!)
 * ����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 * ����֧��/����ά����QQ 9866 92927
 * лл֧�֣���л���.������.�Ĺ�ע������������   
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once libfile('function/common','plugin/zhikai_sms');

$perpage = 15;
$curpage = empty($_GET['page']) ? 1 : intval($_GET['page']);
$start = ($curpage-1)*$perpage;
$uid = dintval($_GET['uid']);
$mobile = dintval($_GET['mobile']);
    $where = array();
	if($uid){
		$where['uid'] = $uid;
	}
	if($mobile){
		$where['mobile'] = $mobile;
	}

$count = C::t('#zhikai_sms#zhikai_smslog')->get_zhikai_smslog_count($where);
$mpurl = ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=zhikai_sms&pmod=AdminBinding&uid=".$uid."&mobile=".$mobile;

$multipage = multi($count, $perpage,$curpage,$mpurl, 0, 5);
$log_list = C::t('#zhikai_sms#zhikai_smslog')->get_zhikai_smslog_list($start,$perpage,$where);
$group = C::t('common_usergroup')->range();

$bnt = lang('plugin/zhikai_sms', 'langssms002');
$uid = lang('plugin/zhikai_sms', 'langssms001');
$mobile = lang('plugin/zhikai_sms', 'langssms003');
echo <<<SEARCH
        <script src="static/js/calendar.js" type="text/javascript"></script>
		<form method="post" autocomplete="off" id="tb_search" action="$mpurl">
		<table style="padding:10px 0;">
			<tbody>
			<tr>
			<th>
                <td>&nbsp;&nbsp;&nbsp;$mobile</td><td>&nbsp;<td><input type="text" name="mobile" value="" style="width:180px;"></td>
                <td>&nbsp;&nbsp;&nbsp;$uid</td><td>&nbsp;<td><input type="text" name="uid" value="" style="width:80px;"></td>
				<td>&nbsp;&nbsp;&nbsp;<input type="submit" class="btn" value="$bnt"></td>
			</th>
			</tr>
			</tbody>
		</table>
		</form>
SEARCH;

showformheader('plugins&operation=config&do='.$pluginid.'&identifier=zhikai_sms&pmod=AdminBinding','enctype');
	showtableheader(lang('plugin/zhikai_sms', 'langssms011'));
		showsubtitle(array(
		    'ID',
			lang('plugin/zhikai_sms', 'langssms001'),
			lang('plugin/zhikai_sms', 'langssms004'),
			lang('plugin/zhikai_sms', 'langssms005'),
			lang('plugin/zhikai_sms', 'langssms145'),
			lang('plugin/zhikai_sms', 'langssms006'),
			lang('plugin/zhikai_sms', 'langssms007'),
			lang('plugin/zhikai_sms', 'langssms003'),
			lang('plugin/zhikai_sms', 'langssms008')
		));
		foreach ($log_list as $k => $v) {
			$name = getuserbyuid($v['uid']);
			$Bin = CheckBinPlugin_state($v['uid']);
			showtablerow('',array('class="td25"'), array(
			    $v['id'],
				$v['uid'],
				$name['username'],
				$group[$name['groupid']]['grouptitle'],
				$Bin == 1 ? '<em style="color:#4CAF50;">'.lang('plugin/zhikai_sms', 'langssms143').'</em>' : lang('plugin/zhikai_sms', 'langssms144'),
				isphone_verify($v['uid']) ? '<em style="color:#FF9800;">'.lang('plugin/zhikai_sms', 'langssms009').'</em>' : lang('plugin/zhikai_sms', 'langssms010'),
				dgmdate($v['send_date'],'Y-m-d H:i:s'),
				$v['mobile'],
				$v['mobile_carrier']
			));
		}
		echo '<td colspan="5">'.$multipage.'</td>';
	showtablefooter();
showformfooter();
?>