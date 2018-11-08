<?php exit;?>
<!--{template common/header}-->
<!--{subtemplate home/spacecp_poke_type}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->

<!--{if $op == 'send' || $op == 'reply'}-->
	{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
	<style type="text/css">
	.bg {padding-top: 0;}
	</style>
	<div class="n5qj_wxgdan cl">
		<a href="javascript:history.back();" class="wxmsf"></a>
		<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
	</div>
	{else}
	<div class="n5qj_tbys nbg cl">
		<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
		<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
		<span>{$n5app['lang']['dazhaohu']}</span>
	</div>
	{/if}
	<style type="text/css">
		.ztfl_fllb {width: 100%;} 
		.ztfl_fllb ul li {width: 50%;padding: 0;}
	</style>
	<div class="n5sq_ztfl">
		<div class="ztfl_flzt">
			<div class="ztfl_fllb">
				<ul id="n5sq_glpd">
					<li$actives[poke]><a href="home.php?mod=spacecp&ac=poke">{lang poke_received}</a></li>
					<li$actives[send]><a href="home.php?mod=spacecp&ac=poke&op=send">{lang say_hi}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<form method="post" autocomplete="off" id="pokeform_{$tospace[uid]}" name="pokeform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=poke&op=$op&uid=$tospace[uid]">
		<input type="hidden" name="referer" value="{echo dreferer()}">
		<input type="hidden" name="pokesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="from" value="$_GET[from]" />
		<div class="n5zh_hdzh cl">
			<div class="hdzh_hyxx cl">
				<!--{if $tospace[uid]}-->
					<a href="home.php?mod=space&uid=$tospace[uid]" class="avt avts"><!--{avatar($tospace[uid],middle)}--></a>
					{lang to} <strong>{$tospace[username]}</strong> {lang say_hi}:
				<!--{else}-->
					{lang username}<input type="text" name="username" value="" class="px" placeholder="{$n5app['lang']['kjwdjfqsrhym']}"/>
				<!--{/if}-->
			</div>
			<ul class="hdzh_zhxm cl">
				<!--{loop $icons $k $v}-->
					<li><label for="poke_$k"><input type="radio" name="iconid" id="poke_$k" value="{$k}" {if $k==3}checked="checked"{/if} />{$v}</label></li>
				<!--{/loop}-->
			</ul>
			<div class="hdzh_tsyy">{lang max_text_poke_message}</div>
			<div class="hdzh_srnr"><input type="text" name="note" id="note" value="" size="30" onkeydown="ctrlEnter(event, 'pokesubmit_btn', 1);" class="px" placeholder="{$n5app['lang']['hykjsssrk']}"/></div>
		</div>
		<p class="n5zh_fsan cl">
			<button type="submit" name="pokesubmit_btn" id="pokesubmit_btn" value="true" class="pn">{lang send}</button>
		</p>
	</form>
	<script type="text/javascript">
		function succeedhandle_{$_GET[handlekey]}(url, msg, values) {
			if(values['from'] == 'notice') {
				deleteQueryNotice(values['uid'], 'pokeQuery');
			}
			showCreditPrompt();
		}
	</script>
<!--{elseif $op == 'ignore'}-->
			<div class="tip">
			<form method="post" autocomplete="off" id="friendform_{$uid}" name="friendform_{$uid}" action="home.php?mod=spacecp&ac=poke&op=ignore&uid=$uid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="ignoresubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="from" value="$_GET[from]" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<dt>{lang determine_lgnore_poke}</dt>
				<dd>
					<button type="submit" name="ignoresubmit_btn" class="pn pnc formdialog button2" value="true">{lang determine}</button>
					<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
				</dd>
			</form>
			</div>
<!--{else}-->
			{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
				<style type="text/css">
				.bg {padding-top: 0;}
				</style>
				<div class="n5qj_wxgdan cl">
					<a href="javascript:history.back();" class="wxmsf"></a>
					<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
				</div>
				{else}
				<div class="n5qj_tbys nbg cl">
					<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
					<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
					<span>{$n5app['lang']['dazhaohu']}</span>
				</div>
				{/if}
				<style type="text/css">
					.ztfl_fllb {width: 100%;} 
					.ztfl_fllb ul li {width: 50%;padding: 0;}
				</style>
				<div class="n5sq_ztfl">
					<div class="ztfl_flzt">
						<div class="ztfl_fllb">
							<ul id="n5sq_glpd">
								<li$actives[poke]><a href="home.php?mod=spacecp&ac=poke">{lang poke_received}</a></li>
								<li$actives[send]><a href="home.php?mod=spacecp&ac=poke&op=send">{lang say_hi}</a></li>
							</ul>
						</div>
					</div>
				</div>	
			<!--{if $list}-->
			<p class="n5zh_hlts">{lang you_can_reply_ignore}<a href="home.php?mod=spacecp&ac=poke&op=ignore" class="y dialog">{lang ignore_all}</a></p>
			<div class="h5zh_zhlb">
				<ul>
				<!--{loop $list $key $value}-->
				<li>
					<div class="zhlb_yhtx"><a href="home.php?mod=space&uid=$value[uid]"><!--{avatar($value[uid],middle)}--></a></div>
					<div class="zhlb_mcsj"><a href="home.php?mod=space&uid=$value[fromuid]" class="xi2">{$value[fromusername]}</a><span class="y"><!--{date($value[dateline], 'n-j H:i')}--></span></div>
					<div class="zhlb_zhnr">
						<!--{if $value[iconid]}-->{$icons[$value[iconid]]}<!--{else}-->{lang say_hi}<!--{/if}-->
						<!--{if $value[note]}-->, {lang say}: $value[note]<!--{/if}-->
					</div>
					<div class="zhlb_zhcz cl">
						<a href="home.php?mod=spacecp&ac=poke&op=reply&uid=$value[uid]&handlekey=pokereply" class="ys1"><i class="iconfont icon-n5apphdhf"></i>{lang back_to_say_hello}</a>
						<a href="home.php?mod=spacecp&ac=poke&op=ignore&uid=$value[uid]&handlekey=pokeignore" class="dialog ys2"><i class="iconfont icon-n5appkfgb"></i>{lang ignore}</a>
						<!--{if !$value['isfriend']}--><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=addfriendhk_{$value[uid]}" class="dialog ys3"><i class="iconfont icon-n5appgzlc"></i>{lang add_friend}</a><!--{/if}-->
					</div>
				</li>
				<!--{/loop}-->
				</ul>
			</div>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
			<!--{else}-->
				<style type="text/css">
					.n5qj_wnr {padding: 40px 0;}
				</style>
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{lang no_new_poke}</p>
				</div>
			<!--{/if}-->

			<script type="text/javascript">
				function succeedhandle_pokereply(url, msg, values) {
					if(parseInt(values['uid'])) {
						$('poke_'+values['uid']).style.display = "none";
					}
					showCreditPrompt();
				}
				function errorhandle_pokeignore(msg, values) {
					if(parseInt(values['uid'])) {
						$('poke_'+values['uid']).style.display = "none";
					}
				}
				function errorhandle_allignore(msg, values) {
					if($('poke_ul')) {
						$('poke_ul').innerHTML = '<p class="emp">{lang ignore_all_poke}</p>';
					}
				}
			</script>
<!--{/if}-->

<!--{template common/footer}-->