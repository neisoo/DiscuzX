<?php exit;?>
<div class="ztfb_gdcz tab_content cl">
		<div id="kshf_bqzs" class="gnxx_bqzs tabs_item"></div>
		<div class="exfm tabs_item cl" >
			<!--{if in_array('zhikai_n5video',$_G['setting']['plugins']['available'])}-->
				<!--{hook/post_n5bottom_mobile}-->
			<!--{else}-->
				<div class="n5sp_wats cl">
					<i class="iconfont icon-ftgnsq"></i>{$n5app['lang']['fbszgnatss']}
				</div>
			<!--{/if}-->
		</div>
		<div class="exfm tabs_item cl">
			<table cellspacing="0" cellpadding="0">
				<!--{if $_GET[action] != 'edit'}-->
					<!--{if $_G['group']['allowanonymous']}-->
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['fbsznmft']}</div>
						<div class="czxm_xmnr z"><input type="checkbox" name="isanonymous" id="isanonymous" value="1" /><label for="isanonymous" id="isanonymous" class="y"></label></div>
					</div>
					<!--{/if}-->
				<!--{else}-->
					<!--{if $_G['group']['allowanonymous'] || (!$_G['group']['allowanonymous'] && $orig['anonymous'])}-->
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['fbsznmft']}</div>
						<div class="czxm_xmnr z"><input type="checkbox" name="isanonymous" id="isanonymous" value="1" {if $orig['anonymous']}checked="checked"{/if} /><label for="isanonymous" id="isanonymous" class="y"></label></div>
					</div>
					<!--{/if}-->
				<!--{/if}-->
				<!--{if $_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{$n5app['lang']['fbszzzkj']}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="hiddenreplies" id="hiddenreplies" {if $thread['hiddenreplies']} checked="checked"{/if} value="1"><label for="hiddenreplies" id="hiddenreplies" class="y"></label></div>
				</div>
				<!--{/if}-->
				<!--{if $_G['uid'] && ($_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost) && $special != 3}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{$n5app['lang']['fbszhtdx']}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="ordertype" id="ordertype" value="1" $ordertypecheck /><label for="ordertype" id="ordertype" class="y"></label></div>
				</div>
				<!--{/if}-->
				<!--{if ($_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost)}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{$n5app['lang']['fbszhttz']}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="allownoticeauthor" id="allownoticeauthor" value="1"{if $allownoticeauthor} checked="checked"{/if} /><label for="allownoticeauthor" id="allownoticeauthor" class="y"></label></div>
				</div>
				<!--{/if}-->
				<!--{if $_GET[action] != 'edit' && helper_access::check_module('feed') && $_G['forum']['allowfeed']}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang addfeed}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="addfeed" id="addfeed" value="1" $addfeedcheck><label for="addfeed" id="addfeed" class="y"></label></div>
				</div>
				<!--{/if}-->
			</table>
			
			<style type="text/css">
				#ispostnotice {display:none;}
				#ispostnotice + label {display: block;position: relative;cursor:pointer;padding:2px;width:32px;height:16px;background: #ddd;border-radius: 60px;}
				#ispostnotice + label:before,#ispostnotice + label:after {display: block;position: absolute;top: 1px;left: 1px;bottom: 1px;content: "";}
				#ispostnotice + label:after {width: 18px;height:18px;background-color: #fff;border-radius: 100%;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);transition: margin 0.4s;}
				#ispostnotice + label:before {right: 1px;background-color: #f1f1f1;border-radius: 60px;transition: background 0.4s;}
				#ispostnotice:checked + label:before {background-color: #41c2fc;}
				#ispostnotice:checked + label:after {margin-left: 16px;}
			</style>
			<div class="gdcz_czxm cl">
				<div class="czxm_xmbt z">{$n5app['lang']['sqftdxtzkg']}</div>
				<div class="czxm_xmnr z"><input type="checkbox" value="1" name="ispostnotice" id="ispostnotice" checked="checked"><label for="ispostnotice" id="ispostnotice" class="y"></label></div>
			</div>

			<!--{if helper_access::check_module('follow') && $_GET[action] != 'edit'}-->
			<style type="text/css">
				#adddynamic {display:none;}
				#adddynamic + label {display: block;position: relative;cursor:pointer;padding:2px;width:32px;height:16px;background: #ddd;border-radius: 60px;}
				#adddynamic + label:before,#adddynamic + label:after {display: block;position: absolute;top: 1px;left: 1px;bottom: 1px;content: "";}
				#adddynamic + label:after {width: 18px;height:18px;background-color: #fff;border-radius: 100%;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);transition: margin 0.4s;}
				#adddynamic + label:before {right: 1px;background-color: #f1f1f1;border-radius: 60px;transition: background 0.4s;}
				#adddynamic:checked + label:before {background-color: #41c2fc;}
				#adddynamic:checked + label:after {margin-left: 16px;}
			</style>
			<div class="ztfb_scht cl">
				<div class="scht_xxbt z cl">{$n5app['lang']['sqftschtts']}</div>
				<div class="scht_xxnr z cl"><input type="checkbox" name="adddynamic" id="adddynamic" value="true" {if $_G['forum']['allowfeed'] && !$_G[tid] && empty($_G['forum']['viewperm'])}checked="checked"{/if} /><label for="adddynamic" class="y" style="margin-top: 2px;"></label></div>
			</div>
			<!--{/if}-->
		</div>
		<div class="exfm tabs_item cl" style="background-color: transparent;">
		    <div class="n5fb_crgn cl">
				<ul class="crgn_btqh cl">
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnat"></i>{$n5app['lang']['fbszgnat']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnlj"></i>{$n5app['lang']['fbcrgnlj']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgntp"></i>{$n5app['lang']['fbcrgntp']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnmp3"></i>{$n5app['lang']['fbcrgnmp3']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnsp"></i>{$n5app['lang']['fbcrgnsp']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnfls"></i>{$n5app['lang']['fbcrgnfs']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnyy"></i>{$n5app['lang']['fbcrgnyy']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgndm"></i>{$n5app['lang']['fbcrgndm']}</a></li>
					<li><a href="JavaScript:void(0)"><i class="iconfont icon-fbcrgnmf"></i>{$n5app['lang']['fbcrgnmf']}</a></li>
				</ul>
				<div class="crgn_qhnr cl">
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsr"><input type="text" name="text" placeholder="{$n5app['lang']['kjwdjfqsrhym']}" id="fbcrwlat" class="crsr_srys"></div>
							<div class="crgn_crqr"><a href="javascript:;" id="fbcrwlatqr">{$n5app['lang']['fbszattj']}</a></div>
						</div>
						<div class="crgn_crts cl">{$n5app['lang']['fbszatts']}</div>
						<script type="text/javascript">
							$('#fbcrwlatqr').click(function(){
								console.log($("#fbcrwlat").val());
									if($("#fbcrwlat").val() == ''){
									alert('{$n5app['lang']['kjwdjfqsrhym']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"@"+$("#fbcrwlat").val()+" ");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crlj_srys cl"><input type="text" name="text" placeholder="{$n5app['lang']['fbcrcrljlj']}" id="fbcrljwz" class="athy_hsrk"></div>
						<div class="crlj_srys cl"><input type="text" name="text" placeholder="{$n5app['lang']['fbcrcrljwz']}" id="fbcrljlj" class="athy_hsrk"></div>
						<div class="crlj_cran cl"><a href="javascript:;" id="btn_inputljtj">{$n5app['lang']['fbszgncr']}</a></div>
						<script type="text/javascript">
							$('#btn_inputljtj').click(function(){
								console.log($("#fbcrljwz").val());
								if($("#fbcrljwz").val() == ''){
									alert('{$n5app['lang']['sqfbqingsrnr']}');
								return false;
							}else{
									$("#needmessage").val($("#needmessage").val()+"[url="+$("#fbcrljlj").val()+"]"+$("#fbcrljwz").val()+"[/url]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsr"><input type="text" name="text" placeholder="{$n5app['lang']['fbcrtptsb']}" id="fbcrwltp" class="crsr_srys"></div>
							<div class="crgn_crqr"><a href="javascript:;" id="fbcrwltpqr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<script type="text/javascript">
							$('#fbcrwltpqr').click(function(){
								console.log($("#fbcrwltp").val());
									if($("#fbcrwltp").val() == ''){
									alert('{$n5app['lang']['fbcrtptsb']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[img]"+$("#fbcrwltp").val()+"[/img]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsr"><input type="text" name="text" placeholder="{$n5app['lang']['fbcrmp3bt']}" id="fbcrmp3" class="crsr_srys"></div>
							<div class="crgn_crqr"><a href="javascript:;" id="fbcrmp3qr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<div class="crgn_crts cl">{$n5app['lang']['fbcrmp3ts']}</div>
						<script type="text/javascript">
							$('#fbcrmp3qr').click(function(){
								console.log($("#fbcrmp3").val());
									if($("#fbcrmp3").val() == ''){
									alert('{$n5app['lang']['fbcrmp3bt']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[audio]"+$("#fbcrmp3").val()+"[/audio]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsr"><input type="text" name="text" placeholder="{$n5app['lang']['fbcrspbt']}" id="fbcrsp" class="crsr_srys"></div>
							<div class="crgn_crqr"><a href="javascript:;" id="fbcrspqr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<div class="crgn_crts cl">{$n5app['lang']['fbcrspts']}</div>
						<script type="text/javascript">
							$('#fbcrspqr').click(function(){
								console.log($("#fbcrsp").val());
									if($("#fbcrsp").val() == ''){
									alert('{$n5app['lang']['fbcrspbt']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[media=x,500,380]"+$("#fbcrsp").val()+"[/media]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsr"><input type="text" name="text" placeholder="{$n5app['lang']['fbcrflsbt']}" id="fbcrfls" class="crsr_srys"></div>
							<div class="crgn_crqr"><a href="javascript:;" id="fbcrflsqr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<div class="crgn_crts cl">{$n5app['lang']['fbcrflsts']}</div>
						<script type="text/javascript">
							$('#fbcrflsqr').click(function(){
								console.log($("#fbcrfls").val());
									if($("#fbcrfls").val() == ''){
									alert('{$n5app['lang']['fbcrflsbt']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[flash]"+$("#fbcrfls").val()+"[/flash]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsrs"><textarea placeholder="{$n5app['lang']['fbcryybt']}" id="fbcryy" class="crsr_wbsr"></textarea></div>
							<div class="crgn_crqrs"><a href="javascript:;" id="fbcryyqr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<script type="text/javascript">
							$('#fbcryyqr').click(function(){
								console.log($("#fbcryy").val());
									if($("#fbcryy").val() == ''){
									alert('{$n5app['lang']['sqfbqingsrnr']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[quote]"+$("#fbcryy").val()+"[/quote]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsrs"><textarea placeholder="{$n5app['lang']['fbcrdmbt']}" id="fbcrdm" class="crsr_wbsr"></textarea></div>
							<div class="crgn_crqrs"><a href="javascript:;" id="fbcrdmqr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<script type="text/javascript">
							$('#fbcrdmqr').click(function(){
								console.log($("#fbcrdm").val());
									if($("#fbcrdm").val() == ''){
									alert('{$n5app['lang']['sqfbqingsrnr']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[code]"+$("#fbcrdm").val()+"[/code]");
								return false;
								}
							});
						</script>
					</div>
					<div class="n5fb_crxm cl">
						<div class="crxm_xmzt cl">
							<div class="crgn_crsrs"><textarea placeholder="{$n5app['lang']['fbcrmfbt']}" id="fbcrmf" class="crsr_wbsr"></textarea></div>
							<div class="crgn_crqrs"><a href="javascript:;" id="fbcrmfqr">{$n5app['lang']['fbszgncr']}</a></div>
						</div>
						<script type="text/javascript">
							$('#fbcrmfqr').click(function(){
								console.log($("#fbcrmf").val());
									if($("#fbcrmf").val() == ''){
									alert('{$n5app['lang']['sqfbqingsrnr']}');
								return false;
								}else{
									$("#needmessage").val($("#needmessage").val()+"[free]"+$("#fbcrmf").val()+"[/free]");
								return false;
								}
							});
						</script>
					</div>
				</div>
			</div>
			<script src="template/zhikai_n5app/js/n5fbcrgn.js"></script>
		</div>
		<!--{if $_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost}-->
			<!--{if ($_GET[action] == 'newthread' && $_G['group']['allowpostrushreply'] && $special != 2) || ($_GET[action] == 'edit' && getstatus($thread['status'], 3))}-->
				<div class="exfm tabs_item cl">
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['fbszqlzt']}</div>
						<div class="czxm_xmnr z"><input type="checkbox" name="rushreply" id="rushreply" value="1" {if $_GET[action] == 'edit' && getstatus($thread['status'], 3)}disabled="disabled" checked="checked"{/if} onclick="extraCheck(3)" /><label for="rushreply" id="rushreply" class="y"></label></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['sqfatieqlkssj']}</div>
						<div class="czxm_xmnr z"><input type="text" name="rushreplyfrom" id="rushreplyfrom" class="px" placeholder="{$n5app['lang']['sqfbqszsjs']}" onclick="showcalendar(event, this, true)" autocomplete="off" value="$postinfo[rush][starttimefrom]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['sqfatieqljssj']}</div>
						<div class="czxm_xmnr z"><input type="text" onclick="showcalendar(event, this, true)" autocomplete="off" id="rushreplyto" name="rushreplyto" class="px" placeholder="{$n5app['lang']['sqfbqszsjs']}" value="$postinfo[rush][starttimeto]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang rushreply_rewardfloor}</div>
						<div class="czxm_xmnr z"><input type="text" name="rewardfloor" id="rewardfloor" class="px" placeholder="{$n5app['lang']['sqfatieqllc']}" value="$postinfo[rush][rewardfloor]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>						
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang stopfloor}</div>
						<div class="czxm_xmnr z"><input type="text" name="replylimit" id="replylimit" class="px" placeholder="{lang replylimit}" autocomplete="off" value="$postinfo[rush][replylimit]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang rushreply_end}</div>
						<div class="czxm_xmnr z"><input type="text" name="stopfloor" id="stopfloor" class="px" placeholder="{$n5app['lang']['sqfatieqlsrlc']}" autocomplete="off" value="$postinfo[rush][stopfloor]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z"><!--{if $_G['setting']['creditstransextra'][11]}-->{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][11]][title]}<!--{else}-->{lang credits}<!--{/if}-->{lang min_limit}</div>
						<div class="czxm_xmnr z"><input type="text" name="creditlimit" id="creditlimit" class="px" placeholder="{$n5app['lang']['sqfatiexzqljf']}" autocomplete="off" value="$postinfo[rush][creditlimit]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
				</div>
			<!--{/if}-->
			<!--{if $_G['group']['maxprice'] && !$special}-->
				<div class="exfm tabs_item cl" >
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang price}</div>
						<div class="czxm_xmnr z"><input type="text" id="price" name="price" class="px" placeholder="{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} {lang post_price_comment}" value="$thread[pricedisplay]" onblur="extraCheck(2)" /></div>
					</div>
					<div class="gdcz_czts cl">
					<!--{if $_G['group']['maxprice'] && ($_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost)}-->
						<!--{if $_G['setting']['maxincperthread']}--><p>{lang post_price_income_comment}</p><!--{/if}-->
						<!--{if $_G['setting']['maxchargespan']}--><p>{lang post_price_charge_comment}<!--{if $_GET[action] == 'edit' && $freechargehours}-->{lang post_price_free_chargehours}<!--{/if}--></p><!--{/if}-->
					<!--{/if}-->
					</div>
				</div>
			<!--{/if}-->
			<!--{if $_G['group']['allowposttag']}-->
				<div class="exfm tabs_item cl" >
					<table cellspacing="0" cellpadding="0">
						<div class="gdcz_czxm cl">
							<div class="czxm_xmbt z">{lang post_tag}</div>
							<div class="czxm_xmnr z"><input type="text" class="px" placeholder="{$n5app['lang']['sqfatieszbq']}" size="60" id="tags" name="tags" value="$postinfo[tag]" onblur="extraCheck(4)" /></div>
						</div>
					</table>
				</div>
			<!--{/if}-->
		<!--{/if}-->
	</div>