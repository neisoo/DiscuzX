<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script>document.title = '{$n5app['jjseobt']}';</script>
<script type="text/javascript" src="template/zhikai_n5app/js/nav.js"></script>
<script type="text/javascript" src="template/zhikai_n5app/js/TouchSlide.1.1.source.js"></script>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:void(0);" class="cltxy"></a>
	<a href="search.php?mod=forum" class="wxmss"></a>
</div>
{else}
<style type="text/css">
.n5qj_tbys span img {height: {$n5app['index_logogd']};margin-top: {$n5app['index_logojl']};}
</style>
<div class="n5qj_tbys nbg cl">
	<a href="javascript:void(0);" class="n5qj_zcan"><div class="zcancl"><div class="cltxy"><!--{avatar($_G[uid])}--><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></div></div></a>
	<a href="search.php?mod=forum" class="n5qj_ycan sousuo" style="display:none;"></a>
	<!--{if $n5app['index_logo'] == 1}-->
	<span><img src="{$n5app['index_logodz']}"></span>
	<!--{elseif $n5app['index_logo'] == 2}-->
	<span>{$n5app['index_logomc']}</span>
	<!--{/if}-->
</div>
{/if}

<style type="text/css">
#bonfire-pageloader {display: none;}
</style>

<div class="n5qj_cldh">
<div class="cldh_hyxx cl">
	<div class="cldh_hytx z cl"><div class="cldh_txys"><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->"><!--{avatar($_G[uid])}--></a></div></div>
	<div class="cldh_hymc z cl">
		<div class="cldh_hync cl"><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->"><!--{if $_G[uid]}-->{$_G[member][username]}<!--{else}-->{$n5app['lang']['qjclyngjc']}<!--{/if}--></a><!--{if $_G[uid]}--><span style="display:none;">$_G[group][grouptitle]</span><!--{/if}--></div>
		<div class="cldh_hyqm cl">
			<!--{if $_G[uid]}-->
			<div class="cldh_hycz z cl" style="display:none;"><a href="{$n5app['sign']}" class="mrqdys">{$n5app['lang']['qiandoa']}</a></div>
			<div class="cldh_hycz z cl"><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" class="tcdlys dialog">{lang logout}</a></div>
			<!--{else}-->
			<div class="cldh_hycz z cl"><a href="member.php?mod=logging&action=login" class="tcdlys">{$n5app['lang']['login']}</a></div>
			<div class="cldh_hycz z cl"><a href="member.php?mod={$_G[setting][regname]}" class="hyzcys">{$n5app['lang']['regname']}</a></div>
			<!--{/if}-->
		</div>
	</div>
	<div class="n5jj_hdhd" style="display:none;">
		<div class="n5jj_hdhd_1"></div>
		<div class="n5jj_hdhd_2"></div>
	</div>
</div>
<div class="cldh_xxtx cl" style="display:none;">
	<ul>
		<li><a href="home.php?mod=space&do=notice&view=mypost" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_tx.png"><p>{$n5app['lang']['tixing']}</p></a><!--{if $_G[member][newprompt]}--><span></span><!--{/if}--></li>
		<li><a href="home.php?mod=space&do=pm" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_xx.png"><p>{$n5app['lang']['xiaoxi']}</p></a><!--{if $_G[member][newpm]}--><span></span><!--{/if}--></li>
		<li><a href="home.php?mod=space&uid={$_G[uid]}&do=profile&view=me" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_kj.png"><p>{$n5app['lang']['kongjian']}</p></a></li>
		<li><a href="home.php?mod=spacecp&ac=profile" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_sz.png"><p>{$n5app['lang']['shezhi']}</p></a></li>
	</ul>
</div>
<div class="cldh_kjdh cl">
	<a href="home.php?mod=space&do=thread&filter=common&dubbing=1&searchkey=public&mobile=2" class="n5ico"><div class="kjdh_kjtb"><i style="color:#F37D7D;" class="iconfont icon-clxwzx"></i></div><div class="kjdh_kjbt">我的配音</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
