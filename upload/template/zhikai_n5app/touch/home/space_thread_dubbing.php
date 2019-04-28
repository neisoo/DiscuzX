<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_thread.php'}-->

<style type="text/css">
.ztfl_fllb {width: 100%;}
.ztfl_fllb ul li {width: 33.33%;padding: 0;}

/* 编辑切换开关 */
.zyh-edit-switch {
	background: url(./template/zhikai_n5app/images/tbys_bj.png) no-repeat;
	background-position: 0;
	background-size: 23px auto;
}
.zyh-in-edit .zyh-edit-switch {
	background: url(./template/zhikai_n5app/images/ksfb_qxan.png) no-repeat;
	background-position: 0;
	background-size: 23px auto;
}

/* 编辑状态下的复选框 */
.zyh-edit-checkbox {
	display: none;
}
.zyh-in-edit .zyh-edit-checkbox {
	display: block;
}

/* 底部删除按钮区域 */
.zyh-bottom-area {
	display: none;
}
.zyh-in-edit .zyh-bottom-area {
	display: block;
}

/* 未发布配音封面上的图标 */
.zyh-private-list-image-overlay:before {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 2rem;
	height: 2rem;
	margin-top: -1rem;
	margin-left: -1rem;
	font-size: 2rem;
	line-height: 2rem;
	font-family: FontAwesome;
	text-align: center;
	color: #fff;
}

/* 草稿配音封面上的文字 */
.zyh-draft-list-txt-overlay {
    font-size: 1rem;
    line-height: 1rem;
}

/* 标题文字 */
.zyh-dubbing-subject {
	display:block;
	text-overflow:ellipsis;
	white-space:nowrap;
	overflow:hidden;
	width:100%;
	height:2rem;
}

</style>

<div class="zyh-space-thread-dubbing-ui">
	<!-- 标题区域 -->
	<div class="n5qj_tbys nbg cl">
		<a href="forum.php?mod=guide&view=newthread&mobile=2" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
		<!--{if $list}--><a href="javascript:void(0)" class="zyh-edit-switch n5qj_ycan"></a><!--{/if}-->
		<span>{$n5app['lang']['wdgrdhwdpy']}</span>
	</div>
	<style type="text/css">
		.ztfl_fllb {width: 100%;} 
		.ztfl_fllb ul li {width: 33.33%;padding: 0;}
	</style>
	<!--  列表切换区域 -->
	<div class="zyh-switch-area n5sq_ztfl">
		<div class="ztfl_flzt">
			<div class="ztfl_fllb">
				<ul id="n5sq_glpd">
					<!--{eval $fid_dubbing = n5video_forum_userdubbing()}-->
					<!--{eval $publicCount = count(C::t('forum_thread')->fetch_all_by_authorid_displayorder($authorid, 0, '=', null, 'public', 0, 0, null, $fid_dubbing ))}-->
					<!--{eval $privateCount = count(C::t('forum_thread')->fetch_all_by_authorid_displayorder($authorid, 0, '=', null, 'private', 0, 0, null, $fid_dubbing_private ))}-->
					<!--{eval $draftCount = count(C::t('forum_thread')->fetch_all_by_authorid_displayorder($authorid, 0, '=', null, 'draft', 0, 0, null, $fid_dubbing_draft ))}-->
					<li <!--{if $_GET[dubbing] == '1'}-->class="a"<!--{/if}-->>
						<a href="home.php?mod=space&do=thread&view=me&type=thread&fid={$fid_dubbing}&filter=common&searchkey=public&dubbing=1">已发布({$publicCount})</a>
					</li>
					<li <!--{if $_GET[dubbing] == '2'}-->class="a"<!--{/if}-->>
						<a href="home.php?mod=space&do=thread&view=me&type=thread&fid={$fid_dubbing}&filter=common&searchkey=private&dubbing=2">未发布({$privateCount})</a>
					</li>
					<li <!--{if $_GET[dubbing] == '3'}-->class="a"<!--{/if}-->>
						<a href="home.php?mod=space&do=thread&view=me&type=thread&fid={$fid_dubbing}&filter=common&searchkey=draft&dubbing=3">草稿箱({$draftCount})</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- 列表滚动区域 -->
	<div class="zyh-scroll-area">
		<form method="post" autocomplete="off" name="delform" id="delform" action="forum.php?mod=collection&action=edit&op=delthread" onsubmit="return deleteDubbing();">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="delthread" value="true" />

		<!--{if $list}-->
			<div class="n5sq_ztlb cl">
			<!--{loop $list $stid $thread}-->
				<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->{eval continue;}<!--{/if}-->
					<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->{eval $displayorder_thread = 1;}<!--{/if}-->
					<!--{if $thread['moved']}--><!--{eval $thread[tid]=$thread[closed];}--><!--{/if}-->
					<!--{if !in_array($thread['displayorder'], array(1, 2, 3, 4))> 0 }-->
					
					<!--{eval $spacethread_fun1 = spacethread_fun1($thread);$thread['post'] = $spacethread_fun1['post'];$xlmm_tp = $spacethread_fun1['xlmm_tp'];}-->
					
					<!--{hook/forumdisplay_thread_mobile $key}-->
					<!--{hook/space_thread_dubbing_threadnlbsp_mobile $stid}-->
					<!--{/if}-->
			<!--{/loop}-->
			</div>
			
			<style type="text/css">
				.page {margin-top:20px;margin-bottom:10px;}
				.page a {float: none;display:inline;padding: 10px 30px;}
			</style>
			<!--{if $multi}-->
				<!--{eval $multi = simplepage(count($list), $perpage, $page, $theurl . '&dubbing=' . $_GET['dubbing']);}-->
				$multi
			<!--{/if}-->

			<!-- 底部的删除按钮 -->
			<div class="zyh-bottom-area uk-container-center uk-text-center uk-vertical-align n5qj_wbys cl n5qj_wbysx">
				<button type="submit" name="deletesubmit" value="true" fid="{$fid_dubbing}" class="zyh-delete-button uk-button uk-button-large uk-width-3-4 uk-vertical-align-middle uk-icon-remove"> 删除</button>
			</div>

		<!--{else}-->
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>没有相关的配音作品</p>
			</div>
		<!--{/if}-->
		</form>
	</div>

	<!-- 确认删除对话框询问。-->
	<div class="zyh-confirm-delete-dialog uk-modal">
		<div class="uk-modal-dialog">
			<div class="uk-modal-header">
				<h3 class="uk-text-success">删除配音？</h2>
			</div>
			<div class="uk-button-group uk-width-1-1">
				<button class="zyh-confirm-delete-dialog-cancel uk-button uk-button-large uk-width-1-2">取消</button>
				<button class="zyh-confirm-delete-dialog-ok uk-button uk-button-success uk-button-large uk-width-1-2">确定</button>
			</div>
		</div>
	</div>

