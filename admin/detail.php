<?php
	try {

		session_start();		//SESSION開始

		// 共通関数
		require_once("../cls/common.php");
		// DB関数
		require_once("../cls/DBClass.php");

		if(empty($_POST["custno"])){
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
function GetAnswerDetail(){

	$db = new DBClass();

	try {

		// SQL
		$strSQL = "SELECT ";
		$strSQL .= " T1.custno ";
		$strSQL .= ",T1.name_sei ";
		$strSQL .= ",T1.name_mei ";
		$strSQL .= ",T1.furi_sei ";
		$strSQL .= ",T1.furi_mei ";
		$strSQL .= ",T1.zip ";
		$strSQL .= ",T1.pref ";
		$strSQL .= ",T1.address1 ";
		$strSQL .= ",T1.address2 ";
		$strSQL .= ",T1.tel ";
		$strSQL .= ",T1.birth ";
		$strSQL .= ",T1.sex ";
		$strSQL .= ",T1.mail ";
		$strSQL .= ",T2.kbn ";
		$strSQL .= ",T2.value ";
		$strSQL .= ",T2.other_text ";
		
		$strSQL .= "FROM ms_customer AS T1 ";
		$strSQL .= "INNER JOIN tr_answer AS T2 ";
		$strSQL .= "ON T1.custno = T2.custno ";
		$strSQL .= "AND T1.custno = :custno ";

		$result = $db->prepare($strSQL);
		$result->bindParam(":custno", $_POST["custno"], PDO::PARAM_STR);
		$result->execute();

		$aryRet = array();
		$custFlg = false;
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			if($custFlg === false){
				$aryRet["custno"] = $row["custno"];
				$aryRet["name_sei"] = $row["name_sei"];
				$aryRet["name_mei"] = $row["name_mei"];
				$aryRet["furi_sei"] = $row["furi_sei"];
				$aryRet["furi_mei"] = $row["furi_mei"];
				$aryRet["zip"] = substr($row["zip"], 0, 3) . "-" . substr($row["zip"], 3, 4);
				$aryRet["pref"] = $row["pref"];
				$aryRet["address1"] = $row["address1"];
				$aryRet["address2"] = $row["address2"];
				$aryRet["tel"] = $row["tel"];
				$aryRet["birth"] = $row["birth"];
				$aryRet["sex"] = $row["sex"];
				$aryRet["mail"] = $row["mail"];

				$custFlg = true;
			}

			$idx = $row["kbn"];
			if(!empty($aryRet["value"][$idx])) $aryRet["value"][$idx] .= "、";
			$aryRet["value"][$idx] .= constant("ANS" . $row["kbn"] . "_" . $row["value"]);
			$aryRet["other_text"][$idx] = $row["other_text"];
		}
		
		return $aryRet;

	} catch (PDOException $e) {
		throw $e;
	}

	return $aryRet;

}

/**
 * [入力画面表示]
 */
function ScreenDraw(){

	// お客様詳細取得
	$aryDetail = GetAnswerDetail();

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
		<p class="customerHeader">お客様情報</p>
		<table class="detailTbl">
			<tr>
				<th>お名前</th>
				<td><?php print h($aryDetail["name_sei"] . " " . $aryDetail["name_mei"]) ?></td>
			</tr>
			<tr>
				<th>ふりがな</th>
				<td><?php print h($aryDetail["furi_sei"] . " " . $aryDetail["furi_mei"]) ?></td>
			</tr>
			<tr>
				<th>郵便番号</th>
				<td><?php print h($aryDetail["zip"]) ?></td>
			</tr>
			<tr>
				<th>住所</th>
				<td><?php print h($aryDetail["pref"] . $aryDetail["address1"] . $aryDetail["address2"]) ?></td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td><?php print h($aryDetail["tel"]) ?></td>
			</tr>
			<tr>
				<th>生年月日</th>
				<td><?php print h(substr($aryDetail["birth"], 0, 4) . "/" . substr($aryDetail["birth"], 4, 2) . "/" . substr($aryDetail["birth"], 6, 2)) ?></td>
			</tr>
			<tr>
				<th>性別</th>
				<td><?php print ($aryDetail["sex"] == "1" ? "男" : "女") ?></td>
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td><?php print h($aryDetail["mail"]) ?></td>
			</tr>
			<tr>
				<th>貴方の年齢は？</th>
				<td><?php print h($aryDetail["value"][1]) ?></td>
			</tr>
			<tr>
				<th>好きな犬種は？</th>
				<td><?php print h($aryDetail["value"][2]) ?><?php if(!empty($aryDetail["other_text"][2])) print "(" . h($aryDetail["other_text"][2]) . ")" ?></td>
			</tr>
			<tr>
				<th>当サイトをどこでお知りになりましたか？</th>
				<td><?php print h($aryDetail["value"][3]) ?><?php if(!empty($aryDetail["other_text"][3])) print "(" . h($aryDetail["other_text"][3]) . ")" ?></td>
			</tr>
			<tr>
				<th>健康で気になる所</th>
				<td><?php print h($aryDetail["value"][4]) ?><?php if(!empty($aryDetail["other_text"][4])) print "(" . h($aryDetail["other_text"][4]) . ")" ?></td>
			</tr>
		</table>
		<div class="list_btn">
			<input type="button" id="list" class="button color1" value=" 一覧に戻る " />
		</div>
	</div>
	<form id="frmMain" action="list.php" method="POST">
		<input type="hidden" name="ans_cd" value="<?php print h($_POST["ans_cd"]) ?>" />
	</form>
</body>
</html>
<?php
}
?>