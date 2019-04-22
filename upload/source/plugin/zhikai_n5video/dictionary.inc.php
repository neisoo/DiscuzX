<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

// 使用金山词霸进行单词翻译。
// 文档：http://open.iciba.com/index.php?c=wiki&t=cc
/*
查词接口
返回格式：XML/JSON 默认XML

传入参数：
w	:	单词/汉字
type : 返回格式 为空是xml 传入 xml 或者 json
key : 您申请到的key

例如：http://dict-co.iciba.com/api/dictionary.php?w=go&key=********

JSON 字段解释(英文)
{
'word_name':'' #单词
'exchange': '' #单词的各种时态
'symbols':'' #单词各种信息 下面字段都是这个字段下面的
'ph_en': '' #英式音标
'ph_am': '' #美式音标
'ph_en_mp3':'' #英式发音
'ph_am_mp3': '' #美式发音
'ph_tts_mp3': '' #TTS发音
'parts':'' #词的各种意思
}
JSON 字段解释(中文)
{
'word_name':'' #所查的词
'symbols':'' #词各种信息 下面字段都是这个字段下面的
'word_symbol': '' #拼音
'symbol_mp3': '' #发音
'parts':'' #汉字的各种翻译 数组
'net_means': '' #网络释义
}
*/

function saveAudio($url, $filename){
	$ret = true;
	
	// curl下载文件
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, 1);
	$mp3 = curl_exec($ch);
	if (curl_errno($ch)) {
		$ret = false;
	}

	curl_close($ch);

	// 保存文件到指定路径
	file_put_contents($filename , $mp3);
	unset($mp3);

	return $ret;
}

function getDict($word) {
	// 从金山词霸获取字典数据。
	$url = 'http://dict-co.iciba.com/api/dictionary.php?type=json&key=3BD88E7B9694069FE5CFD945A42C0528&w=' . $word;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$html = curl_exec($ch);
	curl_close($ch);
	return json_decode($html, true);
}

$word = $_GET['w'];
$info = getDict($word);

/*
$dir_url = './dict_download/';
if(!is_dir($dir_url)) {
	mkdir($dir_url, 0777);
}

$ph_en_filename = $dir_url . $word .'_en.mp3';
if (!file_exists($ph_en_filename)) {
	if (isset($info['symbols'][0]['ph_en_mp3'])) {
		if (saveAudio($info['symbols'][0]['ph_en_mp3'], $ph_en_filename)) {
		}
	}
}

$ph_am_filename = $dir_url . $word .'_am.mp3';
if (!file_exists($ph_am_filename)) {
	if (isset($info['symbols'][0]['ph_am_mp3'])) {
		if (saveAudio($info['symbols'][0]['ph_am_mp3'], $ph_am_filename)) {
		}
	}
}
*/

echo json_encode($info);

?>