<?php

/*
 * CopyRight  : [DASHULAI.COM!] (C)2014-2018
 * Document   : 大叔来：www.DASHULAI.COM，www.DASHULAI.COM
 * Created on : 2018-04-16,10:01:59
 * Author     : 大叔来(QQ：986692927) wWw.DASHULAI.COM $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              大.叔.来出品 必属精品。
 *              大·叔·来 全网首发 https://Www.DASHULAI.COM；
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

/* 插件代码开始 */

class mobileplugin_zhikai_creditshow {
	function global_footer_mobile(){
		global $_G;
		if(!$_G['uid']) return '';
		$pvars = $_G['cache']['plugin']['zhikai_creditshow'];
		$opacity = dintval($pvars['transparent'])/100;
		include template("zhikai_creditshow:show");
		return $return;
	}
}
//From:www_DASHULAI_co
?>