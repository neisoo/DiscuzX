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

if (submitcheck('submit')) {
	$temparr = daddslashes($_GET);
	$temparrs = array();
	foreach ($temparr['tempname'] as $k => $v) {
		if (in_array($k, $temparr['delete'])) {
			continue;
		}
		$temparrs[$k]['tempid'] = $temparr['tempid'][$k];
		$temparrs[$k]['tempname'] = $temparr['tempname'][$k];
		$temparrs[$k]['temptxt'] = $temparr['temptxt'][$k];
		$temparrs[$k]['tempsign'] = $temparr['tempsign'][$k];
		$temparrs[$k]['temptype'] = $temparr['temptype'][$k];
		$temparrs[$k]['tempapi'] = $temparr['tempapi'][$k];
	}
	if(!$temparrs){
		$temparrs ='no';
	}
	zhikai_writetocache($temparrs);
	cpmsg(lang('plugin/zhikai_sms', 'langssms047'),dreferer(), 'success');
}

$temptypearr = array();
$temptypearr[] = array(1, lang('plugin/zhikai_sms', 'langssms022'));
$temptypearr[] = array(2, lang('plugin/zhikai_sms', 'langssms023'));
$temptypearr[] = array(3, lang('plugin/zhikai_sms', 'langssms024'));
$temptypearr[] = array(4, lang('plugin/zhikai_sms', 'langssms025'));
$temptypearr[] = array(5, lang('plugin/zhikai_sms', 'langssms026'));
$temptypearr[] = array(6, lang('plugin/zhikai_sms', 'langssms027'));

$tempapiarr = array();
$tempapiarr[] = array(1, lang('plugin/zhikai_sms', 'langssms048'));
$tempapiarr[] = array(2, lang('plugin/zhikai_sms', 'langssms049'));
$tempapijs = sms_get_select('tempapi[]', $tempapiarr,'', array(0, lang('plugin/zhikai_sms', 'langssms020')));
$temptypejs = sms_get_select('temptype[]', $temptypearr, '', array(0, lang('plugin/zhikai_sms', 'langssms020')));

showtips(lang('plugin/zhikai_sms', 'langssms050'),'',true,lang('plugin/zhikai_sms', 'langssms051'));

showformheader('plugins&operation=config&do='.$pluginid.'&identifier=zhikai_sms&pmod=AdminSmsTemplate','enctype');
showtableheader(lang('plugin/zhikai_sms', 'langssms052'));
	showsubtitle(array(
	    lang('plugin/zhikai_sms', 'langssms029'),
		lang('plugin/zhikai_sms', 'langssms053'),
		lang('plugin/zhikai_sms', 'langssms054'),
		lang('plugin/zhikai_sms', 'langssms055'),
		lang('plugin/zhikai_sms', 'langssms056'),
		lang('plugin/zhikai_sms', 'langssms057'),
		lang('plugin/zhikai_sms', 'langssms058'),
		'',
		''
	));
    $smstemparr = zhikai_writetocache();
	foreach ($smstemparr as $key => $value) {
		$temptype = sms_get_select('temptype['.$key.']', $temptypearr, $value['temptype'], array(0, lang('plugin/zhikai_sms', 'langssms020')));
		$tempapi = sms_get_select('tempapi['.$key.']', $tempapiarr, $value['tempapi'], array(0, lang('plugin/zhikai_sms', 'langssms020')));
		showtablerow('', array('class="td25"','class="td30"', 'class="td30"', '', 'class="td30"', 'class="td25"', 'class="td25"', 'class="td25"', 'class="td25"'), array(
		    '<input type="checkbox" class="txt" name="delete['.$key.']" value="'.$key.'" />',
			'<input type="text" class="txt" name="tempname['.$key.']" value="'.$value['tempname'].'" />',
			'<input type="text" class="txt" name="tempid['.$key.']" value="'.$value['tempid'].'" />',
			'<input type="text" class="txt" name="temptxt['.$key.']" value="'.$value['temptxt'].'" style="width:80%"/>',
			'<input type="text" class="txt" name="tempsign['.$key.']" value="'.$value['tempsign'].'" />',
			$temptype,
			$tempapi
		));
	}
echo '<tr><td colspan="1"></td><td><div><a href="javascript:;" onclick="addrow(this, 0);" class="addtr">'.lang('plugin/zhikai_sms', 'langssms059').'</a></div></td></tr>';
echo <<<EOT
	<script type="text/JavaScript">
		var rowtypedata = [
			[
			    [1,'<input type="checkbox" class="txt" name="delete[]" value="">', 'td25'],
				[1,'<input type="text" class="txt" name="tempname[]" value="">', 'td30'],
				[1,'<input type="text" class="txt" name="tempid[]" value="">','td30'],
				[1,'<input type="text" class="txt" name="temptxt[]" value="" style="width:80%">',''],
				[1,'<input type="text" class="txt" name="tempsign[]" value="" />','td30'],
				[1,'{$temptypejs}','td25'],
				[1,'{$tempapijs}','td25']
			]
		];
	</script>
EOT;
	showsubmit('submit',lang('plugin/zhikai_sms', 'langssms060'));
showtablefooter();
showformfooter();	
?>