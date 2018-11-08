<?php
// +----------------------------------------------------------------------
// | Copyright:    (c) 2014-2018 https://www.dashulai.com All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    大叔来 (Www.dashulai.Com 请收藏备用!)
// +----------------------------------------------------------------------
// | Author:       by 大叔来. 技术支持/更新维护：QQ 986692927
// +----------------------------------------------------------------------

if(!defined('IN_DISCUZ')) {

	exit('Access Denied');

}

include_once libfile('function/common','plugin/zhikai_sms');

class plugin_zhikai_sms {



    public static $config;



	public function __construct(){

		self::$config = config();

	}



	function common(){

		global $_G;

		if($_GET['mod'] == 'logging' && $_GET['action'] == 'login' && $_GET['viewlostpw'] == 1 && !$_GET['retrieve'] && !defined('IN_MOBILE')){

			include template('zhikai_sms:get_password');

		}

	}



	function global_header(){

		global $_G;

        $config = self::$config;

		if($_G['uid'] && $config['remind_verify'] && $_GET['motion'] !='verify' && $_GET['id'] != 'zhikai_sms:binding'){

            $Bin_state = CheckBinPlugin_state($_G['uid']);

			$remind_time = getcookie('remind_time');

			if(!$remind_time && $Bin_state != 1){

				dsetcookie('remind_time', '1', $config['remind_time']);

                return '<script type="text/javascript">showWindow(\'operateverify\',\'plugin.php?id=zhikai_sms:verify&motion=bin\');</script>';

			}

		}

	}



	function global_footer(){

return <<<EOT

<script type="text/javascript">

    !window.jQuery && document.write('<script type = "text/javascript" src ="source/plugin/zhikai_sms/static/js/jquery.min.js"><\/script>');

</script>

<script type="text/javascript">

	var zhikai = jQuery = jQuery.noConflict();

</script>

EOT;



	}



	function global_login_extra(){

		global $_G;

		$config = self::$config;

		$html = '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">

					<p><a href="javascript:;" onclick="showWindow(\'phonelogin\', \'plugin.php?id=zhikai_sms:phone_login&action=login\')">

					<img src="source/plugin/zhikai_sms/static/img/sj_login.png" class="vm"></a></p>

					<p class="hm xg1" style="padding-top: 2px;">'.lang('plugin/zhikai_sms', 'langssms071').'</p>

			    </div>';

		return $html;

	}

}





class plugin_zhikai_sms_member extends plugin_zhikai_sms {



	function logging_top(){

		global $_G;

        $username = daddslashes($_GET['username']);

    	if ($_GET['action'] == 'login') {

            if(isphone($username) && isphone_exist($username)){

                $uid = get_useruid($username);

				$user = getuserbyuid($uid);

				$_GET['username'] = $user['username'];

			}

		}

	}

	

	function logging_method(){

		$html = '<a href="javascript:;" onclick="hideWindow(\'login\', 0, 1);showWindow(\'phonelogin\', \'plugin.php?id=zhikai_sms:phone_login\');" target="_top" rel="nofollow"><img src="source/plugin/zhikai_sms/static/img/sj_login.png" class="vm" style="padding:3px 0px 3px 5px;"></a>';

		$html .= '<a href="javascript:;" onclick="showWindow(\'login\', \'member.php?mod=logging&action=login&viewlostpw=1\');" target="_top" rel="nofollow"><img src="source/plugin/zhikai_sms/static/img/sms_zh.png" class="vm" style="padding:3px 0px 3px 5px;"></a>';

		return $html;

	}

	

	function register_logging_method(){

		$html = '<a href="javascript:;" onclick="hideWindow(\'login\', 0, 1);showWindow(\'phonelogin\', \'plugin.php?id=zhikai_sms:phone_login\');" target="_top" rel="nofollow"><img src="source/plugin/zhikai_sms/static/img/sj_login.png" class="vm"></a>';

		return $html;

	}

	

	function register_bottom(){

		global $_G;

		$config = self::$config;

		$dreferer = dreferer();

		$bbrulehash = $_G['setting']['bbrules'] ? substr(md5(FORMHASH), 0, 8) : '';

		include template('zhikai_sms:zhikai_smsreg');

		return $return;

	}



}



class plugin_zhikai_sms_forum extends plugin_zhikai_sms {



