<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<form id="medalform" method="post" autocomplete="off" action="home.php?mod=medal&action=apply&medalsubmit=yes">
<div class="n5xz_xztc cl">
	<div class="f_c">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="medalid" value="$medal[medalid]" />
		<input type="hidden" name="operation" value="" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
			<div class="xztc_jsbg">
			<img src="{STATICURL}image/common/$medal[image]" alt="$medal[name]" style="margin: 5px 0 0 0" />
			<p class="xztcj1">$medal[name]</p>
			<p class="xztcj2">$medal[description]</p>
			</div>
			<p class="xztcj3">
						<!--{if $medal[expiration]}-->
							{lang expire} $medal[expiration] {lang days}<br />
						<!--{/if}-->
						<!--{if $medal[permission]}-->
							$medal[permission]<br />
						<!--{/if}-->
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
			</p>
	</div>
	<div class="pns">
		<!--{if $medal[type] && $_G['uid']}-->
			<button class="pn" type="submit" value="true" name="medalsubmit">
				<!--{if $medal['price']}-->
					{lang space_medal_buy}
				<!--{else}-->
					<!--{if !$medal[permission]}-->
						{lang medals_apply}
					<!--{else}-->
						{lang medals_draw}
					<!--{/if}-->
				<!--{/if}-->
			</button>
		<!--{/if}-->
	</div>
</div>
</form>
<!--{template common/footer}-->