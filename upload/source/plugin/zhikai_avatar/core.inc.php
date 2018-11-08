<?php
/*
 * CopyRight  : [dashulai.Com!] (C)2014-2018
 * Document   : 大叔来：www.dashulai.Com，www.dashulai.Com
 * Created on : 2018-01-01,16:53:12
 * Author     : 大叔(QQ：986692927) wWw.dashulai.Com $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              大.叔.来出品 必属精品。
 *              大·叔·来源码论坛 全网首发 http://Www.dashulai.Com；
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$uid = $_G['uid'];
$profile['avatar'] = avatar($uid,'middle',true);
$profile['avatar_big'] = avatar($uid,'big',true);

if ($_GET["image_file"] && $_GET['m']=='avatar' && $_GET['formhash'] == FORMHASH) {
$imgdata = explode(',',$_GET["image_file"]);
preg_match('/^(data:\s*image\/(\w+);base64,)/',$_GET["image_file"],$result);
$sExt = '.'.str_replace('jpeg','jpg',$result[2]);
$imgdata = base64_decode($imgdata[1]);
$basedir = DISCUZ_ROOT.$_G['setting']['attachurl'];
$sTempFileName = $basedir.APP_ID.'/'.$uid;
@dmkdir($basedir.APP_ID);
file_put_contents($sTempFileName,$imgdata);

$dirs = sprintf("%09d",$uid);
$dir = array(
    substr($dirs,0,3),
    substr($dirs,3,2),
    substr($dirs,5,2),
    substr($dirs,7,2)
);
$avatar_dir = DISCUZ_ROOT.'uc_server/data/avatar/'.$dir[0].'/'.$dir[1].'/'.$dir[2].'/';
@dmkdir($avatar_dir);

myImageResize($sTempFileName,$avatar_dir.$dir[3].'_avatar_big'.$sExt, 200, 200);
myImageResize($sTempFileName,$avatar_dir.$dir[3].'_avatar_middle'.$sExt, 120, 120);
myImageResize($sTempFileName,$avatar_dir.$dir[3].'_avatar_small'.$sExt, 48, 48);

@unlink($sTempFileName);
echo json_encode(array('status'=>1));

}else{
    include template('zhikai_avatar:index');
}
//From:Www.dashulai.Com
?>