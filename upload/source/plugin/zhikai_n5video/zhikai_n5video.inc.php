<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$act = daddslashes($_GET['act']);
$uid = dintval($_GET['uid']);
if(!empty($uid) && $uid != $_G['uid']){
	echo 'error';exit;
}

if($act == 'add' && $_GET['formhash'] == FORMHASH){
	$data = array();
	$data['faid'] = dintval($_GET['aid']);
	$data['furl'] = daddslashes($_GET['url']);
	if($data['faid']){
		$flist = DB::result_first("SELECT * FROM %t WHERE faid=%d",array('zhikai_vdocover',$data['faid']));
		if($flist['id']){
			DB::update('zhikai_vdocover',$data,array('id' => $flist['id']),true);
		}else{
			DB::insert('zhikai_vdocover',$data,true);;
		}
		echo 'succeed';exit;//fr o  m ww w.mo qu 8.c om
	}
}else if($act == 'del' && $_GET['formhash'] == FORMHASH){
	$aid = dintval($_GET['aid']);
	if($aid){
		DB::delete('zhikai_vdocover',array('faid' => $aid));
		echo 'succeed';exit;
	}
}
?>