	function post_middle(){

		global $_G;

		$config = self::$config;

		if(!$_G['groupid'] && !$_G['uid'])return;

		$phone = isphone_exist($_G['uid'], true);

		$Bin_state = CheckBinPlugin_state($_G['uid']);

		if(in_array($_G['groupid'], dunserialize($config['inform_fid_groupid'])) && !empty($phone) && $Bin_state == 1){

		    return '<div class="ptm cl"><label for="ispostnotice"><input type="checkbox" name="ispostnotice" id="ispostnotice" class="pc" value="1" checked="checked">'.lang('plugin/zhikai_sms', 'langssms074').'</label>';

		}

	}



	function post_remind(){

		global $_G;

		$config = self::$config;

	    if(!$_G['uid'] || !$_G['groupid'] || !in_array($_G['fid'], dunserialize($config['verify_fid'])))return;

		if($_GET['action'] == 'reply' && in_array($_G['groupid'], dunserialize($config['reply_verify_groupid']))){

			if (!isphone_verify($_G['uid'])){

				$js = '<script type="text/javascript">hideWindow(\'reply\');showWindow(\'operateverify\',\'plugin.php?id=zhikai_sms:verify&motion=verify\');</script>';

				showmessage(lang('plugin/zhikai_sms', 'langssms075'), '', array(), array('extrajs' => $js));

			}

		}else if(in_array($_G['groupid'], dunserialize($config['post_verify_groupid']))){

			if(!isphone_verify($_G['uid'])){

				showmessage(lang('plugin/zhikai_sms', 'langssms076'), 'plugin.php?id=zhikai_sms:verify&motion=verify');

			}

		}

	}



	function post_zhikai_sms_message($p) {

		global $_G;

		$config = self::$config;

		if($p['param']['0'] == 'post_newthread_succeed' && in_array($_G['groupid'], dunserialize($config['inform_fid_groupid']))){

			DB::insert('zhikai_postnotice',array(

				'uid'=> $_G['uid'],

				'tid' => $p['param']['2']['tid'],

		'ispostnotice' => dintval($_GET['ispostnotice']),

				'date' => TIMESTAMP),

				true

			);

		}else if($p['param']['0'] == 'post_reply_succeed' && in_array($_G['fid'], dunserialize($config['inform_fid']))){

		    $fid = $p['param']['2']['fid'];

		    $tid = $p['param']['2']['tid'];

			$authorid = DB::result_first('select authorid from %t where fid=%d and tid=%d and first=1', array('forum_post', $fid, $tid));

			$ispostnotice = DB::result_first('select ispostnotice from %t where uid=%d and tid=%d', array('zhikai_postnotice', $authorid, $tid));

			if($_G['uid'] != $authorid && $ispostnotice){

				smsnotice($authorid, $tid);

			}

		}

	}



}



class mobileplugin_zhikai_sms extends plugin_zhikai_sms {



