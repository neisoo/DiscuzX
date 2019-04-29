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
    exit('Access Discuz');
}
global $_G;
require_once dirname(__FILE__) . '/qidou.class.php';
$uid = $_G['uid'];
$username = $_G['username'];
$config = $_G['cache']['plugin']['qidou_assign'];
$assetsBaseUrlPath = $_G['siteurl'] . '/source/plugin/' . Qidou::PLUGIN_ID . '/template';
if ($_GET['act']) {
    $act = trim($_GET['act']);
}
if ($_POST['act']) {
    $act = trim($_POST['act']);
}
$isapp = strpos($_SERVER['HTTP_USER_AGENT'], 'Appbyme');
if ($isapp !== false) {
    $isapp = 1;
} else {
    $isapp = 0;
}

if (!$uid) {
    if (!$isapp) {
        header("Location: " . $_G['siteurl'] . "member.php?mod=logging&action=login");
    } else {
        include template('qidou_assign:login');
    }
    exit;
}
if ($act == '') {
    $pics = explode("\n", $config['pics']);
    foreach ($pics as &$row) {
        $row = explode('|', $row);
    }
    $goods = explode("\n", $config['goods']);
    foreach ($goods as &$row) {
        $row = explode('|', $row);
    }

    $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
    if (!$mysign) {
        $mysign = array('uid' => $uid, 'username' => $username, 'tian' => 0, 'signtime' => time(), 'totaltian' => 0, 'liantian' => 0, 'totalmoney' => 0, 'date' => 0);
        C::t('#qidou_assign#qidou_assign_item')->insert($mysign);
    }
    $mysign['cha'] = (7 - $mysign['tian']);
    $date = date('Y-m-d');
    if ($mysign['signdate'] == $date) {
        $mysign['sign'] = 1;
    } else {
        $zuotian = date("Y-m-d", strtotime("-1 day"));
        if ($mysign['signdate'] == $zuotian) {
            $mysign['tian'] = $mysign['liantian'];
        } else {
            $mysign['tian'] = 0;
        }
        if ($mysign['signdate'] != $zuotian) {
            $mysign['tian'] = 0;
            $liantian = 1;
            $mysign['lt'] = 0;
            $lt = 1;
        } else {
            $lt =  $mysign['lt'] + 1;
            $liantian = $mysign['liantian'] + 1;
        }
        $continues = explode('=', $config['continues']);
        
        if($continues[0] == $mysign['lt'] || $mysign['lt'] > $continues[0] && $continues && $config['continue'] == 1){
            $lt = 1;
        }
        $text = strpos($mysign['date'], date('Y-m-d'));
        if (is_numeric($text)) {
            $date = $mysign['date'];
        } else {
            if ($mysign['date']) {
                $date = $mysign['date'] . ',' . date('Y-m-d');
            } else {
                $date = date('Y-m-d');
            }
        }
        $firstday = date('Y-m-01', strtotime(date("Y-m-d")));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        if ($lastday == date('Y-m-d')) {
            $endtotal = $liantian;
        } else {
            $endtotal = $mysign['endtotal'];
        }
        $data = array(
            'signdate' => date('Y-m-d'),
            'signtime' => time(),
            'tian' => $mysign['tian'] + 1,
            'liantian' => $liantian,
            'lt' => $lt,
            'totaltian' => $mysign['totaltian'] + 1,
            'date' => $date,
            'endtotal' => $endtotal,
        );
        foreach (explode("\n", $config['continue_currencies']) as $value) {
            list($key, $val) = explode('=', $value);
            $continue[$key] = $val;
        }
        if ($config['continue'] == 1 && $config['continue_currencies']) {
            foreach ($continue as $key => $row) {
                if ($key == $liantian) {
                    $gold = $config['get_currencies'] + $row;
                    break;
                }elseif($mysign['liantian'] < $key && $liantian > $key ){
                    $gold = $config['get_currencies'] + $row;
                    break;
                } else {
                    $gold = $config['get_currencies'];
                }
            }
        } else {
            $gold = $config['get_currencies'];
        }
        
        if($lt == $continues[0] && $config['continue'] == 1 && $continues){
            if($gold){
                $gold = $gold +  $continues[1];
            }else{
                $gold = $continues[1];
            }
        }
        
        
        $data['totalmoney'] = $mysign['totalmoney'] + $gold;
        $result = C::t('#qidou_assign#qidou_assign_item')->update($data, array('uid' => $uid));
        updatemembercount($uid, array('extcredits' . $config['type'] => $gold), true, 'SIG', 1, 1, 1, 1);
    }
    $dates = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
    $days = date('t');
    for ($i = 1; $i <= $days; $i++) {
        if ($i < 10) {
            $i = "0" . $i;
        }
        $tian[$i] = date('Y-m-') . $i;
    }
    foreach ($tian as $row) {
        $text = strpos($dates['date'], $row);
        if (!is_numeric($text)) {
            if ($row < date('Y-m-d')) {
                $bu .= '"' . $row . '"' . ',';
            }
        }
    }
    $dates['date'] = explode(',', $dates['date']);
    foreach ($dates['date'] as &$row) {
        $row = '"' . $row . '"';
    }
    $dates['date'] = implode(',', $dates['date']);
    $dates['bu_date'] = explode(',', $dates['bu_date']);
    foreach ($dates['bu_date'] as &$row) {
        $row = '"' . $row . '"';
    }
    $dates['bu_date'] = implode(',', $dates['bu_date']);

    $day_num = C::t('#qidou_assign#qidou_assign_item')->tongji(1);
    $day_num = $day_num['num'];

    $zt_num = C::t('#qidou_assign#qidou_assign_item')->tongji();
    $zt_num = $zt_num['num'];

    $is_gold = $_G['cache']['plugin']['qidou_gold'];
    $is_jifen = $_G['cache']['plugin']['qidou_jifen'];
    include template('qidou_assign:index');
} elseif ($act == 'checkbq') {
    //check补签卡
    $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
    if ($mysign['buqian'] > 0) {
        $datas['status'] = 1;
    } else {
        $datas['status'] = 0;
    }
    echo json_encode($datas);
    exit;
} elseif ($act == 'buy') {
    if ($_G['formhash'] != trim($_POST['formhash'])) {
        $datas['status'] = 0;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'buy_error'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'buy_error');
        }

        echo json_encode($datas);
        exit;
    }
    //购买补签卡
    $userinfo = DB::fetch_first('SELECT extcredits1,extcredits2,extcredits3,extcredits4,extcredits5,extcredits6,extcredits7,extcredits8 from %t where uid=%d', array('common_member_count', $uid));
    $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
    $data['buqian'] = $mysign['buqian'] + 1;
    if ($userinfo['extcredits' . $config['type']] > $config['buqian']) {
		
        $result = C::t('#qidou_assign#qidou_assign_item')->update($data, array('uid' => $uid));
    } else {
        $datas['status'] = 0;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', $config['code'] . $_G['setting']['extcredits'][$config['type']]['title'] . lang('plugin/qidou_assign', 'buy_bz'));
        } else {
            $datas['msg'] = $_G['setting']['extcredits'][$config['type']]['title'] . lang('plugin/qidou_assign', 'buy_bz');
        }
        echo json_encode($datas);
        exit;
    }
    if ($result) {
        $datas['status'] = 1;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'buy_success'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'buy_success');
        }
        updatemembercount($uid, array('extcredits' . $config['type'] => -$config['buqian']), true, 'BQK', 1, 1, 1, 1);
    } else {
        $datas['status'] = 0;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'buy_error'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'buy_error');
        }
    }
    echo json_encode($datas);
    exit;
} elseif ($act == 'buqian') {
    if ($_G['formhash'] != trim($_POST['formhash'])) {
        $datas['status'] = 0;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'bqsb'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'bqsb');
        }
        echo json_encode($datas);
        exit;
    }
    //用户补签
    $butian = trim($_POST['bu']);
    if(!$butian){
            $datas['status'] = 0;
            if ($_G['charset'] == 'gbk') {
                    $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'bqsb'));
            } else {
                    $datas['msg'] = lang('plugin/qidou_assign', 'bqsb');
            }
            echo json_encode($datas);
            exit;
    }
    $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
    $firstday = date('Y-m-01', strtotime(date("Y-m-d")));
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    $text = strpos($mysign['date'], $firstday);
    if (!is_numeric($text)) {
        $liantian = 0;
    } else {
        $liantian = $mysign['endtotal'];
    }
    //是否已补签
    if ($mysign['bu_date']) {
        $cfbq = strpos($mysign['bu_date'], $butian);
        if (is_numeric($cfbq)) {
            $datas['status'] = 0;
            if ($_G['charset'] == 'gbk') {
                $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'bqsb'));
            } else {
                $datas['msg'] = lang('plugin/qidou_assign', 'bqsb');
            }
            echo json_encode($datas);
            exit;
        }
    }
    //
    if ($butian) {
        $yiqian = $mysign['date'] . ',' . $butian . ',' . $mysign['bu_date'];
        $dates = explode(',', $yiqian);
    } else {
        $yiqian = $mysign['date'] . ',' . $mysign['bu_date'];
        $dates = explode(',', $mysign['date']);
    }


    foreach ($dates as $key => $row) {
        if (date('Y-m') == substr($row, 0, -3)) {
            $benyue[substr($row, -2)] = $row;
        }
    }

    //补签
    if ($mysign['bu_date'] && $butian) {
        $bu = $mysign['bu_date'] . ',' . $butian;
    } elseif ($butian) {
        $bu = $butian;
    } else {
        $datas['status'] = 0;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'bqsb'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'bqsb');
        }

        echo json_encode($datas);
        exit;
    }

    ksort($benyue);
    $days = date('t');

    //连天计算
    for ($i = 1; $i <= $days; $i++) {
        if ($i < 10) {
            $i = "0" . $i;
        }
        if (date('Y-m-') . $i <= date('Y-m-d')) {
            foreach ($benyue as $row) {
                if($row ==  date('Y-m-').$i && $i == 01 ){
                    $liantian = $mysign['endtotal'] + 1;
                    $i++;
                    if ($i < 10) {
                        $i = "0" . $i;
                    }
                    continue;
                }else if ($row == date('Y-m-') . $i) {
                    $liantian = $liantian + 1;
                    $i++;
                    if ($i < 10) {
                        $i = "0" . $i;
                    }
                    continue;
                } else {
                    $liantian = 0;
                }
            }
        }
    }
    
    $data['liantian'] = $liantian;
    $data['date'] = $mysign['date'];
    $data['bu_date'] = $bu;
    $data['buqian'] = $mysign['buqian'] - 1;
    $data['totaltian'] = $mysign['totaltian'] + 1;
    
    $continues = explode('=', $config['continues']);
    if($continues[0] == $mysign['lt'] || $mysign['lt'] > $continues[0] && $continues && $config['continue'] == 1){
        $data['lt'] = 1;
    }else{
        $data['lt'] = $mysign['lt']+1;
    }
    
    if ($lastday == date('Y-m-d')) {
        $data['endtotal'] = $liantian;
    }

    foreach (explode("\n", $config['continue_currencies']) as $value) {
        list($key, $val) = explode('=', $value);
        $continue[$key] = $val;
    }
    if ($config['continue'] == 1) {
        foreach ($continue as $key => $row) {
            if ($key == $liantian) {
                $gold = $config['get_currencies'] + $row;
                break;
            }elseif($mysign['liantian'] < $key && $liantian > $key ){
                $gold = $config['get_currencies'] + $row;
                break;
            } else {
                $gold = $config['get_currencies'];
            }
        }
    } else {
        $gold = $config['get_currencies'];
    }

    $data['totalmoney'] = $mysign['totalmoney'] + $gold;
    $result = C::t('#qidou_assign#qidou_assign_item')->update($data, array('uid' => $uid));
    if ($result) {
        if ($gold) {
            updatemembercount($uid, array('extcredits' . $config['type'] => $gold), true, 'SIG', 1, 1, 1, 1);
        }
        $datas['status'] = 1;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'bqcg'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'bqcg');
        }
    } else {
        $datas['status'] = 0;
        if ($_G['charset'] == 'gbk') {
            $datas['msg'] = iconv('GB2312', 'UTF-8', lang('plugin/qidou_assign', 'bqsb'));
        } else {
            $datas['msg'] = lang('plugin/qidou_assign', 'bqsb');
        }
    }
    echo json_encode($datas);
    exit;
} elseif ($act == 'phb') {

    $list = C::t('#qidou_assign#qidou_assign_item')->fetch_list();

    $arr1 = $list[0];
    $arr2 = $list[1];
    $arr3 = $list[2];
    if ($arr1['uid'] == $uid) {
        $my = array('num' => 1, 'data' => $arr1);
    }
    if ($arr2['uid'] == $uid) {
        $my = array('num' => 2, 'data' => $arr2);
    }
    if ($arr3['uid'] == $uid) {
        $my = array('num' => 3, 'data' => $arr3);
    }

    unset($list[0]);
    unset($list[1]);
    unset($list[2]);
    $num = 4;
    if ($list) {
        foreach ($list as &$row) {
            if ($row['uid'] == $uid) {
                $my = array('num' => $num, 'data' => $row);
            }
            $record[$num] = $row;
            $num++;
        }
    }
	if(!$my){
	   $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
	   $my = array('num' => '99+', 'data' => $mysign);
	}
	

    include template('qidou_assign:phb');
} elseif ($act == 'phb1') {

    $list = C::t('#qidou_assign#qidou_assign_item')->fetch_list1();
    $arr1 = $list[0];
    $arr2 = $list[1];
    $arr3 = $list[2];
    if ($arr1['uid'] == $uid) {
        $my = array('num' => 1, 'data' => $arr1);
    }
    if ($arr2['uid'] == $uid) {
        $my = array('num' => 2, 'data' => $arr2);
    }
    if ($arr3['uid'] == $uid) {
        $my = array('num' => 3, 'data' => $arr3);
    }
    unset($list[0]);
    unset($list[1]);
    unset($list[2]);
    $num = 4;
    if ($list) {
        foreach ($list as &$row) {
            if ($row['uid'] == $uid) {
                $my = array('num' => $num, 'data' => $row);
            }
            $record[$num] = $row;
            $num++;
        }
    }
	if(!$my){
	   $mysign = C::t('#qidou_assign#qidou_assign_item')->fetch($uid);
	   $my = array('num' => '99+', 'data' => $mysign);
	}
    include template('qidou_assign:phb1');
}