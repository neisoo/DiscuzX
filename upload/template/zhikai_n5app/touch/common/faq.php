<?php exit;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="{if $_G['setting']['mobile'][mobilecachetime] > 0}{$_G['setting']['mobile'][mobilecachetime]}{else}no-cache{/if}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if},$_G['setting']['bbname']" />
<meta name="wap-font-scale" content="no">
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
<meta http-equiv="refresh" content="{$n5app['spad_sj']};url=forum.php?mod=guide&view=newthread&mobile=2" /> 
<title>{$n5app['lang']['appspggjz']}</title>
<link rel="stylesheet" href="template/zhikai_n5app/common/mbstyle.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="template/zhikai_n5app/common/style.css">
</head>
<body class="n5app_stbg">
	<style type="text/css">
		.n5app_ztys {width: 100%;height:80%;background:url({$n5app['spad_tpm']}) no-repeat 0 0;background-size: cover;display: block;}
	</style>
	<a href="{$n5app['spad_lj']}" class="n5app_ztys cl"></a>
	<div class="n5app_stjs cl"><a href="forum.php?mod=guide&view=newthread&mobile=2"><span id='numDiv'>{$n5app['spad_sj']}</span> {$n5app['lang']['appspggtg']}</a></div>
	<div class="n5app_dbxc cl">
		<img src="{$n5app['spad_logo']}">
		<p>{$n5app['spad_xcy']}</p>
	</div>
	<script type="text/javascript">
		var num={$n5app['spad_sj']};
		var interval=setInterval(function(){
		if(num==0){
		clearInterval(interval);
		}
		numDiv.innerHTML=num--;
		},1000);
	</script>
</body>
</html>