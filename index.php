<?php
	try {

		session_start();		//SESSION開始

		// 共通関数
		require_once("cls/common.php");

		$strMsg = "";
		if(isset($_POST) && !empty($_POST)){

			// SESSION保持
			SetSession();

			// エラーメッセージ
			$strMsg = InputCheck();
			if(empty($strMsg)){
				// 確認画面
				header("Location:confirm.php");
				exit;	
			}
		}

		// 画面表示
		ScreenDraw($strMsg);

	} catch (Exception $e) {
		echo $e;
		exit;
	}

/**
 * [入力値チェック]
 */
function InputCheck(){

	$strMsg = "";

	// 1.入力必須が未記入なら送信できない
	// 2.アンケートが未記入だと送信できない
	// 3.数字を入力するフォームは半角のみ入力
	// 4.電話番号に「-」がある場合
	// 5.その他を選択している場合に限りテキストフォームが未記入
	// 6.メールアドレスとメールアドレス(確認)の内容が違う
	// 7.生年月日が18歳以下の場合は登録不可
	
	// アンケート1
	if(empty($_SESSION["ans1"])) $strMsg .= "「貴方の年齢は？」のいずれか選択してください。\n";
	// アンケート2
	if(empty($_SESSION["ans2"])){
		$strMsg .= "「好きな犬種は？」のいずれか選択してください。\n";
	} else if(array_search("19", $_SESSION["ans2"]) !== false && empty($_SESSION["ans2_text"])) {
		$strMsg .= "「好きな犬種は？」のその他テキスト欄を入力してください。\n";
	}
	// アンケート3
	if(empty($_SESSION["ans3"])){
		$strMsg .= "「当サイトをどこでお知りになりましたか？」のいずれか選択してください。\n";
	} else if($_SESSION["ans3"] == "10" && empty($_SESSION["ans3_text"])) {
		$strMsg .= "「当サイトをどこでお知りになりましたか？」のその他テキスト欄を入力してください。\n";
	}
	// アンケート4
	if(empty($_SESSION["ans4"])){
		$strMsg .= "「健康で気になる所」のいずれか選択してください。\n";
	} else if(array_search("11", $_SESSION["ans4"]) !== false && empty($_SESSION["ans4_text"])) {
		$strMsg .= "「健康で気になる所」のその他テキスト欄を入力してください。\n";
	}

	// お客様情報
	// 姓
	if(empty($_SESSION["name_sei"])) $strMsg .= "姓が未入力です。\n";
	// 名
	if(empty($_SESSION["name_mei"])) $strMsg .= "名が未入力です。\n";
	// せい
	if(empty($_SESSION["furi_sei"])) $strMsg .= "せいが未入力です。\n";
	// めい
	if(empty($_SESSION["furi_mei"])) $strMsg .= "めいが未入力です。\n";
	// 郵便番号
	if(!empty($_SESSION["zip1"]) && !preg_match("/^[0-9]+$/", $_SESSION["zip1"])) $strMsg .= "郵便番号1は半角数字のみ入力してください。\n";
	if(!empty($_SESSION["zip2"]) && !preg_match("/^[0-9]+$/", $_SESSION["zip2"])) $strMsg .= "郵便番号2は半角数字のみ入力してください。\n";
	// 電話番号
	if(!empty($_SESSION["tel"]) && !preg_match("/^[0-9]+$/", $_SESSION["tel"])) $strMsg .= "電話番号は半角数字のみ入力してください。\n";
	// 生年月日
	if(empty($_SESSION["birth_y"]) || empty($_SESSION["birth_m"]) || empty($_SESSION["birth_d"])){
		$strMsg .= "生年月日を入力してください。\n";	
	} else {
		// 年齢計算
		$strBirth = $_SESSION["birth_y"].$_SESSION["birth_m"].$_SESSION["birth_d"];
		$year = (int) ((date('Ymd')-$strBirth)/10000);
		if($year <= 18) $strMsg .= "１８歳以下は登録できません。\n";
	}
	// 性別
	if($_SESSION["sex"] != "1" && $_SESSION["sex"] != "2") $strMsg .= "性別を選択してください。\n";
	// メールアドレス
	if(empty($_SESSION["mail1"]) || empty($_SESSION["mail2"])){
		$strMsg .= "メールアドレスを入力してください。\n";
	} else if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_SESSION["mail1"])) {
	    $strMsg .= "メールアドレスを正しく入力してください。\n";
	} else if($_SESSION["mail1"] != $_SESSION["mail2"]) {
		$strMsg .= "メールアドレスが確認と一致しませんでした。\n";
	}
	
	return $strMsg;

}

