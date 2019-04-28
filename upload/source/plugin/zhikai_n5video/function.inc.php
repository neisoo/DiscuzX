<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

function zkv1()
{
    if (0) {
        $urls = '<div style="display:none"><script src="http://www.moqu8.com"></script></div>';
        return $urls;
    }
    
}

function youku_access_token()
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];
    include_once libfile('function/cache');
    $url = 'https://api.youku.com/oauth2/token.json';
    $youkulist = array('client_id' => $config['client_id'], 'grant_type' => 'refresh_token', 'refresh_token' => $config['refresh_token']);
    $setting = C::t('common_setting')->fetch_all(array(0 => 'youku_refresh'));
    $setting = (array) unserialize($setting['youku_refresh']);
    if ($setting['period'] && $setting['period'] > TIMESTAMP) {
        return true;
    }
    $resource = dfsockopen($url, 0, $youkulist);
    if ($resource !== NULL) {
        $arr = json_decode($resource, true);
        if ($arr['access_token'] && $arr['expires_in']) {
            $setting['access_token'] = $arr['access_token'];
            $setting['expires_in'] = $arr['expires_in'];
            $setting['refresh_token'] = $arr['refresh_token'];
            $setting['token_type'] = $arr['token_type'];
            $setting['period'] = TIMESTAMP + (intval($arr['expires_in'] / 86400) - 1) * 86400;
            C::t('common_setting')->update_batch(array('youku_refresh' => serialize(daddslashes(array_filter($setting)))));
            updatecache('setting');
        }
    }
    return true;
}

// 替换帖子内容[attach]标记以外的内容。
// is_match = fase 表示是preg_replace_callback的回调，在discuzcode()中使用。
function attach_replace($matches, $is_match = FALSE)
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];

    $video = explode('|', $config['video_bmp']);
    $voice = explode('|', $config['voice_bmp']);

    $jsonData = $is_match ? json_decode($matches, false) : json_decode($matches[2], false);
    if (!isset($jsonData->type) || $jsonData->type != 'video') {
        return $is_match ? '' : $matches[0];
    }

    // 获取id列表。
    $ids = array(
        $jsonData->data->video,
        $jsonData->data->poster,
        $jsonData->data->subtitle,
        $jsonData->data->tsubtitle,
        $jsonData->data->accompany);

    // 视频
    $video_url = null;
    if (!empty($ids[0])) {
        $aidtb = getattachtablebyaid($ids[0]);
        $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[0]));
        $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
        $video_url = $attachurl . $attach['attachment'];
    }

    // 封面
    $poster_url = null;
    if (!empty($ids[1])) {
        $aidtb = getattachtablebyaid($ids[1]);
        $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[1]));
        $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
        $poster_url = $attachurl . $attach['attachment'];
    }

    // 原文
    $subtitle_url = null;
    if (!empty($ids[2])) {
        $aidtb = getattachtablebyaid($ids[2]);
        $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[2]));
        $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
        $subtitle_url = $attachurl . $attach['attachment'];
    }

    // 译文
    $tsubtitle_url = null;
    if (!empty($ids[3])) {
        $aidtb = getattachtablebyaid($ids[3]);
        $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[3]));
        $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
        $tsubtitle_url = $attachurl . $attach['attachment'];
    }

    // 伴奏
    $accompany_url = null;
    if (!empty($ids[4])) {
        $aidtb = getattachtablebyaid($ids[4]);
        $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[4]));
        $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
        $accompany_url = $attachurl . $attach['attachment'];
    }

    // 删除回车换行符。
    $htmlPlayer = player($video_url, 'video', $ids[0], '', $poster_url, $subtitle_url, $tsubtitle_url);
    $htmlPlayer = str_replace(array("\r\n", "\r", "\n"), '', $htmlPlayer);
    return $htmlPlayer;
}

