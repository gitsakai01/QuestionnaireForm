<?php

$strAddress = "";
if(!empty($_POST["pref"])) $strAddress = $_POST["pref"];
if(!empty($_POST["adr1"])) $strAddress .= $_POST["adr1"];
if(!empty($_POST["adr2"])) $strAddress .= $_POST["adr2"];

$query   = urlencode("郵便番号 " . $strAddress);

// 郵便番号が含まれる文字列を切り出す
$str   = file_get_contents("http://www.google.co.jp/search?q={$query}");
$start = stripos($str, 'www.post.japanpost.jp');
$str   = substr($str, $start, 200);

// 文字列から正規表現で郵便番号を取り出す
$matches = array();
if (preg_match('/\d{3}\-\d{4}/', $str, $matches)) {
	print str_replace("-", "", $matches[0]);
}
?>