/**
 * [SESSION保持]
 */
function SetSession(){

	// アンケート
	$_SESSION["ans1"] = $_POST["ans1"];
	$_SESSION["ans2"] = $_POST["ans2"];
	$_SESSION["ans2_text"] = $_POST["ans2_text"];
	$_SESSION["ans3"] = $_POST["ans3"];
	$_SESSION["ans3_text"] = $_POST["ans3_text"];
	$_SESSION["ans4"] = $_POST["ans4"];
	$_SESSION["ans4_text"] = $_POST["ans4_text"];
	// 個人情報
	$_SESSION["name_sei"] = $_POST["name_sei"];
	$_SESSION["name_mei"] = $_POST["name_mei"];
	$_SESSION["furi_sei"] = $_POST["furi_sei"];
	$_SESSION["furi_mei"] = $_POST["furi_mei"];
	$_SESSION["zip1"] = $_POST["zip1"];
	$_SESSION["zip2"] = $_POST["zip2"];
	$_SESSION["pref"] = $_POST["pref"];
	$_SESSION["address1"] = $_POST["address1"];
	$_SESSION["address2"] = $_POST["address2"];
	$_SESSION["tel"] = $_POST["tel"];
	$_SESSION["birth_y"] = $_POST["birth_y"];
	$_SESSION["birth_m"] = $_POST["birth_m"];
	$_SESSION["birth_d"] = $_POST["birth_d"];
	$_SESSION["sex"] = $_POST["sex"];
	$_SESSION["mail1"] = $_POST["mail1"];
	$_SESSION["mail2"] = $_POST["mail2"];
}

/**
 * [入力画面表示]
 */
