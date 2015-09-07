<?php

	try {

		session_start();		//SESSION開始

		// 共通関数
		require_once("cls/common.php");

		if(empty($_SESSION)){
			header("Location: index.php");
			exit;
		}
		// 登録処理
		RegistData();
		// メール送信処理
		SendMail();

		// SESSION破棄
		session_destroy();

		// 画面表示
		ScreenDraw();

	} catch (Exception $e) {

	}

/**
 * 登録処理
 */
function RegistData(){

	require_once("cls/DBClass.php");

	// DB接続
	$db = new DBClass();

	try {

		// トランザクション開始
		$db->BeginTran();

		// 連番の次回値を取得
		$strSQL = "SHOW TABLE STATUS ";
		$strSQL .= "LIKE 'ms_customer' ";
		$result = $db->query($strSQL);

		$row = $result->fetch(PDO::FETCH_ASSOC);
		$intIncNo = $row["Auto_increment"];
		
		// SQL
		$strSQL = "INSERT INTO ms_customer (";
		$strSQL .= " name_sei ";
		$strSQL .= ",name_mei ";
		$strSQL .= ",furi_sei ";
		$strSQL .= ",furi_mei ";
		$strSQL .= ",zip ";
		$strSQL .= ",pref ";
		$strSQL .= ",address1 ";
		$strSQL .= ",address2 ";
		$strSQL .= ",tel ";
		$strSQL .= ",birth ";
		$strSQL .= ",sex ";
		$strSQL .= ",mail ";
		$strSQL .= ",adddate ";
		$strSQL .= ") VALUES (";
		$strSQL .= ":name_sei ";
		$strSQL .= ",:name_mei ";
		$strSQL .= ",:furi_sei ";
		$strSQL .= ",:furi_mei ";
		$strSQL .= ",:zip ";
		$strSQL .= ",:pref ";
		$strSQL .= ",:address1 ";
		$strSQL .= ",:address2 ";
		$strSQL .= ",:tel ";
		$strSQL .= ",:birth ";
		$strSQL .= ",:sex ";
		$strSQL .= ",:mail ";
		$strSQL .= ",now() ";
		$strSQL .= ")";

		// パラメーターフォーマット
		$strZip = "";
		if(!empty($_SESSION["zip1"]) && !empty($_SESSION["zip2"])){
			$strZip = $_SESSION["zip1"] . $_SESSION["zip2"];
		}

		$strBirth = "";
		if(!empty($_SESSION["birth_y"]) && !empty($_SESSION["birth_m"]) && !empty($_SESSION["birth_d"])){
			$strBirth = $_SESSION["birth_y"] . sprintf("%02d", $_SESSION["birth_m"]) . sprintf("%02d", $_SESSION["birth_d"]);
		}

		// SQL発行準備
		$result = $db->prepare($strSQL);
		$result->bindParam(":name_sei", $_SESSION["name_sei"], PDO::PARAM_STR);
		$result->bindParam(":name_mei", $_SESSION["name_mei"], PDO::PARAM_STR);
		$result->bindParam(":furi_sei", $_SESSION["furi_sei"], PDO::PARAM_STR);
		$result->bindParam(":furi_mei", $_SESSION["furi_mei"], PDO::PARAM_STR);
		$result->bindParam(":zip", $strZip, PDO::PARAM_STR);
		$result->bindParam(":pref", $_SESSION["pref"], PDO::PARAM_STR);
		$result->bindParam(":address1", $_SESSION["address1"], PDO::PARAM_STR);
		$result->bindParam(":address2", $_SESSION["address2"], PDO::PARAM_STR);
		$result->bindParam(":tel", $_SESSION["tel"], PDO::PARAM_STR);
		$result->bindParam(":birth", $strBirth, PDO::PARAM_STR);
		$result->bindParam(":sex", $_SESSION["sex"], PDO::PARAM_STR);
		$result->bindParam(":mail", $_SESSION["mail1"], PDO::PARAM_STR);

		$result->execute();

		// アンケート内容
		$strSQL = "INSERT INTO tr_answer (";
		$strSQL .= " custno ";
		$strSQL .= ",seq ";
		$strSQL .= ",kbn ";
		$strSQL .= ",value ";
		$strSQL .= ",other_text ";
		$strSQL .= ",adddate ";
		$strSQL .= ") VALUES (";
		$strSQL .= " :custno ";
		$strSQL .= ",:seq ";
		$strSQL .= ",:kbn ";
		$strSQL .= ",:value ";
		$strSQL .= ",:other_text ";
		$strSQL .= ",now() ";
		$strSQL .= ") ";

		// アンケートIndex
		$intIdx = 1;

		// SQL発行準備
		$result = $db->prepare($strSQL);
		$result->bindParam(":custno", $intIncNo, PDO::PARAM_INT);

		// アンケート1
		if(!empty($_SESSION["ans1"])){
			
			$result->bindParam(":seq", $intIdx, PDO::PARAM_INT);
			$result->bindValue(":kbn", "1", PDO::PARAM_STR);
			$result->bindParam(":value", $_SESSION["ans1"], PDO::PARAM_STR);
			$result->bindValue(":other_text", "", PDO::PARAM_STR);

			$result->execute();	
			$intIdx++;
		}
		// アンケート2
		if(!empty($_SESSION["ans2"]) && is_array($_SESSION["ans2"])){
			
			$result->bindValue(":kbn", "2", PDO::PARAM_STR);
			foreach($_SESSION["ans2"] AS $key => $value){
				$result->bindParam(":seq", $intIdx, PDO::PARAM_INT);
				$result->bindParam(":value", $value, PDO::PARAM_STR);
				if($value == 19){
					$result->bindValue(":other_text", $_SESSION["ans2_text"], PDO::PARAM_STR);
				} else {
					$result->bindValue(":other_text", "", PDO::PARAM_STR);
				}
				$result->execute();	
				$intIdx++;
			}
		}
		// アンケート3
		if(!empty($_SESSION["ans3"])){
			
			$result->bindParam(":seq", $intIdx, PDO::PARAM_INT);
			$result->bindValue(":kbn", "3", PDO::PARAM_STR);
			$result->bindParam(":value", $_SESSION["ans3"], PDO::PARAM_STR);
			if($_SESSION["ans3"] == 10){
					$result->bindValue(":other_text", $_SESSION["ans3_text"], PDO::PARAM_STR);
				} else {
					$result->bindValue(":other_text", "", PDO::PARAM_STR);
				}
			$result->execute();	
			$intIdx++;
		}
		// アンケート4
		if(!empty($_SESSION["ans4"]) && is_array($_SESSION["ans4"])){

			$result->bindValue(":kbn", "4", PDO::PARAM_STR);
			foreach($_SESSION["ans4"] AS $key => $value){
				$result->bindParam(":seq", $intIdx, PDO::PARAM_INT);
				$result->bindParam(":value", $value, PDO::PARAM_STR);
				if($value == 11){
					$result->bindValue(":other_text", $_SESSION["ans4_text"], PDO::PARAM_STR);
				} else {
					$result->bindValue(":other_text", "", PDO::PARAM_STR);
				}

				$result->execute();	
				$intIdx++;
			}
		}

		// Commit
		$db->CommitTran();

	} catch (Exception $e) {
		// Rollback
		$db->RollbackTran();

		throw $e;
	}
}

/**
 * [メール送信]
 */
function SendMail(){

	// 宛先
	$strTo = $_SESSION["mail1"];
	// 件名
	$strSubject = "アンケート完了メール";
	// 本文
	$strBody = "アンケート完了メールです。";

	// メール送信
	if(!mb_send_mail($strTo, $strSubject, $strBody)){
		throw new Exception("メール送信失敗");
	}
	
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
		<p>アンケートにご協力頂きありがとうございました。</p>
		<div>
			<a href="index.php"><input type="button" name="btnComp" id="btnComp" value="もどる" /></a>
		</div>
	</div>
	<form id="frmMain" action="index.php" method="POST"></form>
</body>
</html>
<?php
}
?>