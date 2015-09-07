<?php

	try {

		session_start();		//SESSION開始

		// 共通関数
		require_once("cls/common.php");

		// 画面表示
		ScreenDraw();

	} catch (Exception $e) {
		echo $e;
		exit;
	}
/**
 * [入力画面表示]
 */
function ScreenDraw(){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>アンケート</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/confirm.js"></script>
</head>
<body>
	<div id="container">
		<div class="question_area">
			<p class="header">アンケート</p>

			<p class="question">貴方の年齢は？</p>
			<ul class="answer">
				<li><?php print h(constant("ANS1_".$_SESSION["ans1"])) ?></li>
			</ul>

			<p class="question">好きな犬種は？</p>
			<p class="extention">※複数選択可能</p>
			<ul class="answer">

<?php
			foreach($_SESSION["ans2"] AS $key => $value){
?>
				<li><?php print h(constant("ANS2_".$value));if($value == "19") print "(" . $_SESSION["ans2_text"] . ")"; ?></li>
<?php
			}
?>
			</ul>		
			<p class="question">当サイトをどこでお知りになりましたか？</p>
			<ul class="answer">
				<li><?php print h(constant("ANS3_".$_SESSION["ans3"])); if($value == "10") print "(" . $_SESSION["ans3_text"] . ")"; ?></li>
			</ul>

			<p class="question">健康で気になる所</p>
			<p class="extention">※複数選択可能</p>
			<ul class="answer">
<?php
			foreach($_SESSION["ans4"] AS $key => $value){
?>
				<li><?php print h(constant("ANS4_".$value));if($value == "11") print "(" . $_SESSION["ans4_text"] . ")"; ?></li>
<?php						
			}
?>
			</ul>
		</div>
		<div class="customer_area">
			<p class="customer">お客様情報</p>
			<dl class="underline">
				<dt>お名前</dt>
				<dd><?php print h($_SESSION["name_sei"]) ?>&nbsp;<?php print h($_SESSION["name_mei"]) ?></dd>
			</dl>
			<dl class="underline">
				<dt>ふりがな</dt>
				<dd><?php print h($_SESSION["furi_sei"]) ?>&nbsp;<?php print h($_SESSION["furi_mei"]) ?></dd>
			</dl>
			<dl class="underline">
				<dt>郵便番号</dt>
				<dd>〒<?php print h($_SESSION["zip1"]) ?>-<?php print h($_SESSION["zip2"]) ?></dd>
			</dl>
			<dl class="underline">
				<dt>住所</dt>
				<dd><?php print h($_SESSION["pref"]) ?>&nbsp;<?php print h($_SESSION["address1"]) ?>&nbsp;<?php print h($_SESSION["address2"]) ?></dd>
			</dl>
			<dl class="underline">
				<dt>電話番号</dt>
				<dd><?php print h($_SESSION["tel"]) ?></dd>
			</dl>
			<dl class="underline">
				<dt>生年月日</dt>
				<dd><?php print h($_SESSION["birth_y"] . "/" . $_SESSION["birth_m"] . "/" . $_SESSION["birth_d"]) ?></dd>
			</dl>
			<dl class="underline">
				<dt>性別</dt>
				<dd><?php ($_SESSION["sex"] == "2" ? print "女" : print "男") ?></dd>
			</dl>
			<dl class="underline">
				<dt>メールアドレス</dt>
				<dd><?php print h($_SESSION["mail1"]) ?></dd>
			</dl>
			<p class="btnArea">
				<a href="index.php"><input type="button" name="btnInput" id="btnInput" value="入力画面に戻る"></a>
				<a href="regist.php"><input type="button" name="btnRegist" id="btnRegist" value="登録"></a>
			</p>
		</div>
	</div>
	<form id="frmMain" action="" method="POST"></form>
</body>
</html>
<?php
}
?>