<?php
	try {

		session_start();		//SESSION開始

		// 共通関数
		require_once("../cls/common.php");
		// DB関数
		require_once("../cls/DBClass.php");

		// 画面表示
		ScreenDraw();

	} catch (Exception $e) {
		echo $e;
		exit;
	}

/**
 * アンケート集計
 */
function GetAnserTotal(){

	$db = new DBClass();

	try {
		
		// SQL
		$strSQL = "SELECT ";
		$strSQL .= " kbn ";
		$strSQL .= ",value ";
		$strSQL .= ",COUNT(*) AS cnt ";
		$strSQL .= "FROM tr_answer ";
		$strSQL .= "GROUP BY kbn, value ";

		$result = $db->query($strSQL);

		$aryRet = array();
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$key = $row["kbn"] . "-" . $row["value"];
			$aryRet[$key] = $row["cnt"];
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

	// アンケート集計
	$aryAns = GetAnserTotal();

?>
<!DOCTYPE html>
<html lang="ja">
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
		<p class="question">貴方の年齢は？</p>
		<div class="btn_area clearfix">
			<input type="button" class="button color1" value="<?php print h(ANS1_1) ?> [<?php print (int)h($aryAns["1-1"]) ?>人]" data-count="<?php print (int)h($aryAns["1-1"]) ?>" data-value="1_1" />
			<input type="button" class="button color1" value="<?php print h(ANS1_2) ?> [<?php print (int)h($aryAns["1-2"]) ?>人]" data-count="<?php print (int)h($aryAns["1-2"]) ?>" data-value="1_2" />
			<input type="button" class="button color1" value="<?php print h(ANS1_3) ?> [<?php print (int)h($aryAns["1-3"]) ?>人]" data-count="<?php print (int)h($aryAns["1-3"]) ?>" data-value="1_3" />
			<input type="button" class="button color1" value="<?php print h(ANS1_4) ?> [<?php print (int)h($aryAns["1-4"]) ?>人]" data-count="<?php print (int)h($aryAns["1-4"]) ?>" data-value="1_4" />
			<input type="button" class="button color1" value="<?php print h(ANS1_5) ?> [<?php print (int)h($aryAns["1-5"]) ?>人]" data-count="<?php print (int)h($aryAns["1-5"]) ?>" data-value="1_5" />
			<input type="button" class="button color1" value="<?php print h(ANS1_6) ?> [<?php print (int)h($aryAns["1-6"]) ?>人]" data-count="<?php print (int)h($aryAns["1-6"]) ?>" data-value="1_6" />
			<input type="button" class="button color1" value="<?php print h(ANS1_7) ?> [<?php print (int)h($aryAns["1-7"]) ?>人]" data-count="<?php print (int)h($aryAns["1-7"]) ?>" data-value="1_7" />
			<input type="button" class="button color1" value="<?php print h(ANS1_8) ?> [<?php print (int)h($aryAns["1-8"]) ?>人]" data-count="<?php print (int)h($aryAns["1-8"]) ?>" data-value="1_8" />
			<input type="button" class="button color1" value="<?php print h(ANS1_9) ?> [<?php print (int)h($aryAns["1-9"]) ?>人]" data-count="<?php print (int)h($aryAns["1-9"]) ?>" data-value="1_9" />
		</div>

		<p class="question">好きな犬種は？</p>
		<div class="btn_area clearfix">
			<input type="button" class="button color2" value="<?php print h(ANS2_1) ?> [<?php print (int)h($aryAns["2-1"]) ?>人]" data-count="<?php print (int)h($aryAns["2-1"]) ?>" data-value="2_1" />
			<input type="button" class="button color2" value="<?php print h(ANS2_2) ?> [<?php print (int)h($aryAns["2-2"]) ?>人]" data-count="<?php print (int)h($aryAns["2-2"]) ?>" data-value="2_2"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_3) ?> [<?php print (int)h($aryAns["2-3"]) ?>人]" data-count="<?php print (int)h($aryAns["2-3"]) ?>" data-value="2_3"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_4) ?> [<?php print (int)h($aryAns["2-4"]) ?>人]" data-count="<?php print (int)h($aryAns["2-4"]) ?>" data-value="2_4"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_5) ?> [<?php print (int)h($aryAns["2-5"]) ?>人]" data-count="<?php print (int)h($aryAns["2-5"]) ?>" data-value="2_5"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_6) ?> [<?php print (int)h($aryAns["2-6"]) ?>人]" data-count="<?php print (int)h($aryAns["2-6"]) ?>" data-value="2_6"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_7) ?> [<?php print (int)h($aryAns["2-7"]) ?>人]" data-count="<?php print (int)h($aryAns["2-7"]) ?>" data-value="2_7"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_8) ?> [<?php print (int)h($aryAns["2-8"]) ?>人]" data-count="<?php print (int)h($aryAns["2-8"]) ?>" data-value="2_8"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_9) ?> [<?php print (int)h($aryAns["2-9"]) ?>人]" data-count="<?php print (int)h($aryAns["2-9"]) ?>" data-value="2_9"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_10) ?> [<?php print (int)h($aryAns["2-10"]) ?>人]" data-count="<?php print (int)h($aryAns["2-10"]) ?>" data-value="2_10"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_11) ?> [<?php print (int)h($aryAns["2-11"]) ?>人]" data-count="<?php print (int)h($aryAns["2-11"]) ?>" data-value="2_11"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_12) ?> [<?php print (int)h($aryAns["2-12"]) ?>人]" data-count="<?php print (int)h($aryAns["2-12"]) ?>" data-value="2_12"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_13) ?> [<?php print (int)h($aryAns["2-13"]) ?>人]" data-count="<?php print (int)h($aryAns["2-13"]) ?>" data-value="2_13"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_14) ?> [<?php print (int)h($aryAns["2-14"]) ?>人]" data-count="<?php print (int)h($aryAns["2-14"]) ?>" data-value="2_14"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_15) ?> [<?php print (int)h($aryAns["2-15"]) ?>人]" data-count="<?php print (int)h($aryAns["2-15"]) ?>" data-value="2_15"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_16) ?> [<?php print (int)h($aryAns["2-16"]) ?>人]" data-count="<?php print (int)h($aryAns["2-16"]) ?>" data-value="2_16"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_17) ?> [<?php print (int)h($aryAns["2-17"]) ?>人]" data-count="<?php print (int)h($aryAns["2-17"]) ?>" data-value="2_17"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_18) ?> [<?php print (int)h($aryAns["2-18"]) ?>人]" data-count="<?php print (int)h($aryAns["2-18"]) ?>" data-value="2_18"　/>
			<input type="button" class="button color2" value="<?php print h(ANS2_19) ?> [<?php print (int)h($aryAns["2-19"]) ?>人]" data-count="<?php print (int)h($aryAns["2-19"]) ?>" data-value="2_19"　/>
		</div>

		<p class="question">当サイトをどこでお知りになりましたか？</p>
		<div class="btn_area clearfix">
			<input type="button" class="button color3" value="<?php print h(ANS3_1) ?> [<?php print (int)h($aryAns["3-1"]) ?>人]" data-count="<?php print (int)h($aryAns["3-1"]) ?>" data-value="3_1"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_2) ?> [<?php print (int)h($aryAns["3-2"]) ?>人]" data-count="<?php print (int)h($aryAns["3-2"]) ?>" data-value="3_2"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_3) ?> [<?php print (int)h($aryAns["3-3"]) ?>人]" data-count="<?php print (int)h($aryAns["3-3"]) ?>" data-value="3_3"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_4) ?> [<?php print (int)h($aryAns["3-4"]) ?>人]" data-count="<?php print (int)h($aryAns["3-4"]) ?>" data-value="3_4"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_5) ?> [<?php print (int)h($aryAns["3-5"]) ?>人]" data-count="<?php print (int)h($aryAns["3-5"]) ?>" data-value="3_5"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_6) ?> [<?php print (int)h($aryAns["3-6"]) ?>人]" data-count="<?php print (int)h($aryAns["3-6"]) ?>" data-value="3_6"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_7) ?> [<?php print (int)h($aryAns["3-7"]) ?>人]" data-count="<?php print (int)h($aryAns["3-7"]) ?>" data-value="3_7"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_8) ?> [<?php print (int)h($aryAns["3-8"]) ?>人]" data-count="<?php print (int)h($aryAns["3-8"]) ?>" data-value="3_8"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_9) ?> [<?php print (int)h($aryAns["3-9"]) ?>人]" data-count="<?php print (int)h($aryAns["3-9"]) ?>" data-value="3_9"　/>
			<input type="button" class="button color3" value="<?php print h(ANS3_10) ?> [<?php print (int)h($aryAns["3-10"]) ?>人]" data-count="<?php print (int)h($aryAns["3-10"]) ?>" data-value="3_10"　/>
		</div>

		<p class="question">健康で気になる所</p>
		<div class="btn_area clearfix">
			<input type="button" class="button color4" value="<?php print h(ANS4_1) ?> [<?php print (int)h($aryAns["4-1"]) ?>人]" data-count="<?php print (int)h($aryAns["4-1"]) ?>" data-value="4_1"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_2) ?> [<?php print (int)h($aryAns["4-2"]) ?>人]" data-count="<?php print (int)h($aryAns["4-2"]) ?>" data-value="4_2"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_3) ?> [<?php print (int)h($aryAns["4-3"]) ?>人]" data-count="<?php print (int)h($aryAns["4-3"]) ?>" data-value="4_3"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_4) ?> [<?php print (int)h($aryAns["4-4"]) ?>人]" data-count="<?php print (int)h($aryAns["4-4"]) ?>" data-value="4_4"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_5) ?> [<?php print (int)h($aryAns["4-5"]) ?>人]" data-count="<?php print (int)h($aryAns["4-5"]) ?>" data-value="4_5"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_6) ?> [<?php print (int)h($aryAns["4-6"]) ?>人]" data-count="<?php print (int)h($aryAns["4-6"]) ?>" data-value="4_6"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_7) ?> [<?php print (int)h($aryAns["4-7"]) ?>人]" data-count="<?php print (int)h($aryAns["4-7"]) ?>" data-value="4_7"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_8) ?> [<?php print (int)h($aryAns["4-8"]) ?>人]" data-count="<?php print (int)h($aryAns["4-8"]) ?>" data-value="4_8"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_9) ?> [<?php print (int)h($aryAns["4-9"]) ?>人]" data-count="<?php print (int)h($aryAns["4-9"]) ?>" data-value="4_9"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_10) ?> [<?php print (int)h($aryAns["4-10"]) ?>人]" data-count="<?php print (int)h($aryAns["4-10"]) ?>" data-value="4_10"　/>
			<input type="button" class="button color4" value="<?php print h(ANS4_11) ?> [<?php print (int)h($aryAns["4-11"]) ?>人]" data-count="<?php print (int)h($aryAns["4-11"]) ?>" data-value="4_11"　/>
		</div>
		<form name="frmMain" id="frmMain" action="list.php" method="POST">
			<input type="hidden" name="ans_cd" id="ans_cd" value="" />
		</form>
	</div>
</body>
</html>
<?php
}
?>