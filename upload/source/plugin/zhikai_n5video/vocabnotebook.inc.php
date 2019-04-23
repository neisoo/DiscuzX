<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

global $_G;
$op = $_REQUEST['op'];
$result = [];
$result['result'] = 0;

// 添加单词到现有的生词库
if ($op == 'add') {
	// 读取要添加的单词或单词数组。
	$words = explode(",", $_REQUEST['w']);
	$words = array_filter($words);

	// 读取已有的单词
	$profile = C::t('common_member_profile')->fetch($_G['uid']);
	$vocab = explode(",", $profile['field1']);

	// 逐个添加新的单词
	$data = [];
	for ($i=0, $len = count($words); $i < $len; $i++) {
		$word = $words[$i];
		if (!in_array($word, $vocab)) {
			array_unshift($vocab, $word);
		}
	}
	$data['field1'] = implode(',', $vocab);
	C::t('common_member_profile')->update($_G['uid'], $data);
}
// 替换生词库
else if ($op == 'update') {
	$words = explode(",", $_REQUEST['w']);
	$words = array_filter($words);

	$data['field1'] = implode(',', $words);
	C::t('common_member_profile')->update($_G['uid'], $data);
}
else {
	$result['result'] = -1;
}

echo json_encode($result);

?>