function ScreenDraw($strMsg){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>アンケート</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="js/jquery.numeric.min.js"></script>
</head>
<body>
	<div id="container">
		<form id="frmMain" action="index.php" method="POST">
		<div class="question_area">
			<p class="header">アンケート</p>
<?php
			// チェック再起
			$aryChk = array_fill(1, 9, "");
			if(!empty($_SESSION["ans1"])) $aryChk[$_SESSION["ans1"]] = " checked";
?>
			<p class="question">貴方の年齢は？</p>
			<ul class="answer">
				<li><label><input type="radio" name="ans1" value="1"<?php print h($aryChk[1]) ?>>１８～１９歳</label></li>
				<li><label><input type="radio" name="ans1" value="2"<?php print h($aryChk[2]) ?>>２０～２４歳</label></li>
				<li><label><input type="radio" name="ans1" value="3"<?php print h($aryChk[3]) ?>>２５～２９歳</label></li>
				<li><label><input type="radio" name="ans1" value="4"<?php print h($aryChk[4]) ?>>３０～３４歳</label></li>
				<li><label><input type="radio" name="ans1" value="5"<?php print h($aryChk[5]) ?>>３５～３９歳</label></li>
				<li><label><input type="radio" name="ans1" value="6"<?php print h($aryChk[6]) ?>>４０～４４歳</label></li>
				<li><label><input type="radio" name="ans1" value="7"<?php print h($aryChk[7]) ?>>４５～５１歳</label></li>
				<li><label><input type="radio" name="ans1" value="8"<?php print h($aryChk[8]) ?>>５０～５４歳</label></li>
				<li><label><input type="radio" name="ans1" value="9"<?php print h($aryChk[9]) ?>>５５歳以上</label></li>
			</ul>

<?php
			// チェック再起
			$aryChk = array_fill(1, 19, "");
			if(isset($_SESSION["ans2"]) && is_array($_SESSION["ans2"])){
				foreach($_SESSION["ans2"] AS $key => $value){
					$aryChk[$value] = " checked";
				}
			}
?>
			<p class="question">好きな犬種は？</p>
			<p class="extention">※複数選択可能</p>
			<ul class="answer">
				<li><label><input type="checkbox" name="ans2[]" value="1"<?php print h($aryChk[1]) ?>>プードル</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="2"<?php print h($aryChk[2]) ?>>ダックスフンド</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="3"<?php print h($aryChk[3]) ?>>チワワ</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="4"<?php print h($aryChk[4]) ?>>柴犬</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="5"<?php print h($aryChk[5]) ?>>ポメラニアン</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="6"<?php print h($aryChk[6]) ?>>ヨークシャー・テリア</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="7"<?php print h($aryChk[7]) ?>>パピヨン</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="8"<?php print h($aryChk[8]) ?>>フレンチ・ブルドッグ</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="9"<?php print h($aryChk[9]) ?>>ミニチュア・シュナウザー</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="10"<?php print h($aryChk[10]) ?>>パグ</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="11"<?php print h($aryChk[11]) ?>>ウェルシュ・コーギー</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="12"<?php print h($aryChk[12]) ?>>ビーグル</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="13"<?php print h($aryChk[13]) ?>>ラブラドール・レトリバー</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="14"<?php print h($aryChk[14]) ?>>ゴールデン・レトリバー</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="15"<?php print h($aryChk[15]) ?>>ジャック・ラッセル・テリア</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="16"<?php print h($aryChk[16]) ?>>ジャーマン・シェパード・ドッグ</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="17"<?php print h($aryChk[17]) ?>>ドーベルマン</label></li>
				<li><label><input type="checkbox" name="ans2[]" value="18"<?php print h($aryChk[18]) ?>>ＭＩＸ</label></li>
				<li class="mb10"><label><input type="checkbox" name="ans2[]" id="ans2_other" value="19"<?php print h($aryChk[19]) ?>>その他</label></li>
				<p class="fs8 mb5">※その他を選択した場合ご記入ください</p>
				<input type="text" name="ans2_text" id="ans2_text" value="<?php print h($_SESSION["ans2_text"]) ?>" class="width300 disabled" disabled>
			</ul>
		
<?php
			// チェック再起
			$aryChk = array_fill(1, 10, "");
			if(!empty($_SESSION["ans3"])) $aryChk[$_SESSION["ans3"]] = " checked";
?>
			<p class="question">当サイトをどこでお知りになりましたか？</p>
			<ul class="answer">
				<li><label><input type="radio" name="ans3" value="1"<?php print h($aryChk[1]) ?>>ハガキ</label></li>
				<li><label><input type="radio" name="ans3" value="2"<?php print h($aryChk[2]) ?>>メールマガジン</label></li>
				<li><label><input type="radio" name="ans3" value="3"<?php print h($aryChk[3]) ?>>検索エンジン</label></li>
				<li><label><input type="radio" name="ans3" value="4"<?php print h($aryChk[4]) ?>>会報誌</label></li>
				<li><label><input type="radio" name="ans3" value="5"<?php print h($aryChk[5]) ?>>イベント</label></li>
				<li><label><input type="radio" name="ans3" value="6"<?php print h($aryChk[6]) ?>>チラシ</label></li>
				<li><label><input type="radio" name="ans3" value="7"<?php print h($aryChk[7]) ?>>友人・知人・家族の紹介</label></li>
				<li><label><input type="radio" name="ans3" value="8"<?php print h($aryChk[8]) ?>>ＴＶ</label></li>
				<li><label><input type="radio" name="ans3" value="9"<?php print h($aryChk[9]) ?>>覚えていない</label></li>
				<li class="mb10"><label><input type="radio" name="ans3" id="ans3_other" value="10"<?php print h($aryChk[10]) ?>>その他</label></li>

				<p class="fs8 mb5">※その他を選択した場合ご記入ください</p>
				<input type="text" name="ans3_text" id="ans3_text" value="<?php print h($_SESSION["ans3_text"]) ?>" class="width300 disabled" disabled>
			</ul>

<?php
			// チェック再起
			$aryChk = array_fill(1, 11, "");
			if(is_array($_SESSION["ans4"])){
				foreach($_SESSION["ans4"] AS $key => $value){
					$aryChk[$value] = " checked";
				}
			}
?>

			<p class="question">健康で気になる所</p>
			<p class="extention">※複数選択可能</p>
			<ul class="answer">
				<li><label><input type="checkbox" name="ans4[]" value="1"<?php print h($aryChk[1]) ?>>ない</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="2"<?php print h($aryChk[2]) ?>>足</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="3"<?php print h($aryChk[3]) ?>>関節</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="4"<?php print h($aryChk[4]) ?>>目</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="5"<?php print h($aryChk[5]) ?>>皮膚</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="6"<?php print h($aryChk[6]) ?>>歯</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="7"<?php print h($aryChk[7]) ?>>鼻</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="8"<?php print h($aryChk[8]) ?>>耳</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="9"<?php print h($aryChk[9]) ?>>胃腸</label></li>
				<li><label><input type="checkbox" name="ans4[]" value="10"<?php print h($aryChk[10]) ?>>指</label></li>
				<li class="mb10"><label><input type="checkbox" name="ans4[]" id="ans4_other" value="11"<?php print h($aryChk[11]) ?>>その他</label></li>
				<p class="fs8 mb5">※その他を選択した場合ご記入ください</p>
				<input type="text" name="ans4_text" id="ans4_text" value="<?php print h($_SESSION["ans4_text"]) ?>" class="width300 disabled" disabled>
			</ul>
		</div>
		<div class="customer_area">
			<p class="customer">お客様情報</p>
			<dl>
				<dt>お名前</dt>
				<dd>
					姓&nbsp;<input type="text" name="name_sei" id="name_sei" value="<?php print h($_SESSION["name_sei"]) ?>" class="custname">&nbsp;&nbsp;
					名&nbsp;<input type="text" name="name_mei" id="name_mei" value="<?php print h($_SESSION["name_mei"]) ?>" class="custname">
				</dd>
			</dl>
			<dl class="underline">
				<dt class="fs8 fc_red pt10">(必須)</dt>
				<dd><span class="fs8">例)リアズ　太郎</span><span class="fs8 fc_red">※法人名でのご登録は、承っておりません。</span></dd>
			</dl>
			<dl>
				<dt>ふりがな</dt>
				<dd>
					せい&nbsp;<input type="text" name="furi_sei" id="furi_sei" value="<?php print h($_SESSION["furi_sei"]) ?>" class="custname">&nbsp;&nbsp;
					めい&nbsp;<input type="text" name="furi_mei" id="furi_mei" value="<?php print h($_SESSION["furi_mei"]) ?>" class="custname"></dd>
			</dl>
			<dl class="underline">
				<dt class="fs8 fc_red pt10">(必須)</dt>
				<dd><span class="fs8">例)りあず　たろう</span></dd>
			</dl>
			<dl>
				<dt>郵便番号</dt>
				<dd>
					〒<input type="text" name="zip1" id="zip1" value="<?php print h($_SESSION["zip1"]) ?>" class="number width30" maxlength="3">
					-<input type="text" name="zip2" id="zip2" value="<?php print h($_SESSION["zip2"]) ?>" class="number width40" maxlength="4">
					<span class="fs8">(半角英数字)</span>
				</dd>
			</dl>
			<dl class="underline">
				<dt>&nbsp;</dt>
				<dd class="pt5"><span class="fs9">■郵便番号がわからない場合は<a href="#" onClick="return false;" id="zip_search">郵便番号検索</a>をクリックしてください。</span></dd>
			</dl>
			<dl class="mb20">
				<dt>住所</dt>
				<dd><input type="text" name="pref" id="pref" value="<?php print h($_SESSION["pref"]) ?>" class="width200"><span class="fs8">&nbsp;(都道府県)</span></dd>
			</dl>
			<dl>
				<dt>&nbsp;</dt>
				<dd><input type="text" name="address1" id="address1" value="<?php print h($_SESSION["address1"]) ?>" class="width300"><span class="fs8">&nbsp;(市区郡・町村)</span></dd>
			</dl>
			<dl class="mb20">
				<dt>&nbsp;</dt>
				<dd><span class="fs8">例)港区南麻布</span></dd>
			</dl>
			<dl>
				<dt>&nbsp;</dt>
				<dd><input type="text" name="address2" id="address2" value="<?php print h($_SESSION["address2"]) ?>" class="width360"></dd>
			</dl>
			<dl class="underline">
				<dt>&nbsp;</dt>
				<dd><span class="fs8">(番地、アパート、マンション、部屋番号)<br />例)１２－２７－３１サムティビル４階</span></dd>
			</dl>
			<dl>
				<dt>電話番号</dt>
				<dd><input type="text" name="tel" id="tel" value="<?php print h($_SESSION["tel"]) ?>" class="number width160"><span class="fs8">(半角英数字)</span></dd>
			</dl>
			<dl class="underline">
				<dt><span class="fs8">(携帯でも可)</span></dt>
				<dd><span class="fs8">例)0120998888</span></dd>
			</dl>
			<dl class="underline">
				<dt>生年月日</dt>
				<dd>
					<input type="text" name="birth_y" id="birth_y" value="<?php print h($_SESSION["birth_y"]) ?>" class="width40" maxlength="4">&nbsp;年
					<select name="birth_m" id="birth_m">