// 替换帖子内容[attach]标记以外的内容。
function noattach_replace($postlist, $isforumdisplay = FALSE)
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];
    $message = $postlist['message'];
    $attachmsg = array();
    $tid = $postlist['tid'];
    $pid = $postlist['pid'];
    $fid = $postlist['fid'];
    $video = explode('|', $config['video_bmp']);
    $voice = explode('|', $config['voice_bmp']);
    $post = DB::fetch_first('SELECT message FROM %t WHERE tid=%d and pid=%d and fid=%d ', array(0 => 'forum_post', 1 => $tid, 2 => $pid, 3 => $fid));
    preg_match_all('/\\[attach(.*?)\\](.*?)\\[\\/attach\\]/i', $post['message'], $mat);

    $jsonData = json_decode($mat[2][0], false);
    if (!isset($jsonData->type) || $jsonData->type != 'video') {
        $mat = array();
    }
    else {
        $mat = array(
            $jsonData->data->video,
            $jsonData->data->poster,
            $jsonData->data->subtitle,
            $jsonData->data->tsubtitle,
            $jsonData->data->accompany);
    }

    $aidtb = getattachtablebytid($tid);
    if ($aidtb == 'forum_attachment_unused') {
        return $postlist;
    }
    $attachlist = DB::fetch_all('SELECT aid,readperm,price,attachment,filename,remote,dateline,filesize FROM %t WHERE tid=%d and pid=%d', array(0 => $aidtb, 1 => $tid, 2 => $pid));
    $aids = array();
    foreach ($attachlist as $v) {
        $aids[] = $v['aid'];
    }
    $aidsstr = implode(',', $aids);
    unset($aids);
    $aidlist = DB::fetch_all('SELECT faid,furl FROM %t WHERE faid IN (%n)', array(0 => 'zhikai_vdocover', 1 => $aidsstr));
    $furlarr = array();
    foreach ($aidlist as $key => $val) {
        $furlarr[$val['faid']] = $val['furl'];
    }
    unset($aidlist);
    require_once libfile('function/attachment');
    foreach ($attachlist as $k => $attach) {
        $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
        $attachext = strtolower(fileext($attach['filename']));
        if (!in_array($attach['aid'], $mat)) {
            $attachicon = attachtype($attachext . "\t");
            $attachdate = dgmdate($attach['dateline'], 'u');
            $attachsize = sizecount($attach['filesize']);
            $readperm = $attach['readperm'] ? lang('plugin/zhikai_n5video', 'lang_vdo002') . ' <strong>' . $attach['readperm'] . '</strong>' : '';
            $price = $attach['price'] ? lang('plugin/zhikai_n5video', 'lang_vdo003') . '<strong>' . $attach['price'] . '&nbsp;' . $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['unit'] . $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title'] . '</strong>' : '';
            if (!$config['media_analysis'] && ($attach['readperm'] || $attach['price'])) {
                if (checkmobile() && CURMODULE == 'viewthread') {
                    $message .= '<div style="margin:10px 0px;"><dd><p class="attnm"> ' . $attachicon . '<a href="javascript:;" id="">' . $attach['filename'] . '</a></p><p class="xglc">(' . $attachdate . lang('plugin/zhikai_n5video', 'lang_vdo004') . ')&nbsp;' . $attachsize . '&nbsp;' . $readperm . ',&nbsp; ' . $price . '&nbsp;&nbsp;' . lang('plugin/zhikai_n5video', 'lang_vdo005') . '</p></dd></div>';
                } else {
                    if (CURMODULE == 'viewthread') {
                        return $postlist;
                    }
                }
            } elseif (in_array($attachext, $voice)) {
                if ($isforumdisplay) {
                    $attachmsg[] = player($attachurl . $attach['attachment'], 'voice', $attach['aid'], $attach['filename']);
                } else {
                    $message .= player($attachurl . $attach['attachment'], 'voice', $attach['aid'], $attach['filename']);
                }
            } elseif (in_array($attachext, $video)) {
                $furl = $furlarr[$attach['aid']] ? $furlarr[$attach['aid']] : $config['cover_init'];
                if ($isforumdisplay) {
                    $attachmsg[] = player($attachurl . $attach['attachment'], 'video', $attach['aid'], '', $furl);
                } else {
                    $message .= player($attachurl . $attach['attachment'], 'video', $attach['aid'], '', $furl);
                }
            } else {
                if ($attach['readperm'] || $attach['price']) {
                    if (checkmobile() && CURMODULE == 'viewthread') {
                        $message .= '<div style="margin:10px 0px;"><dd><p class="attnm"> ' . $attachicon . '<a href="javascript:;" id="">' . $attach['filename'] . '</a></p><p class="xglc">(' . $attachdate . lang('plugin/zhikai_n5video', 'lang_vdo004') . ')&nbsp;' . $attachsize . '&nbsp;' . $readperm . ',&nbsp; ' . $price . '&nbsp;&nbsp;' . lang('plugin/zhikai_n5video', 'lang_vdo005') . '</p></dd></div>';
                    }
                }
            }
        }
    }
    if ($isforumdisplay) {
        return $attachmsg;
    }
    $postlist['message'] = $message;
    return $postlist;
}
function audio_replace($matches, $is_match = FALSE)
{
    $url = $is_match ? $matches : $matches[2];
    if (empty($url)) {
        return null;
    }
    $key = random(5);
    $arr = explode('/', $url);
    if (strexists($arr[count($arr) - 1], '.mp3')) {
        return player($url, 'voice', $key, $arr[count($arr) - 1]);
    }
    if (strexists($url, 'music.163.com')) {
        return player($url, 'iframeaudio');
    }
}
function concentrate_replace($matches, $is_match = FALSE)
{
    $key = random(5);
    $url = $is_match ? $matches : $matches[2];
    if (empty($url)) {
        return null;
    }
    $arr = explode('/', $url);
    if (strexists($url, 'youku.com') !== false) {
        if (strexists($arr[count($arr) - 1], '==.html')) {
            $player = $arr[0] . '//player.youku.com/embed/' . str_replace(array(0 => 'id_', 1 => '.html'), array(0 => '', 1 => ''), $arr[count($arr) - 1]);
        } elseif (strexists($arr[count($arr) - 1], 'v.swf')) {
            $player = $arr[0] . '//player.youku.com/embed/' . $arr[count($arr) - 2];
        } elseif (strexists($url, 'player.youku.com')) {
            $player = $url;
        }
        if ($player) {
            return player($player, 'iframevideo');
        }
    } elseif (strexists($url, 'qq.com') !== false) {
        if (strexists($arr[count($arr) - 1], 'player.html?vid=')) {
            $vid = stristr(str_replace('player.html?vid=', '', $arr[count($arr) - 1]), '&', true);
            $player = $arr[0] . '//v.qq.com/iframe/player.html?vid=' . $vid . '&auto=0';
        } elseif (strexists($arr[count($arr) - 1], '.swf?')) {
            $vid = str_replace('vid=', '', stristr(stristr($arr[count($arr) - 1], 'vid='), '&', true));
            $player = $arr[0] . '//v.qq.com/iframe/player.html?vid=' . $vid . '&auto=0';
        } elseif (strexists($arr[count($arr) - 1], '.html')) {
            $vid = str_replace('.html', '', $arr[count($arr) - 1]);
            $player = $arr[0] . '//v.qq.com/iframe/player.html?vid=' . $vid . '&auto=0';
        }
        if ($player) {
            return player($player, 'iframevideo');
        }
    } else {
        if (!strexists($url, 'share.vrs.sohu.com') === false) {
        } elseif (!strexists($url, 'tv.sohu.com') === false) {
            return player($url, 'iframevideo');
        }
        if (strexists($url, 'v.ifeng.com') !== false) {
            include_once libfile('function/cache');
            $dir = DISCUZ_ROOT . '/source/plugin/zhikai_n5video/cache/';
            if (strexists($arr[count($arr) - 1], '.shtml') !== false) {
                $videofile = str_replace('.shtml', '', $arr[count($arr) - 1]);
                $dir_video = $dir . $videofile . '.php';
                if (file_exists($dir_video)) {
                    include $dir_video;
                    error_reporting(0);
                    $videoUrl = $video_list['videoUrl'];
                    $videoImg = $video_list['videoImg'];
                } elseif (strexists($arr[count($arr) - 1], 'video_') !== false) {
                    $resource = dfsockopen($url);
                    if (preg_match('#"vid": "(.*?)"#i', $resource, $matchs)) {
                        $videolist = dfsockopen('http://dyn.v.ifeng.com/cmpp/wideo_msg_news.js?guid=' . $matchs[1]);
                        $videolist = explode(',', $videolist);
                        if (strexists($videolist[8], '.mp4') !== false) {
                            $videoarr = explode('"', $videolist[8]);
                            $videoimgarr = explode('"', $videolist[1]);
                            $videoUrl = $videoarr[1] == 'videoPlayUrl' ? $videoarr[3] : '';
                            $videoImg = $videoimgarr[1] == 'posterUrl' ? $videoimgarr[3] : '';
                        }
                        if ($videoUrl) {
                            writecache($dir, $videofile, getcachevars(array('video_list' => array('videoUrl' => $videoUrl, 'videoImg' => $videoImg))));
                        }
                    }
                } else {
                    $vid = str_replace('.shtml', '', $arr[count($arr) - 1]);
                    $videolist = dfsockopen('http://dyn.v.ifeng.com/cmpp/wideo_msg_news.js?guid=' . $vid);
                    $videolist = explode(',', $videolist);
                    if (strexists($videolist[8], '.mp4') !== false) {
                        $videoarr = explode('"', $videolist[8]);
                        $videoimgarr = explode('"', $videolist[1]);
                        $videoUrl = $videoarr[1] == 'videoPlayUrl' ? $videoarr[3] : '';
                        $videoImg = $videoimgarr[1] == 'posterUrl' ? $videoimgarr[3] : '';
                        if ($videoUrl) {
                            writecache($dir, $videofile, getcachevars(array('video_list' => array('videoUrl' => $videoUrl, 'videoImg' => $videoImg))));
                        }
                    }
                }
            } elseif (strexists($url, '.swf') !== false) {
                $vid = str_replace('.swf?guid=', '', stristr(stristr($url, '.swf?guid='), '&', true));
                $dir_video = $dir . $vid . '.php';
                if (file_exists($dir_video)) {
                    include $dir_video;
                    error_reporting(0);
                    $videoUrl = $video_list['videoUrl'];
                    $videoImg = $video_list['videoImg'];
                } else {
                    $videolist = dfsockopen('http://dyn.v.ifeng.com/cmpp/wideo_msg_news.js?guid=' . $vid);
                    $videolist = explode(',', $videolist);
                    if (strexists($videolist[8], '.mp4') !== false) {
                        $videoarr = explode('"', $videolist[8]);
                        $videoimgarr = explode('"', $videolist[1]);
                        $videoUrl = $videoarr[1] == 'videoPlayUrl' ? $videoarr[3] : '';
                        $videoImg = $videoimgarr[1] == 'posterUrl' ? $videoimgarr[3] : '';
                        if ($videoUrl) {
                            writecache($dir, $vid, getcachevars(array('video_list' => array('videoUrl' => $videoUrl, 'videoImg' => $videoImg))));
                        }
                    }
                }
            }
            if ($videoUrl) {
                return player($videoUrl, 'video', random(5), '', $videoImg);
            }
        } elseif (strexists($url, 'player.video.qiyi.com') !== false) {
            if (preg_match('/http:\\/\\/player.video.qiyi.com\\/([^\\/]+).*?tvId=([^-]+).*?/i', $url, $matchesp)) {
                $player = $arr[0] . '//open.iqiyi.com/developer/player_js/coopPlayerIndex.html?vid=' . $matchesp[1] . '&tvId=' . $matchesp[2] . '';
                return player($player, 'iframevideo');
            }
        } elseif (strexists($arr[count($arr) - 1], '.mp3')) {
            return player($url, 'voice', $key, $arr[count($arr) - 1]);
        }
    }
    if (strexists($arr[count($arr) - 1], '.mp4')) {
        return player($url, 'video', $key);
    }
}
function writecache($dir, $script, $cachedata)
{
    global $_G;
    if (!is_dir($dir)) {
        dmkdir($dir, 511);
    }
    error_reporting(0);
    if ($fp = fopen($dir . $script . '.php', 'wb')) {
        fwrite($fp, "<?php\n//Discuz! cache file, DO NOT modify me!\n//Identify: " . md5($script . '.php' . $cachedata . $_G['config']['security']['authkey']) . "\n\n" . $cachedata . '?>');
        fclose($fp);
    }
}
function youku_replace($matches, $is_match = FALSE)
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];
    $url = $is_match ? $matches : $matches[2];
    $arr = explode('/', $url);
    if (!strexists($url, 'player.youku.com') === false && $arr[5]) {
        return '<div class="zhikai-player cl"><div id="' . $arr[5] . '" class="video"></div><script type="text/javascript">var player=new YKU.Player("' . $arr[5] . '",{styleid:"0",client_id:"' . $config['client_id'] . '",vid:"' . $arr[5] . '",newPlayer:true,autoplay:false,show_related:false});</script></div>';
    }
}
function player($playurl, $type, $id = null, $title = null, $furl = null, $surl = null, $turl = null)
{
    if ($type == 'voice') {
        include template('zhikai_n5video:audio');
        return $audio;
    }
    if ($type == 'video') {
        include template('zhikai_n5video:player');
        return $player;
    }
    if ($type == 'iframeaudio') {
        $player = '<div class="zhikai-player cl"><iframe class="iframe" src="' . $playurl . '" frameborder=0 allowfullscreen scrolling="no" ></iframe></div>';
    } elseif ($type == 'iframevideo') {
        $player = '<div class="zhikai-player cl"><iframe class="iframevideo" src="' . $playurl . '" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0"></iframe></div>';
    }
    return $player;
}
function sortbytids($result, $tids)
{
    $resultlist = array();
    foreach ($tids as $v) {
        foreach ($result as $val) {
            if ($v == $val['tid']) {
                $resultlist[$v] = array('message' => $val['message'], 'tid' => $val['tid'], 'pid' => $val['pid'], 'fid' => $val['fid']);
            }
        }
    }
    return $resultlist;
}

