<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->

{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span><!--{if $_GET[action] == 'log'}-->{lang my_medals}<!--{else}-->{lang medals_center}<!--{/if}--></span>
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
				<li{if empty($_GET[action])} class="a"{/if}><a href="home.php?mod=medal">{lang medals_center}</a></li>
				<li{if $_GET[action] == 'log'} class="a"{/if}><a href="home.php?mod=medal&action=log">{lang my_medals}</a></li>
			</ul>
		</div>
	</div>
</div>
			<!--{if empty($_GET[action])}-->
				<!--{if $medallist}-->
				<!--{if $_G[uid]}-->
					<!--{if $medalcredits}-->
						<div class="n5xz_xzjf">
							{lang you_have_now}
							<!--{eval $i = 0;}-->
							<!--{loop $medalcredits $id}-->
								<!--{if $i != 0}-->, <!--{/if}-->{$_G['setting']['extcredits'][$id][img]} {$_G['setting']['extcredits'][$id][title]} <i><!--{echo getuserprofile('extcredits'.$id);}--></i> {$_G['setting']['extcredits'][$id][unit]}
								<!--{eval $i++;}-->
							<!--{/loop}-->
						</div>
					<!--{/if}-->
				<!--{else}-->
					<style type="text/css">
						.n5xz_xzlb li {height: 110px;} 
					</style>
				<!--{/if}-->
					<div class="n5xz_xzlb cl">
						<ul>
						<!--{loop $medallist $key $medal}-->
							<li>
								<div class="n5xz_xztb"><img src="{STATICURL}image/common/$medal[image]"></div>
								<p class="n5xz_xzmc">$medal[name] <i>(<!--{if $medal[expiration]}-->
												{lang expire} $medal[expiration] {lang days},
											<!--{/if}-->
											<!--{if $medal[permission] && !$medal['price']}-->
												$medal[permission]
											<!--{else}-->
												<!--{if $medal[type] == 0}-->
													{lang medals_type_0}
												<!--{elseif $medal[type] == 1}-->
													<!--{if $medal['price']}-->
														<!--{if {$_G['setting']['extcredits'][$medal[credit]][unit]}}-->
															{$_G['setting']['extcredits'][$medal[credit]][title]} <strong class="xi1 xw1 xs2">$medal[price]</strong> {$_G['setting']['extcredits'][$medal[credit]][unit]}
														<!--{else}-->
															<strong class="xi1 xw1 xs2">$medal[price]</strong> {$_G['setting']['extcredits'][$medal[credit]][title]}
														<!--{/if}-->
													<!--{else}-->
														{lang medals_type_1}
													<!--{/if}-->
												<!--{elseif $medal[type] == 2}-->
													{lang medals_type_2}
												<!--{/if}-->
											<!--{/if}-->)</i></p>
								<p class="n5xz_xzjs"><!--{echo cutstr($medal[description],24)}--></p>
								<div class="n5xz_hqan">
									<!--{if in_array($medal[medalid], $membermedal)}-->
										<a>{lang space_medal_have}</a>
									<!--{else}-->
										<!--{if $medal[type] && $_G['uid']}-->
											<!--{if in_array($medal[medalid], $mymedals)}-->
												<!--{if $medal['price']}-->
													<a>{lang space_medal_purchased}</a>
												<!--{else}-->
													<!--{if !$medal[permission]}-->
														<a>{lang space_medal_applied}</a>
													<!--{else}-->
														<a>{lang space_medal_receive}</a>
													<!--{/if}-->
												<!--{/if}-->
											<!--{else}-->
												<a href="home.php?mod=medal&action=confirm&medalid=$medal[medalid]" class="xi2 {if $_G['uid']}dialog{else}n5app_wdlts{/if}">
													<!--{if $medal['price']}-->
														{lang space_medal_buy}
													<!--{else}-->
														<!--{if !$medal[permission]}-->
															{lang medals_apply}
														<!--{else}-->
															{lang medals_draw}
														<!--{/if}-->
													<!--{/if}-->
												</a>
											<!--{/if}-->
										<!--{/if}-->
									<!--{/if}-->
								</div>
							</li>
						<!--{/loop}-->
						</ul>
					</div>
				<!--{else}-->
					<style type="text/css">
						.n5qj_wnr {padding: 40px 0 40px 0;}
					</style>
					<!--{if $medallogs}-->
						<div class="n5qj_wnr">
							<img src="template/zhikai_n5app/images/tbys_xsc.png">
							<p>{lang medals_nonexistence}</p>
						</div>
					<!--{else}-->
						<div class="n5qj_wnr">
							<img src="template/zhikai_n5app/images/n5sq_gzts.png">
							<p>{lang medals_noavailable}</p>
						</div>	
					<!--{/if}-->
				<!--{/if}-->

				<!--{if $lastmedals}-->
				<div class="n5xz_xzjl">
					<h3>{lang medals_record}</h3>
					<ul>
						<!--{loop $lastmedals $lastmedal}-->
						<li>
							<div class="dslb_txys cl"><a href="home.php?mod=space&uid=$lastmedal[uid]&do=profile"><!--{avatar($lastmedal[uid],middle)}--></a></div>
							<div class="dslb_hyxx cl">
								<span class="y">$lastmedal[dateline]</span>
								<div class="dslb_hypf cl"><a href="home.php?mod=space&uid=$lastmedal[uid]&do=profile" class="rate_user">$lastmedalusers[$lastmedal[uid]][username]</a></div>
								<p>{lang medals_message2}$medallist[$lastmedal['medalid']]['name']{lang medals}</p>
							</div>
						</li>
						<!--{/loop}-->
					</ul>
				</div>
				<!--{/if}-->
			<!--{elseif $_GET[action] == 'log'}-->

				<!--{if $mymedals}-->
					<ul class="n5xz_wdxz cl">
						<!--{loop $mymedals $mymedal}-->
						<li>
							<img src="{STATICURL}image/common/$mymedal[image]"/>
							<p>$mymedal[name]</p>
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->

				<!--{if $medallogs}-->
				<div class="n5xz_xzjl n5xz_wxzjl">
					<h3 class="tbmu">{lang medals_record}</h3>
					<ul class="el ptm pbw mbw">
						<!--{loop $medallogs $medallog}-->
						<li>
							<!--{if $medallog['type'] == 2 || $medallog['type'] == 3}-->
								{lang medals_message3} $medallog[dateline] {lang medals_message4} <strong>$medallog[name]</strong> {lang medals},<!--{if $medallog['type'] == 2}-->{lang medals_operation_2}<!--{elseif $medallog['type'] == 3}-->{lang medals_operation_3}<!--{/if}-->
							<!--{elseif $medallog['type'] != 2 && $medallog['type'] != 3}-->
								{lang medals_message3} $medallog[dateline] {lang medals_message5} <strong>$medallog[name]</strong> {lang medals},<!--{if $medallog[expiration]}-->{lang expire}: $medallog[expiration]<!--{else}-->{lang medals_noexpire}<!--{/if}-->
							<!--{/if}-->
						</li>
						<!--{/loop}-->
					</ul>
				</div>
					<!--{if $multipage}-->$multipage<!--{/if}-->
				<!--{else}-->
					<div class="n5qj_wnr">
						<img src="template/zhikai_n5app/images/n5sq_gzts.png">
						<p>{lang medals_nonexistence_own}</p>
					</div>
				<!--{/if}-->
			<!--{/if}-->


<!--{template common/footer}-->