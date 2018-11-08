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

function myImageResize($source_path, $target_path='', $target_width = 200, $target_height = 200, $fixed_orig = ''){
    $source_info = getimagesize($source_path);
    $source_width = $source_info[0];
    $source_height = $source_info[1];
    $source_mime = $source_info['mime'];
    $ratio_orig = $source_width / $source_height;
    if ($fixed_orig == 'width'){

        $target_height = $target_width / $ratio_orig;
    }elseif ($fixed_orig == 'height'){

        $target_width = $target_height * $ratio_orig;
    }else{

        if ($target_width / $target_height > $ratio_orig){
            $target_width = $target_height * $ratio_orig;
        }else{
            $target_height = $target_width / $ratio_orig;
        }
    }
    switch ($source_mime){
        case 'image/gif':
            $source_image = imagecreatefromgif($source_path);
            break;

        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($source_path);
            break;

        case 'image/png':
            $source_image = imagecreatefrompng($source_path);
            break;

        default:
            return false;
            break;
    }
    $target_image = imagecreatetruecolor($target_width, $target_height);
    imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $target_width, $target_height, $source_width, $source_height);
    //header('Content-type: image/jpeg');
    $imgArr = explode('.', $source_path);
    // $target_path = $imgArr[0] . '_new.' . $imgArr[1];
    imagejpeg($target_image, $target_path.$imgArr[1], 100);
}
//From:www_DASHULAI_COM
?>