// 帖子列表显示时的内容替换
function forumdisplay_replace($message, $tid = null, $pid = null, $fid = null)
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];
    $player = '';
    $playerarr = array();
    if (strexists($message, '[/media]') !== false) {
        if (preg_match_all("/\\[media(.*?)\\]\\s*([^\\[\\<\r\n]+?)\\s*\\[\\/media\\]/is", $message, $match)) {
            foreach ($match[2] as $val) {
                $playerarr[] = concentrate_replace($val, true);
            }
        }
    }
    if (strexists($message, '[/zhikai_youku]') !== false) {
        if (preg_match_all("/\\[zhikai_youku(.*?)\\]\\s*([^\\[\\<\r\n]+?)\\s*\\[\\/zhikai_youku\\]/is", $message, $match)) {
            foreach ($match[2] as $val) {
                $playerarr[] = youku_replace($val, true);
            }
        }
    }

    if (strexists($message, '[/attach]') !== false) {
        if (preg_match_all('/\\[attach\\](.*?)\\[\\/attach\\]/is', $message, $matc)) {
            array_unique($matc[1]);
            foreach (array_unique($matc[1]) as $val) {
                if (!empty($val)) {
                    $playerarr[] = attach_replace($val, true);
                }
            }
        }
    } else {
        $arr = array();
        $arr[] = array('message' => $message, 'tid' => $tid, 'pid' => $pid, 'fid' => $fid);
        foreach ($arr as $val) {
            if (!empty($val['pid'])) {
                $list = noattach_replace($val, true);
            }
        }
    }
    foreach ($list as $v) {
        $playerarr[] = $v;
    }
    if (strexists($message, '[/audio]') !== false) {
        if (preg_match_all("/\\[audio(=1)*\\]\\s*([^\\[\\<\r\n]+?)\\s*\\[\\/audio\\]/is", $message, $mat)) {
            foreach ($mat[2] as $val) {
                $playerarr[] = audio_replace($val, true);
            }
        }
    }
    foreach ($playerarr as $k => $v) {
        $player .= $v;
    }
    return $player;
}

