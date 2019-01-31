<?php exit;?>
<link href="template/zhikai_n5app/fenlei/mbfllb.css" type="text/css" rel="stylesheet">
<link href="template/zhikai_n5app/common/forumdisplays.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="template/zhikai_n5app/js/nav.js"></script>

<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function lbztsx(){
		jq(".n5sq_ztsx").addClass("am-modal-active");
		if(jq(".sharebg").length>0){
			jq(".sharebg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="sharebg"></div>');
			jq(".sharebg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.nrfx_qxan").click(function(){
			jq(".n5sq_ztsx").removeClass("am-modal-active");
			setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");
				jq(".sharebg").remove();
			},300);
		})
	}	
</script>
<div class="n5qj_tbys nbg cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<span class="n5qj_lbxx"><a onClick="lbztsx()">$_G['forum'][name]</a></span>
</div>

<!--主题贴筛选-->
<div class="n5sq_ztsx cl">
	<div class="ztsx_sxbt cl">{$n5app['lang']['ztlbgjsx']}<span class="nrfx_qxan y cl"></span></div>
	<div class="ztsx_sxnr cl">
		<!--主题贴排序-->
		<ul class="sxnr_jgul cl">
			<li><a class="sxngwbg">{lang orderby}:</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline&typeid={$_GET['typeid']}" {if $_GET['orderby'] == 'dateline'}class="xw1"{/if}>最新</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats" {if $_GET['orderby'] == 'heats'}class="xw1"{/if}>最热</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=views&typeid={$_GET['typeid']}" {if $_GET['orderby'] == 'views'}class="xw1"{/if}>最多预览</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=replies&typeid={$_GET['typeid']}" {if $_GET['orderby'] == 'replies'}class="xw1"{/if}>最多配音</a></li>
		</ul>

		<!--主题贴类别筛选-->
	<!--{if $_G['forum']['threadtypes'] || count($_G['forum']['threadsorts']['types']) > 0}-->
		<ul class="sxnr_jgul cl">
			<li><a class="sxngwbg">难度:</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{$forumdisplayadd[orderby]}"{if !$_GET['typeid']}class="xw1"{/if}>{lang forum_viewall}</a></li>
			<!--{if $_G['forum']['threadtypes']}-->
				<!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
					<!--{if $_GET['typeid'] == $id}-->
					<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid={$id}{$forumdisplayadd[typeid]}"class="xw1" >{$name}</a></li>
					<!--{else}-->
					<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid={$id}{$forumdisplayadd[typeid]}">{$name}</a></li>
					<!--{/if}-->
				<!--{/loop}-->
			<!--{/if}-->
		</ul>
	<!--{/if}-->

	</div>
</div>

<!--{hook/forumdisplay_top_mobile}-->

<!--{if $_G['forum']['threadsorts']}-->
<div class="n5sq_flsxt">
	<div class="n5sq_flsx cl">
		<!--{subtemplate forum/search_sortoption}-->
	</div>
</div>
<!--{/if}-->

<!--使用瀑布图片列表显示主题贴-->
<!--{if $_G['forum_threadcount']}-->
<div class="n5sq_pbbk cl">
	<div class="pbbk_pbzt">
	<!--{loop $_G['forum_threadlist'] $key $thread}-->
		<div class="pbbk_pbsj" style="visibility:hidden;">
			<a class="uk-thumbnail" href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">
			<!--{if $thread['cover']}-->
				<img nodata-echo="yes" src="$thread[coverpath]" alt="$thread[subject]" />
			<!--{else}-->
				<img src="template/zhikai_n5app/images/pbbk_pbsj.jpg" />
			<!--{/if}-->
				<div class="uk-thumbnail-caption">$thread[subject]</div>
			</a>
		</div>
	<!--{/loop}-->
	</div>
</div>


<script src="template/zhikai_n5app/js/jaliswall.js" type="text/javascript"></script>
<script type="text/javascript">
	var jq = jQuery.noConflict(); 
		jq(function(){
		jq('.pbbk_pbzt').jaliswall({ item: '.pbbk_pbsj' });
	});
	
	jq('[data-uk-pagination]').on('select.uk.pagination', function(e, pageIndex){
		alert('You have selected page: ' + (pageIndex+1));
	});

</script>

<!--分页-->
$multipage

<!--{else}-->

<!--没有主题贴-->
<div class="n5qj_wnr">
	<img src="template/zhikai_n5app/images/n5sq_gzts.png">
	<p>没有配音</p>
</div>

<!--{/if}-->

<!--{hook/forumdisplay_bottom_mobile}-->
<div class="pullrefresh" style="display:none;"></div>

<!--{template common/footer}-->
