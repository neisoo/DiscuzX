<?php exit;?>
<!--{template common/header_f}-->
{eval}
$n5app = init_n5app();
function init_n5app(){
	global $_G;
	$n5app['lang'] = dzlang();
	return $n5app;
}
function dzlang(){
	global $_G;
	$addonname = 'zhikai_n5appgl';
	$dlang = array();
	for($i=1;$i<1000;$i++){
		$key = 'lang'.sprintf("%03d", $i);
		$dlang[$key] = lang('plugin/'.$addonname, $key);
		$tmp = explode("=",$dlang[$key]);
		if(count($tmp) == 2){
			$dlang[$tmp[0]] = $tmp[1];
		}
	}
	return $dlang;
}
{/eval}
<script type="text/javascript" src="template/zhikai_n5app/js/common.js"></script>
<script type="text/javascript">
	var allowpostattach = parseInt('{$_G['group']['allowpostattach']}');
	var allowpostimg = parseInt('$allowpostimg');
	var pid = parseInt('$pid');
	var tid = parseInt('$_G[tid]');
	var extensions = '{$_G['group']['attachextensions']}';
	var imgexts = '$imgexts';
	var postminchars = parseInt('$_G['setting']['minpostsize']');
	var postmaxchars = parseInt('$_G['setting']['maxpostsize']');
	var disablepostctrl = parseInt('{$_G['group']['disablepostctrl']}');
	var seccodecheck = parseInt('<!--{if $seccodecheck}-->1<!--{else}-->0<!--{/if}-->');
	var secqaacheck = parseInt('<!--{if $secqaacheck}-->1<!--{else}-->0<!--{/if}-->');
	var typerequired = parseInt('{$_G[forum][threadtypes][required]}');
	var sortrequired = parseInt('{$_G[forum][threadsorts][required]}');
	var special = parseInt('$special');
	var isfirstpost = <!--{if $isfirstpost}-->1<!--{else}-->0<!--{/if}-->;
	var allowposttrade = parseInt('{$_G['group']['allowposttrade']}');
	var allowpostreward = parseInt('{$_G['group']['allowpostreward']}');
	var allowpostactivity = parseInt('{$_G['group']['allowpostactivity']}');
	var sortid = parseInt('$sortid');
	var special = parseInt('$special');
	var fid = $_G['fid'];
	var postaction = '{$_GET['action']}';
	var ispicstyleforum = <!--{if $_G['forum']['picstyle']}-->1<!--{else}-->0<!--{/if}-->;
</script>
<!--{if $_GET[action] == 'edit'}--><!--{eval $editor[value] = $postinfo[message];}--><!--{else}--><!--{eval $editor[value] = $message;}--><!--{/if}-->
<!--{if $isfirstpost && $sortid}-->
<script type="text/javascript">
	var forum_optionlist = <!--{if $forum_optionlist}-->'$forum_optionlist'<!--{else}-->''<!--{/if}-->;
</script>
<script type="text/javascript" src="template/zhikai_n5app/js/threadsort.js"></script>
<!--{/if}-->
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"></a>
	<span><!--{if $_GET[action] == 'newthread'}-->{$n5app['lang']['sqfabusssq']}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{elseif $_GET[action] == 'edit'}-->{$n5app['lang']['sqdengjibj']}<!--{/if}--></span>