// 获取主题贴的视频和字幕信息。
function dubbing_replace($tid)
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];

    $video = explode('|', $config['video_bmp']);
    $voice = explode('|', $config['voice_bmp']);
    
    $post = DB::fetch_first('SELECT message, subject FROM %t WHERE tid=%d ', array(0 => 'forum_post', 1 => $tid));
    $message = $post['message'];
    $subject = $post['subject'];
    if (strexists($message, '[/attach]') !== false) {
        if (preg_match_all('/\\[attach\\](.*?)\\[\\/attach\\]/is', $message, $mat)) {
            $jsonData = json_decode($mat[1][0], false);
            if (!isset($jsonData->type) || $jsonData->type != 'video') {
                return null;
            }

            // 获取id列表。
            $ids = array(
                $jsonData->data->video,
                $jsonData->data->poster,
                $jsonData->data->subtitle,
                $jsonData->data->tsubtitle,
                $jsonData->data->accompany);

            // 视频
            $video_url = null;
            if (!empty($ids[0])) {
                $aidtb = getattachtablebyaid($ids[0]);
                $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[0]));
                $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                $video_url = $attachurl . $attach['attachment'];
            }

            // 封面
            $poster_url = null;
            if (!empty($ids[1])) {
                $aidtb = getattachtablebyaid($ids[1]);
                $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[1]));
                $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                $poster_url = $attachurl . $attach['attachment'];
            }

            // 原文
            $subtitle_url = null;
            if (!empty($ids[2])) {
                $aidtb = getattachtablebyaid($ids[2]);
                $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[2]));
                $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                $subtitle_url = $attachurl . $attach['attachment'];
            }

            // 译文
            $tsubtitle_url = null;
            if (!empty($ids[3])) {
                $aidtb = getattachtablebyaid($ids[3]);
                $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[3]));
                $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                $tsubtitle_url = $attachurl . $attach['attachment'];
            }

            // 伴奏
            $accompany_url = null;
            if (!empty($ids[4])) {
                $aidtb = getattachtablebyaid($ids[4]);
                $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $ids[4]));
                $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                $accompany_url = $attachurl . $attach['attachment'];
            }

            $attachInfo['video'] = $video_url;
            $attachInfo['cover'] = $poster_url;
            $attachInfo['subtitle'] = $subtitle_url;
            $attachInfo['tsubtitle'] = $tsubtitle_url;
            $attachInfo['accompany'] = $accompany_url;
            $attachInfo['subject'] = $subject; // 标题
            $attachInfo['tid'] = $tid; // 配音视频贴的tid

            $attachInfo['description'] = '';
            if (!empty($jsonData->data->description)) {
                $attachInfo['description'] = $jsonData->data->description; // 配音视频的说明文字
            }

            $attachInfo['rate'] = 3;
            if (!empty($jsonData->data->rate)) {
                $attachInfo['rate'] = $jsonData->data->rate; // 配音视频的难度星级
            }

            return $attachInfo;
        }
    }

    return null;
}

