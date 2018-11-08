<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
	<div class="n5sq_ztds cl">
	    <a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
		<div class="ztds_mbxx cl">
			<img src="<!--{avatar($post[authorid], middle, true)}-->">
			<p class="mbxx_yhm">$post[author]</p>
			<p>{$n5app['reward_tip']}</p>
		</div>
		<div class="ztds_dsys cl">
		<form id="rateform" method="post" autocomplete="off" action="forum.php?mod=misc&action=rate&ratesubmit=yes&mobile=2" onsubmit="ajaxpost('rateform', 'return_rate', 'return_rate', 'onerror');">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="tid" value="$_G[tid]" />
		<input type="hidden" name="pid" value="$_GET[pid]" />
		<input type="hidden" name="referer" value="$referer" />
		<table width="100%">
			<!--{loop $ratelist $id $options}-->
			<tr>
						<td class="dsys_jfmc">{$_G['setting']['extcredits'][$id][img]} {$_G['setting']['extcredits'][$id][title]}</td>
						<td class="dsys_srys"><input type="text" name="score$id" id="score$id" class="px z" value="" /></td>
						<td class="dsys_mrxe">{$_G['group']['raterange'][$id]['min']} ~ {$_G['group']['raterange'][$id]['max']}</td>
			</tr>
			<!--{/loop}-->
		</table>
		<div class="dsys_pfly cl">
			<input type="text" name="reason" id="reason$post[pid]" class="px" onkeyup="seditor_ctlent(event, '$(\'rateform\').ratesubmit.click()')" placeholder="{$n5app['lang']['dssljyyb']}" />
			<span class="pfly_xzan"><i class="iconfont icon-n5appxxanly"></i></span>
			<select id="uiSel$post[pid]" class="pfly_lyxz">
				<option value="{$n5app['lang']['tnpflya']}">{$n5app['lang']['tnpflya']}</option>
				<option value="{$n5app['lang']['tnpflyb']}">{$n5app['lang']['tnpflyb']}</option>
				<option value="{$n5app['lang']['tnpflyc']}">{$n5app['lang']['tnpflyc']}</option>
				<option value="{$n5app['lang']['tnpflyd']}">{$n5app['lang']['tnpflyd']}</option>
				<option value="{$n5app['lang']['tnpflye']}">{$n5app['lang']['tnpflye']}</option>
				<option value="{$n5app['lang']['tnpflyf']}">{$n5app['lang']['tnpflyf']}</option>
			</select>
			<script type="text/javascript">
				document.getElementById('uiSel$post[pid]').onchange=function (){
				  if(this.options[0].value==-1)this.options[0]=null;
				  document.getElementById('reason$post[pid]').value=this.value
				};
			</script>
		</div>
		<div class="dsys_tzkg cl">
			  <div class="y cl"><input type="checkbox" name="sendreasonpm" id="sendreasonpm" class="pc"{if $_G['group']['reasonpm'] == 2 || $_G['group']['reasonpm'] == 3} checked="checked" disabled="disabled"{/if} /><label for="sendreasonpm"></label></div>
			<div class="z cl">{lang admin_pm}</div>
		</div>
		<button name="ratesubmit" type="submit" value="true" class="dsys_dsan">{$n5app['lang']['sqdashang']}</button>
		</form>
		</div>
	</div>

<!--{template common/footer}-->