</div>
<script src="template/zhikai_n5app/js/mobiscroll_002.js" type="text/javascript"></script>
<link href="template/zhikai_n5app/common/mobiscroll_002.css" rel="stylesheet" type="text/css">
<script src="template/zhikai_n5app/js/mobiscroll.js" type="text/javascript"></script>
<script src="template/zhikai_n5app/js/mobiscroll_003.js" type="text/javascript"></script>
<link href="template/zhikai_n5app/common/mobiscroll_003.css" rel="stylesheet" type="text/css">
<div class="n5sq_ztfb cl">
<!--{eval $adveditor = $isfirstpost && $special || $special == 2 && ($_GET['action'] == 'newthread' || $_GET['action'] == 'reply' && !empty($_GET['addtrade']) || $_GET['action'] == 'edit' && $thread['special'] == 2);}--> 
<!--{eval $advmore = !$showthreadsorts && !$special || $_GET['action'] == 'reply' && empty($_GET['addtrade']) || $_GET['action'] == 'edit' && !$isfirstpost && ($thread['special'] == 2 && !$special || $thread['special'] != 2);}-->
	<form method="post" id="postform" enctype="multipart/form-data"
		{if $_GET[action] == 'newthread'}action="forum.php?mod=post&action={if $special != 2}newthread{else}newtrade{/if}&fid=$_G[fid]&extra=$extra&topicsubmit=yes&mobile=2"
		{elseif $_GET[action] == 'reply'}action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&extra=$extra&replysubmit=yes&mobile=2"
		{elseif $_GET[action] == 'edit'}action="forum.php?mod=post&action=edit&extra=$extra&editsubmit=yes&mobile=2" $enctype
		{/if}>
			<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
			<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
		<!--{if $_GET['action'] == 'edit'}-->
			<input type="hidden" name="delattachop" id="delattachop" value="0" />
		<!--{/if}--> 
		<!--{if !empty($_GET['modthreadkey'])}-->
			<input type="hidden" name="modthreadkey" id="modthreadkey" value="$_GET['modthreadkey']" />
		<!--{/if}-->
		<input type="hidden" name="wysiwyg" id="{$editorid}_mode" value="$editormode" />
		<!--{if $_GET[action] == 'reply'}-->
			<input type="hidden" name="noticeauthor" value="$noticeauthor" />
			<input type="hidden" name="noticetrimstr" value="$noticetrimstr" />
			<input type="hidden" name="noticeauthormsg" value="$noticeauthormsg" />
		<!--{if $reppid}-->
			<input type="hidden" name="reppid" value="$reppid" />
		<!--{/if}--> 
		<!--{if $_GET[reppost]}-->
			<input type="hidden" name="reppost" value="$_GET[reppost]" />
		<!--{elseif $_GET[repquote]}-->
			<input type="hidden" name="reppost" value="$_GET[repquote]" />
		<!--{/if}--> 
		<!--{/if}--> 
		<!--{if $_GET[action] == 'edit'}-->
			<input type="hidden" name="fid" id="fid" value="$_G[fid]" />
			<input type="hidden" name="tid" value="$_G[tid]" />
			<input type="hidden" name="pid" value="$pid" />
			<input type="hidden" name="page" value="$_GET[page]" />
		<!--{/if}--> 
		<!--{if $special}-->
			<input type="hidden" name="special" value="$special" />
		<!--{/if}--> 
		<!--{if $specialextra}-->
			<input type="hidden" name="specialextra" value="$specialextra" />
		<!--{/if}-->
	<!--{if $_GET[action] == 'newthread'}-->
	<script src="template/zhikai_n5app/js/fabufl.js"></script>
	<div class="n5sq_ztfl">
		<div class="ztfl_flzt">
			<div class="ztfl_fllb">
				<ul id="n5sq_glpd">
					<!--{if !$_G['forum']['allowspecialonly']}-->
						<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" {if $postspecialcheck[0]} selected="selected"{/if}>{$n5app['lang']['sqtsfbpt']}</a></li>
                    <!--{/if}--> 
                    <!--{loop $_G['forum']['threadsorts'][types] $tsortid $name}-->
						<li><a href="forum.php?mod=post&action=newthread&sortid=$tsortid&fid=$_G[fid]" {if $sortid == $tsortid} selected="selected" {/if}><!--{echo strip_tags($name);}--></a></li>
                    <!--{/loop}--> 
                    <!--{if $_G['group']['allowpostpoll']}-->
						<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=1" {if $postspecialcheck[1]} selected="selected"{/if}>{$n5app['lang']['sqtsfbtp']}</a></li>
                    <!--{/if}--> 
                    <!--{if $_G['group']['allowpostreward']}-->
						<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=3" {if $postspecialcheck[3]} selected="selected"{/if}>{$n5app['lang']['sqtsfbxs']}</a></li>
                    <!--{/if}--> 
                    <!--{if $_G['group']['allowpostdebate']}-->
						<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=5" {if $postspecialcheck[5]} selected="selected"{/if}>{$n5app['lang']['sqtsfbbl']}</a></li>
                    <!--{/if}--> 
                    <!--{if $_G['group']['allowpostactivity']}-->
						<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=4" {if $postspecialcheck[4]} selected="selected"{/if}>{$n5app['lang']['sqtsfbhd']}</a></li>
                    <!--{/if}--> 
                    <!--{if $_G['group']['allowposttrade']}-->
						<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=2" {if $postspecialcheck[2]} selected="selected"{/if}>{$n5app['lang']['sqtsfbsp']}</a></li>
                    <!--{/if}-->
				</ul>
			</div>
			<div class="ztfl_ycgd"><span></span></div>
		</div>
	</div>
	<script type="text/javascript" language="javascript">
		var nav = document.getElementById("n5sq_glpd");
		var links = nav.getElementsByTagName("li");
		var lilen = nav.getElementsByTagName("a"); 
		var currenturl = document.location.href;
		var last = 0;
		for (var i=0;i<links.length;i++)
		{
			var linkurl =  lilen[i].getAttribute("href");
				if(currenturl.indexOf(linkurl)!=-1)
			{
				last = i;
			}
		}
        links[last].className = "a";
	</script>
	<!--{/if}-->
	
	<!--{subtemplate forum/post_editor_extra}-->
	<script src="template/zhikai_n5app/js/jquery.femoticons.js" type="text/javascript"></script>
	<div class="ztfb_nrsr cl">
		<textarea class="pt" id="needmessage" tabindex="3" autocomplete="off" id="{$editorid}_textarea" name="$editor[textarea]" cols="80" rows="2"  placeholder="{$n5app['lang']['sqftktishi']}" fwin="reply">$postinfo[message]</textarea>
	</div>
	<div class="ztfb_tpsc cl">
		<div class="tpsc_tpxz"><a href="javascript:;" id="addimg"><input type="file" name="Filedata" id="filedata" style="width:54px;height:54px;font-size:50px;opacity:0;"/></a></div>
		<div class="tpsc_tplb"><ul id="imglist"></ul></div>
	</div>
	
	<div class="ztfb_tabk">
		<ul class="ztfb_gnxx tabs cl">
			<li><a href="JavaScript:void(0)" id="message_face"><i class="iconfont icon-ftgnbqs"></i><p>{$n5app['lang']['fbszgnbq']}</p></a></li>
			<li><a href="JavaScript:void(0)"><i class="iconfont icon-ftgnsq"></i><p>{$n5app['lang']['fbszgnsp']}</p></a></li>
			<li><a href="javascript:void(0);"><i class="iconfont icon-ftgnsz"></i><p>{$n5app['lang']['shezhi']}</p></a></li>
			<li><a href="javascript:void(0);"><i class="iconfont icon-ftgncr"></i><p>{$n5app['lang']['fbszgncr']}</p></a></li>
			<!--{if $_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost}-->
				<!--{if ($_GET[action] == 'newthread' && $_G['group']['allowpostrushreply'] && $special != 2) || ($_GET[action] == 'edit' && getstatus($thread['status'], 3))}-->
					<li><a href="javascript:void(0);"><i class="iconfont icon-ftgnql"></i><p>{$n5app['lang']['fbszgnql']}</p></a></li>
				<!--{/if}-->
				<!--{if $_G['group']['maxprice'] && !$special}-->
					<li><a href="javascript:void(0);"><i class="iconfont icon-ftgnst"></i><p>{$n5app['lang']['fbszgnsf']}</p></a></li>
				<!--{/if}-->
				<!--{if $_G['group']['allowposttag']}-->
					<li><a href="javascript:void(0);"><i class="iconfont icon-ftgnbq"></i><p>{$n5app['lang']['fbszgnbqs']}</p></a></li>
				<!--{/if}-->
			<!--{/if}-->
		</ul>
		<!--{subtemplate forum/post_editor_attribute}-->
	</div>
	<script src="template/zhikai_n5app/js/fbszxx.js"></script>

	<!--{if $_GET[action] != 'edit' && ($secqaacheck || $seccodecheck)}-->
		<style type="text/css">
		.n5sq_ftyzm {background:#fff;padding:10px 12px;border-top: 1px solid #EEEEEE;}
		.n5sq_ftyzm .txt {width: 70%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 0;line-height: 23px;}
		.n5sq_ftyzm img {height: 25px;float: right;}
		</style>
		<!--{subtemplate common/seccheck}-->
	<!--{/if}-->
	
	<div class="ztfb_fban cl"><button id="postsubmit" class="btn_pn <!--{if $_GET[action] == 'edit'}-->btn_pn_blue" disable="false"<!--{else}-->btn_pn_grey" disable="true"<!--{/if}-->><!--{if $_GET[action] == 'newthread'}-->{lang send_thread}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{elseif $_GET[action] == 'edit'}-->{lang edit_save}<!--{/if}--></button></div>	
	<style type="text/css">
		.zhikai-form-radios {display:none;}
	</style>
	<!--{hook/post_bottom_mobile}-->
</form>
</div>

<script type="text/javascript">
	$("#message_face").jqfaceedit({txtAreaObj:$("#needmessage"),containerObj:$('#kshf_bqzs')});
</script>
<script type="text/javascript">
	(function() {
		var needsubject = needmessage = false;

		<!--{if $_GET[action] == 'reply'}-->
			needsubject = true;
		<!--{elseif $_GET[action] == 'edit'}-->
			needsubject = needmessage = true;
		<!--{/if}-->

		<!--{if $_GET[action] == 'newthread' || ($_GET[action] == 'edit' && $isfirstpost)}-->
		$('#needsubject').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				needsubject = true;
				if(needmessage == true) {
					$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
					$('.btn_pn').attr('disable', 'false');
				}
			} else {
				needsubject = false;
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
		<!--{/if}-->
		$('#needmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				needmessage = true;
				if(needsubject == true) {
					$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
					$('.btn_pn').attr('disable', 'false');
				}
			} else {
				needmessage = false;
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});

		$('#needmessage').on('scroll', function() {
			var obj = $(this);
			if(obj.scrollTop() > 0) {
				obj.attr('rows', parseInt(obj.attr('rows'))+2);
			}
		}).scrollTop($(document).height());
	 })();
