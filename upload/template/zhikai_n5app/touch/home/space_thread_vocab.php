<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_thread.php'}-->

<style type="text/css">
.uk-form textarea {
	font-size: 1.5rem;
}
</style>

<div class="zyh-space-thread-dubbing-ui">
	<!-- 标题区域 -->
	<div class="n5qj_tbys nbg cl">
		<a href="forum.php?mod=guide&view=newthread&mobile=2" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
		<span>生词本</span>
	</div>
	<!-- 列表滚动区域 -->
	<div class="zyh-scroll-area">
		<form class="uk-form uk-form-stacked">
			<fieldset data-uk-margin>
				<div class="uk-form-row">
					<div class="uk-form-controls">
						<textarea class="vocab-textarea uk-width-1-1" rows="100" placeholder="输入单词，单词之间用逗号分隔。"></textarea>
					</div>
				</div>
				<!-- 底部的保存按钮 -->
				<div class="zyh-bottom-area uk-container-center uk-text-center uk-vertical-align n5qj_wbys cl n5qj_wbysx">
					<button class="zyh-save-vocab-button uk-button uk-button-large uk-width-3-4 uk-vertical-align-middle">保存</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<script type="text/javascript">
var jq = jQuery.noConflict();

<!--{eval $profile = C::t('common_member_profile')->fetch($_G['uid']);}-->
jq('.vocab-textarea').val('{$profile['field1']}');
jq('.zyh-save-vocab-button').click(function(e) {
	word = jq('.vocab-textarea').val();

	jq.ajax({
		type: "POST",
		url: "plugin.php?id=zhikai_n5video:vocabnotebook",
		data: {
			op: 'update',
			w: word
		}, 
		cache: false,
		success: function(){
			alert("保存成功。")
		},
		error: function() {
			alert("保存失败。")
		}
	});
	return false;
});

</script>

<!--{template common/footer}-->
