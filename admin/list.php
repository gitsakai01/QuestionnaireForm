<?php
	try {

		session_start();		//SESSION開始

		// 共通関数
		require_once("../cls/common.php");
		// DB関数
		require_once("../cls/DBClass.php");

		if(empty($_POST["ans_cd"])){
			header("index.php");
			exit;
		}

		// 画面表示
		ScreenDraw();

	} catch (Exception $e) {
		echo $e;
		exit;
	}

/**
 * アンケート集計
 */
function GetAnswerList(){

	$db = new DBClass();

	try {
		
		$db = new DBClass();

	try {

		$aryParam = explode("_", $_POST["ans_cd"]);

		// SQL
		$strSQL = "SELECT ";
		$strSQL .= " T1.custno ";
		$strSQL .= ",T1.name_sei ";
		$strSQL .= ",T1.name_mei ";
		$strSQL .= ",T1.sex ";
		$strSQL .= ",T1.mail ";
		$strSQL .= ",T1.adddate ";
		$strSQL .= "FROM ms_customer AS T1 ";
		$strSQL .= "INNER JOIN tr_answer AS T2 ";
		$strSQL .= "ON T1.custno = T2.custno ";
		$strSQL .= "AND T2.kbn = :kbn ";
		$strSQL .= "AND T2.value = :value ";

		$result = $db->prepare($strSQL);
		$result->bindParam(":kbn", $aryParam[0], PDO::PARAM_STR);
		$result->bindParam(":value", $aryParam[1], PDO::PARAM_STR);
		$result->execute();

		$aryRet = array();
		$idx = 0;
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$aryRet[$idx]["custno"] = $row["custno"];
			$aryRet[$idx]["name_sei"] = $row["name_sei"];
			$aryRet[$idx]["name_mei"] = $row["name_mei"];
			if($row["sex"] == "1"){
				$aryRet[$idx]["sex"] = "男性";
			} else if($row["sex"] == "2"){
				$aryRet[$idx]["sex"] = "女性";
			}
			$aryRet[$idx]["mail"] = $row["mail"];
			$aryRet[$idx]["adddate"] = str_replace("-", "/", substr($row["adddate"], 0 , 16));

			$idx++;
		}
		$aryRet["rowCnt"] = $idx;

		return $aryRet;

	} catch (PDOException $e) {
		throw $e;
	}

		return $aryRet;

	} catch (PDOException $e) {
		throw $e;
	}

}

/**
 * [入力画面表示]
 */
function ScreenDraw(){

	// お客様一覧取得
	$aryList = GetAnswerList();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>アンケート集計 | 管理画面</title>
	<link rel="stylesheet" href="../css/admin.css">
	<link rel="stylesheet" href="../css/reset.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/admin.js"></script>
</head>
<body>
	<div id="container">
<?php
		$strTitle = "";
		switch(substr($_POST["ans_cd"], 0, 1)){
			case "1":
				$strTitle = "貴方の年齢は？";
			break;
			case "2":
				$strTitle = "好きな犬種は？";
			break;
			case "3":
				$strTitle = "当サイトをどこでお知りになりましたか？";
			break;
			case "4":
				$strTitle = "健康で気になる所";
			break;
		}
?>
		<p class="question"><?php print h($strTitle) . " " . constant("ANS".$_POST["ans_cd"]) ?></p>
		<div class="listArea">
			<table class="listTbl">
				<tr>
					<th>お客様名</th>
					<th>性別</th>
					<th>メールアドレス</th>
					<th>回答日時</th>
					<th>&nbsp;</th>
				</tr>
<?php
			for($i = 0;$i < $aryList["rowCnt"];$i++){
?>
				<tr>
					<td><?php print h($aryList[$i]["name_sei"] . " " . $aryList[$i]["name_mei"]) ?></td>
					<td><?php print h($aryList[$i]["sex"]) ?></td>
					<td><?php print h($aryList[$i]["mail"]) ?></td>
					<td><?php print h($aryList[$i]["adddate"]) ?></td>
					<td><input type="button" class="detail" value=" 詳細 " data-value="<?php print h($aryList[$i]["custno"]) ?>" /></td>
				</tr>
<?php
			}
?>
			</table>
		</div>
		<div class="list_btn">
			<a href="index.php"><input type="button" class="button color1" value=" 一覧に戻る " /></a>
		</div>
		<form id="frmMain" action="detail.php" method="POST">
			<input type="hidden" name="custno" id="custno" value="" />
			<input type="hidden" name="ans_cd" id="ans_cd" value="<?php print h($_POST["ans_cd"]) ?>" />
		</form>
	</div>
</body>
</html>
<?php
}
?>