</script>
<script type="text/javascript" src="{STATICURL}js/mobile/ajaxfileupload.js?{VERHASH}"></script>
<script type="text/javascript" src="{STATICURL}js/mobile/buildfileupload.js?{VERHASH}"></script>
<script type="text/javascript">
	var imgexts = typeof imgexts == 'undefined' ? 'jpg, jpeg, gif, png' : imgexts;
	var STATUSMSG = {
		'-1' : '{lang uploadstatusmsgnag1}',
		'0' : '{lang uploadstatusmsg0}',
		'1' : '{lang uploadstatusmsg1}',
		'2' : '{lang uploadstatusmsg2}',
		'3' : '{lang uploadstatusmsg3}',
		'4' : '{lang uploadstatusmsg4}',
		'5' : '{lang uploadstatusmsg5}',
		'6' : '{lang uploadstatusmsg6}',
		'7' : '{lang uploadstatusmsg7}(' + imgexts + ')',
		'8' : '{lang uploadstatusmsg8}',
		'9' : '{lang uploadstatusmsg9}',
		'10' : '{lang uploadstatusmsg10}',
		'11' : '{lang uploadstatusmsg11}'
	};
	var form = $('#postform');
	$(document).on('change', '#addimg #filedata', function() {
			popup.open('<div class="n5qj_jzys"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');

			uploadsuccess = function(data) {
				if(data == '') {
					popup.open('{lang uploadpicfailed}', 'alert');
				}
				var dataarr = data.split('|');
				if(dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
					popup.close();
					$('#imglist').append('<li><span aid="'+dataarr[3]+'" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;"><img style="height:54px;width:54px;" id="aimg_'+dataarr[3]+'" title="'+dataarr[6]+'" src="{$_G[setting][attachurl]}forum/'+dataarr[5]+'" /></a></span><input type="hidden" name="attachnew['+dataarr[3]+'][description]" /></li>');
				} else {
					var sizelimit = '';
					if(dataarr[7] == 'ban') {
						sizelimit = '{lang uploadpicatttypeban}';
					} else if(dataarr[7] == 'perday') {
						sizelimit = '{lang donotcross}'+Math.ceil(dataarr[8]/1024)+'K)';
					} else if(dataarr[7] > 0) {
						sizelimit = '{lang donotcross}'+Math.ceil(dataarr[7]/1024)+'K)';
					}
					popup.open(STATUSMSG[dataarr[2]] + sizelimit, 'alert');
				}
			};

			if(typeof FileReader != 'undefined' && this.files[0]) {
				
				$.buildfileupload({
					uploadurl:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
					files:this.files,
					uploadformdata:{uid:"$_G[uid]", hash:"<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"},
					uploadinputname:'Filedata',
					maxfilesize:"$swfconfig[max]",
					success:uploadsuccess,
					error:function() {
						popup.open('{lang uploadpicfailed}', 'alert');
					}
				});

			} else {

				$.ajaxfileupload({
					url:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
					data:{uid:"$_G[uid]", hash:"<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"},
					dataType:'text',
					fileElementId:'filedata',
					success:uploadsuccess,
					error: function() {
						popup.open('{lang uploadpicfailed}', 'alert');
					}
				});

			}
	});

	<!--{if 0 && $_G['setting']['mobile']['geoposition']}-->
	geo.getcurrentposition();
	<!--{/if}-->
	$('#postsubmit').on('click', function() {
		var obj = $(this);
		if(obj.attr('disable') == 'true') {
			return false;
		}

		obj.attr('disable', 'true').removeClass('btn_pn_blue').addClass('btn_pn_grey');
		popup.open('<div class="n5qj_jzys"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
        
		var postlocation = '';
		//if(geo.errmsg === '' && geo.loc) {
//			postlocation = geo.longitude + '|' + geo.latitude + '|' + geo.loc;
//		}

		$.ajax({
			type:'POST',
			url:form.attr('action') + '&geoloc=' + postlocation + '&handlekey='+form.attr('id')+'&inajax=1',
			data:form.serialize(),
			dataType:'xml'
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});

	$(document).on('click', '.del', function() {
		var obj = $(this);
		$.ajax({
			type:'GET',
			url:'forum.php?mod=ajax&action=deleteattach&inajax=yes&aids[]=' + obj.attr('aid'),
		})
		.success(function(s) {
			obj.parent().remove();
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});
</script>
<script type="text/javascript">
    $(function () {
		var currYear = (new Date()).getFullYear();	
		var opt={};
		opt.date = {preset : 'date'};
		opt.datetime = {preset : 'datetime'};
		opt.time = {preset : 'time'};
		opt.default = {
			theme: 'android-ics light', 
		    display: 'modal', 
		    mode: 'scroller', 
			dateFormat: 'yyyy-mm-dd',
			lang: 'zh',
			showNow: true,
			nowText: "{$n5app['lang']['sqshijianjt']}",
		    startYear: currYear - 10, 
		    endYear: currYear + 10 
		};

		$("#appDate").mobiscroll($.extend(opt['date'], opt['default']));
		var optDateTime = $.extend(opt['datetime'], opt['default']);
		var optTime = $.extend(opt['time'], opt['default']);
		$("#rushreplyfrom").mobiscroll(optDateTime).datetime(optDateTime);
		$("#rushreplyto").mobiscroll(optDateTime).datetime(optDateTime);
		$("#endtime").mobiscroll(optDateTime).datetime(optDateTime);
		$("#starttimefrom_0").mobiscroll(optDateTime).datetime(optDateTime);
		$("#starttimefrom_1").mobiscroll(optDateTime).datetime(optDateTime);
		$("#starttimeto").mobiscroll(optDateTime).datetime(optDateTime);
		$("#activityexpiration").mobiscroll(optDateTime).datetime(optDateTime);
		$("#item_expiration").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_lpkp").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_lpjf").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_grqzzpsr").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_grqzzpsj").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_escsp").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_escnj").mobiscroll(optDateTime).datetime(optDateTime);
		$("#typeoption_escbx").mobiscroll(optDateTime).datetime(optDateTime);
		$("#appTime").mobiscroll(optTime).time(optTime);
    });
</script>

<!--{eval $nofooter = true;}-->
<!--{template common/ffooter}-->