</div>


<script type="text/javascript">
var jq = jQuery.noConflict();
var enableEdit = false;

var confirmDeleteDialog = UIkit.modal(".zyh-confirm-delete-dialog", {center:true, bgclose:false});

// 显示或隐藏对话框。
function toggleDialog(modal, force) {
	if (modal.isActive() ) {
		modal.hide(force);
	}
	else {
		modal.show();
	}
}

// 切换编辑开关
jq('.zyh-edit-switch').click(function(event){
	if (enableEdit) {
		jq('.zyh-space-thread-dubbing-ui').removeClass("zyh-in-edit");
	}
	else {
		jq('.zyh-space-thread-dubbing-ui').addClass("zyh-in-edit");
	}
	
	enableEdit = !enableEdit;
});

// 点击未发布配音列表项时，查看用户配音。
jq('.zyh-public-list-item').click(function(event) {
	jq(window).attr('location', 'forum.php?mod=viewthread&tid=' + jq(this).attr('tid') + '&mobile=2');
});

// 点击未发布配音列表项的非图片区域时，查看用户配音。
jq('.zyh-private-list-item').click(function(event) {
	jq(window).attr('location', 'forum.php?mod=viewthread&tid=' + jq(this).attr('tid') + '&mobile=2');
});

// 点击未发布配音列表项的图片区域时，转成已发布配音。
jq('.zyh-private-list-image-overlay').click(function(event) {
	var tid = jq(this).attr('tid');
	event.stopPropagation(); //停止事件冒泡
	// TODO.
});

// 点击草稿配音列表项时，编辑用户配音贴子。
jq('.zyh-draft-list-item').click(function(event) {
	jq(window).attr('location', 'forum.php?mod=post&action=edit&fid=' + jq(this).attr('fid') + '&tid=' + jq(this).attr('tid') + '&pid=' + jq(this).attr('pid') + '&mobile=2');
});

// 更新选择的数量。
jq("input[name='threadCheckbox']").change(function(e){
	var count = jq("input[name='threadCheckbox']:checked").size();
	if (count > 0) {
		jq('.zyh-delete-button').html(' 删除(' + count + ')');
	}
	else {
		jq('.zyh-delete-button').html(' 删除');
	}
});

function deleteDubbing() {
	//showDialog('{lang del_select_thread_confirm}', 'confirm', '', '$(\'delform\').submit();');
	toggleDialog(confirmDeleteDialog);
	return false;
}

jq('.zyh-confirm-delete-dialog-cancel').click(function(e) {
	toggleDialog(confirmDeleteDialog);
	return false;
});

jq('.zyh-confirm-delete-dialog-ok').click(function(e) {
	toggleDialog(confirmDeleteDialog);
	//jq('#delform').submit();
	deleteThread();
	return false;
});

function deleteThread() {
	var items = jq("input[name='threadCheckbox']:checked");
	var i;
	var tids = new Array();
	var formhash = jq("input[name='formhash']")[0].value;
	var fid = jq('.zyh-delete-button').attr('fid');

	if (items.size() > 0) {
		for (i = 0; i < items.size(); i++) {
			tids[i] = items[i].value;
		}

		$.ajax({
			type:'POST',
			url:'forum.php?mod=topicadmin&action=moderate&modsubmit=yes',
			data: {
				formhash: formhash,
				fid: fid,
				moderate: tids,
				operations: ['delete'],
				reason: 'user delete dubbing.',
			},
			dataType: 'json',
		})
		.success(function(s) {
			window.location.reload();
		})
		.error(function(data) {
			window.location.reload();
		});
	}
}
</script>

<!--{template common/footer}-->