// 根据用户配音贴tid，返回对应配音资源贴的数据
function dubbing_user_replace($tid)
{
    global $_G;
    if (empty($_G['cache']['plugin'])) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['zhikai_n5video'];
    $post = DB::fetch_first('SELECT message, subject, fid, pid FROM %t WHERE tid=%d ', array(0 => 'forum_post', 1 => $tid));
    $message = $post['message'];
    $subject = $post['subject'];
    $fid = $post['fid'];
    $pid = $post['pid'];

    if (strexists($message, '[/dubbing]') !== false) {
        if (preg_match_all('/\\[dubbing\\](.*?)\\[\\/dubbing\\]/is', $message, $mat)) {
            $jsonData = json_decode($mat[1][0], false);
            if (!isset($jsonData->type) || $jsonData->type != 'dubbing') {
                return null;
            }

            if (isset($jsonData->data->tid)) {
                $attachInfo = dubbing_replace($jsonData->data->tid);

                // 用户完整的配音音频
                if (isset($jsonData->data->dubbing)) {
                    $id = $jsonData->data->dubbing;
                    $aidtb = getattachtablebyaid($id);
                    $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $id));
                    $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                    $audio_url = $attachurl . $attach['attachment'];
                    $attachInfo['userdubbing'] = $audio_url;
                }

                // 用户还未完成配音，计算完成度。
                if (isset($jsonData->data->record)) {
                    $total = count($jsonData->data->record);
                    if ($total >= 1) {
                        $count = 0;
                        for ($i = 0; $i < $total; $i++) {
                            $id = $jsonData->data->record[$i];
                            if (!empty($id)) {
                                // 获取已经完成录音的声音文件的url。
                                $aidtb = getattachtablebyaid($id);
                                $attach = DB::fetch_first('SELECT attachment, remote FROM %t WHERE aid=%d', array(0 => $aidtb, 1 => $id));
                                $attachurl = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
                                $audio_url = $attachurl . $attach['attachment'];
                                $attachInfo['srecord'][$i]['attachid'] = $id;
                                $attachInfo['srecord'][$i]['url'] = $audio_url;
                                $count++;
                            }
                        }
                        $attachInfo['progress'] = intval($count * 100 / $total);
                    }

                }

                // 加上s前缀，表示是用户配音贴的id，而非配音资源贴的id。
                $attachInfo['sfid'] = $fid;
                $attachInfo['stid'] = $tid;
                $attachInfo['spid'] = $pid;

                return $attachInfo;
            }
        }
    }
    return null;
}