<?php
						for($i = 1;$i <= 12;$i++){
							$strSel = ($i == $_SESSION["birth_m"] ? "selected" : "");
print "						<option value=\"".h($i)."\" $strSel>".h($i)."</option>\n";
						}
?>
					</select>&nbsp;月
					<select name="birth_d" id="birth_d">
<?php
						for($i = 1;$i <= 31;$i++){
							$strSel = ($i == $_SESSION["birth_d"] ? "selected" : "");
print "						<option value=\"".h($i)."\" $strSel>".h($i)."</option>\n";
						}
?>
					</select>&nbsp;日
					<span class="fs8">(西暦 半角英数字)</span>
				</dd>
			</dl>
			<dl>
				<dt>性別</dt>
				<dd>
					<label><input type="radio" name="sex" id="sex1" value="1"<?php if($_SESSION["sex"] == "1") print " checked" ?>>男</label>&nbsp;
					<label><input type="radio" name="sex" id="sex2" value="2"<?php if($_SESSION["sex"] == "2") print " checked" ?>>女</label>
				</dd>
			</dl>
			<dl class="underline">
				<dt><span class="fs8 fc_red pt10">(必須)</span></dt>
				<dd>&nbsp;</dd>
			</dl>
			<dl>
				<dt>メールアドレス</dt>
				<dd><span class="fc_red">無効なメールアドレスの場合、受付できません。</span></dd>
			</dl>
			<dl>
				<dt><span class="fs8 fc_red pt10">(必須)</span></dt>
				<dd><input type="text" name="mail1" id="mail1" value="<?php print h($_SESSION["mail1"]) ?>" class="width360"></dd>
			</dl>
			<dl class="underline">
				<dt>&nbsp;</dt>
				<dd><span class="fs8">(半角英数字)</span></dd>
			</dl>
			<dl>
				<dt>メールアドレス</dt>
				<dd><input type="text" name="mail2" id="mail2" value="<?php print h($_SESSION["mail2"]) ?>" class="width360"></dd>
			</dl>
			<dl class="underline">
				<dt><span class="fs8 pt10">(確認)</span></dt>
				<dd><span class="fs8">(半角英数字)</span></dd>
			</dl>
			<p class="btnArea">
				<input type="button" name="btnReset" id="btnReset" value="内容をクリア">
				<input type="button" name="btnConfirm" id="btnConfirm" value="入力確認画面へ">
			</p>
		</div>
		<input type="hidden" name="alertMsg" id="alertMsg" value="<?php print h($strMsg) ?>" />
		</form>
	</div>
</body>
</html>
<?php
}
?>