	function global_header_mobile(){

		global $_G;

        $config = self::$config;

		if($_G['uid'] && $config['remind_verify'] && $_GET['id'] != 'zhikai_sms:binding'){

			$Bin_state = CheckBinPlugin_state($_G['uid']);

			$remind_time = getcookie('remind_time');

			if(!$remind_time && $Bin_state != 1){

			dsetcookie('remind_time', '1', $config['remind_time']);

			$html = '<link type="text/css" rel="stylesheet" href="source/plugin/zhikai_sms/static/css/style.css"/>

				<script type="text/javascript" src="source/plugin/zhikai_sms/static/js/zhikai.js"></script>

				<script type="text/javascript">zks.confirm("'.$config['bin_txt'].'",["'.lang('plugin/zhikai_sms','langssms113').'","'.lang('plugin/zhikai_sms','langssms046').'"], function(){var urls=\'plugin.php?id=zhikai_sms:verify&motion=bin\';window.setTimeout(function(){window.location.href=urls;},300);},function(){});</script>';

		        return $html;

			}

		}

	}



	function global_footer_mobile(){

		global $_G;

        $config = self::$config;

		if($_GET['mod'] == 'register'){

            $bbrulehash = $_G['setting']['bbrules'] ? substr(md5(FORMHASH), 0, 8) : '';

			$bbrulestxt = _DeleteHtml($_G['setting']['bbrulestxt']);

			include template('zhikai_sms:zhikai_smsreg');

			return $return;

		}

	}

}



class mobileplugin_zhikai_sms_member extends mobileplugin_zhikai_sms {



	function logging_top(){

		global $_G;

        $username = daddslashes($_GET['username']);

    	if (!empty($username) && $_GET['action'] == 'login' && $_GET['mod'] == 'logging') {

            if(isphone($username) && isphone_exist($username)){//检查手机正确性与是否存在

                $uid = get_useruid($username);

				$user = getuserbyuid($uid);

				$_GET['username'] = $user['username'];

			}

		}

	}



	function logging_bottom_mobile(){

		$html = '<style>.reg_link{font-size: 15px !important;padding-top: 8px !important;}</style>

			    <p class="reg_link"><a href="plugin.php?id=zhikai_sms:getpass">'.lang('plugin/zhikai_sms','langssms077').'</a>

				<a class="y" href="plugin.php?id=zhikai_sms:phone_login">'.lang('plugin/zhikai_sms', 'langssms112').'</a></p>

			    <script type="text/javascript">window.onload=function(){jQuery("[name=username]").attr(\'placeholder\',\''.lang('plugin/zhikai_sms','langssms111').'\');};</script>';

		return $html;

	}



}



class mobileplugin_zhikai_sms_forum extends mobileplugin_zhikai_sms {



	function post_bottom_mobile(){

		global $_G;

		$config = self::$config;

		if(!$_G['groupid'] && !$_G['uid'])return;

		$phone = isphone_exist($_G['uid'], true);

		$Bin_state = CheckBinPlugin_state($_G['uid']);

		if(in_array($_G['groupid'], dunserialize($config['inform_fid_groupid'])) && !empty($phone) && $Bin_state == 1){

		return '<link type="text/css" rel="stylesheet" href="source/plugin/zhikai_sms/static/css/style.css"/>

				<div class="zhikai-form-items">

					<div class="zhikai-form-radios">

					<input type="checkbox" value="1" name="ispostnotice" id="ispostnotice" checked="checked"><label for="ispostnotice">'.lang('plugin/zhikai_sms','langssms074').'</label>

					</div>

				</div>';

		}

	}

	

	function post_remind(){

		global $_G;

		$config = self::$config;

	    if(!$_G['uid'] || !$_G['groupid'] || !in_array($_G['fid'], dunserialize($config['verify_fid'])))return;

		if($_GET['action'] == 'reply' && in_array($_G['groupid'], dunserialize($config['reply_verify_groupid']))){

			if (!isphone_verify($_G['uid'])){

				showmessage(lang('plugin/zhikai_sms', 'langssms075'), 'plugin.php?id=zhikai_sms:verify&motion=verify');

			}

		}else if(in_array($_G['groupid'], dunserialize($config['post_verify_groupid']))){

			if(!isphone_verify($_G['uid'])){

				showmessage(lang('plugin/zhikai_sms', 'langssms076'), 'plugin.php?id=zhikai_sms:verify&motion=verify');

			}

		}

	}



	function post_zhikai_sms_message($p) {

		global $_G;

		$config = self::$config;

		if($p['param']['0'] == 'post_newthread_succeed' && in_array($_G['groupid'], dunserialize($config['inform_fid_groupid']))){

			DB::insert('zhikai_postnotice',array(

				'uid'=> $_G['uid'],

				'tid' => $p['param']['2']['tid'],

				'ispostnotice' => dintval($_GET['ispostnotice']),

				'date' => TIMESTAMP),

				true

			);

		}else if($p['param']['0'] == 'post_reply_succeed' && in_array($_G['fid'], dunserialize($config['inform_fid']))){

		    $fid = $p['param']['2']['fid'];

		    $tid = $p['param']['2']['tid'];

			$authorid = DB::result_first('select authorid from %t where fid=%d and tid=%d and first=1', array('forum_post', $fid, $tid));

			$ispostnotice = DB::result_first('select ispostnotice from %t where uid=%d and tid=%d', array('zhikai_postnotice', $authorid, $tid));

			if($_G['uid'] != $authorid && $ispostnotice){

				smsnotice($authorid, $tid);

			}

		}

	}

}
/**
 * dashulai.compyright For Discuz!X 3.4+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    dashulai.compyright
 * @module	   dashulai.Com 
 * @date	   2018-04-16
 * @author	   大叔来
 * @copyright  Copyright (c) 2018 Www.dashulai.com dashulai.com. (https://www.dashulai.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/

?>