</div>
<div class="cldh_kjdh cl" style="display:none;">
	<a href="{$n5app['news_url']}" class="n5ico"><div class="kjdh_kjtb"><i style="color:#F37D7D;" class="iconfont icon-clxwzx"></i></div><div class="kjdh_kjbt">{$n5app['lang']['xinwen']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
	<a href="home.php?mod=task" class="n5ico"><div class="kjdh_kjtb"><i style="color:#FFB300;" class="iconfont icon-n5appwdrw"></i></div><div class="kjdh_kjbt">{$n5app['lang']['renwu']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
	<a href="forum.php?mod=announcement" class="n5ico"><div class="kjdh_kjtb"><i style="color:#3EBBFD;" class="iconfont icon-n5apphdtx"></i></div><div class="kjdh_kjbt">{$n5app['lang']['gonggao']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
	<a href="misc.php?mod=tag" class="n5ico"><div class="kjdh_kjtb"><i style="color:#b8da42;" class="iconfont icon-n5appbq"></i></div><div class="kjdh_kjbt">{$n5app['lang']['biaoqian']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
	<a href="misc.php?mod=ranklist&type=member&view=credit" class="n5ico"><div class="kjdh_kjtb"><i style="color:#91B9EB;" class="iconfont icon-clhyph"></i></div><div class="kjdh_kjbt">{$n5app['lang']['appphbgn']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
	<a href="home.php?mod=spacecp&ac=privacy" class="n5ico"><div class="kjdh_kjtb"><i style="color:#DA99DB;" class="iconfont icon-n5appfgsz"></i></div><div class="kjdh_kjbt">{$n5app['lang']['fengge']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>
	{if $n5app['onoff_qhdnb']}<a href="{$_G['setting']['mobile']['nomobileurl']}" class="n5ico"><div class="kjdh_kjtb"><i style="color:#ff9900;" class="iconfont icon-cljrdn"></i></div><div class="kjdh_kjbt">{$n5app['lang']['appgdqhdnb']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a>{/if}
	<!--{if $_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)}--><a href="admin.php" class="n5ico"><div class="kjdh_kjtb"><i style="color:#b8da42" class="iconfont icon-cljrht"></i></div><div class="kjdh_kjbt">{$n5app['lang']['cldhhtglxx']}</div><div class="kjdh_xytb"><i class="iconfont icon-n5appxy"></i></div></a><!--{/if}-->
</div>
</div>

{$n5app['guide_block']}

{if $n5app['jjnrlxkg']}
<div class="n5sq_jjqh cl">
	<ul>
		<li $currentview['newthread']><a href="forum.php?mod=guide&view=newthread">&#26368;&#26032;</a></li>
		<li $currentview['hot']><a href="forum.php?mod=guide&view=hot">&#28909;&#38376;</a></li>
		<li $currentview['digest']><a href="forum.php?mod=guide&view=digest">{$n5app['lang']['sqnrgljhxx']}</a></li>
	</ul>
</div>
{/if}
<div class="n5sq_ztlb cl">
<!--{loop $data $key $list}-->
	<!--{template forum/guide_list_row}-->
<!--{/loop}-->
</div>

{if $n5app['jjfyankz']}
$multipage
{/if}

<script src="template/zhikai_n5app/js/jquery.vticker.min.js"></script>
<script>
var jq = jQuery.noConflict(); 
jq(function(){
	jq('.sygg_ys').vTicker({
		showItems: 1,
		pause: 5000
	});
});
</script>
<script>
var jq = jQuery.noConflict(); 
jq(function(){
	jq('.jrtj_sjys').vTicker({
		showItems: 1,
		pause: 5000
	});
});
</script>
<script src="template/zhikai_n5app/js/swipe.js"></script>
<script>
	var dots=document.getElementsByClassName('dot');
	var slider = new Swipe(document.getElementById('slider'), {
	  startSlide: 0,
	  speed: 400,
	  auto: 3000,
	  continuous: true,
	  disableScroll: false,
	  stopPropagation: false,
	  callback: function(pos){
	  	document.getElementsByClassName('on')[0].className='dot';
	  	dots[pos].className='dot on';
	  }
	});
</script>
<div class="n5jj_dbjg"></div>

{if $n5app['kqfcab']}
<script type="text/javascript" src="template/zhikai_n5app/js/jquery.cookie.js"></script>
<script type="text/javascript">
var jq = jQuery.noConflict(); 
	jq(function(){
		if(jq.cookie("isClose") != 'yes'){
			var winWid = jq(window).width()/2 - jq('.n5fc_fcgg').width()/2;
			var winHig = jq(window).height()/2 - jq('.n5fc_fcgg').height()/2;
			jq(".n5fc_fcgg").css({"left":winWid,"top":-winHig*2});
			jq(".n5fc_fcgg").show();
			jq(".n5fc_fcgg").animate({"left":winWid,"top":winHig},1000);
			jq(".n5fc_fcgg span").click(function(){
				jq(this).parent().fadeOut(500);
				jq.cookie("isClose",'yes',{ expires:{$n5app['fcadet']}});
			});
		}
	});
</script>
<div class="n5fc_fcgg">
	<a href="{$n5app['fcadlj']}"><img src="{$n5app['fcadtp']}"></a>
	<span></span>
</div>
{/if}

<div class="n5qj_wbys cl" style="display:none;">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="qjyw_jjgl on"><i class="iconfont icon-n5appsyon"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class="qjyw_qzkz"><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->"  class="<!--{if $_G[uid]}-->qjyw_txys<!--{else}-->qjyw_wdkz<!--{/if}-->"><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb" style="display:none;"></div>
<!--{template common/footer}-->