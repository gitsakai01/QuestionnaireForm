
$(function(){
	// 初期動作
	CtrlInit();

	// アンケート2
	$("#ans2_other").click(function(){
		if($(this).prop("checked")){
			$("#ans2_text").attr("disabled", false).removeClass("disabled");
			$("#ans2_text").focus();
		} else {
			$("#ans2_text").attr("disabled", true).addClass("disabled");
		}
	});

	// アンケート3
	$("input[name='ans3']").click(function(){
		if($(this).attr("id") == "ans3_other"){
			$("#ans3_text").attr("disabled", false).removeClass("disabled");
			$("#ans3_text").focus();
		} else {
			$("#ans3_text").attr("disabled", true).addClass("disabled");;
		}
	});

	// アンケート4
	$("#ans4_other").click(function(){
		if($(this).prop("checked")){
			$("#ans4_text").attr("disabled", false).removeClass("disabled");
			$("#ans4_text").focus();
		} else {
			$("#ans4_text").attr("disabled", true).addClass("disabled");;
		}
	});

	// 郵便番号検索
	$("#zip_search").click(function(){
		// 住所未入力チェック
		if($("#pref").val() == "" && $("#address1").val() == "" && $("#address2").val() == ""){
			alert("住所のいずれかの項目を入力してください。");
			return false;
		}

		$.ajax({
			url: 'ajax_zip_search.php',
			type: 'POST',
			data: {pref: $("#pref").val(), adr1: $("#address1").val(), adr2: $("#address2").val()},
			success: function(zip){
				if(zip != ""){
					$("#zip1").val(zip.substr(0, 3));
					$("#zip2").val(zip.substr(3, 4));
				} else {
					alert("該当する郵便番号が見つかりませんでした。");
				}
			}
		});
	});

	// 確認ボタン押下
	$("#btnConfirm").click(function(){
		msg = InputCheck();
		if(msg != ""){
			alert(msg);
			return false;
		}
		$(this).attr("disabled", true);
		$(this.form).submit();
	});

	// クリアボタン押下
	$("#btnReset").click(function(){
		$(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
	});

	// エラーメッセージ
	var alertMsg = $("#alertMsg").val();
	if(alertMsg != ''){
		alert(alertMsg);
	}

});

// 初期イベント
function CtrlInit(){
	// その他チェック済テキスト
	if($("#ans2_other").prop("checked")) $("#ans2_text").attr("disabled", false).removeClass("disabled");
	if($("#ans3_other").prop("checked")) $("#ans3_text").attr("disabled", false).removeClass("disabled");
	if($("#ans4_other").prop("checked")) $("#ans4_text").attr("disabled", false).removeClass("disabled");

	// 数字入力制限
	$("#zip1, #zip2, #tel, #birth_y").numeric({
		decimal: false,
		negative: false
	});	
}

// 入力値チェック
function InputCheck(){
	var msg = "";

	// 1.入力必須が未記入なら送信できない
	if($("#name_sei").val() == "") msg += "姓が未入力です。\n";
	if($("#name_mei").val() == "") msg += "名が未入力です。\n";
	if($("#furi_sei").val() == "") msg += "せいが未入力です。\n";
	if($("#furi_mei").val() == "") msg += "めいが未入力です。\n";
	if($("#sex1").prop("checked") == false && $("#sex2").prop("checked") == false) msg += "性別が未選択です。\n";
	if($("#mail1").val() == "") msg += "メールアドレスが未入力です。\n";
	if($("#mail2").val() == "") msg += "メールアドレス(確認)が未入力です。\n";
	if($("#birth_y").val() == "") msg += "生年月日(年)を入力してください。\n";

	// 2.アンケートが未記入だと送信できない
	if($("input[name='ans1']:checked").length == 0) msg += "「貴方の年齢は？」のいずれか選択してください。\n";
	if($("input[name='ans2[]']:checked").length == 0) msg += "「好きな犬種は？」のいずれか選択してください。\n";
	if($("input[name='ans3']:checked").length == 0) msg += "「当サイトをどこでお知りになりましたか？」のいずれか選択してください。\n";
	if($("input[name='ans4[]']:checked").length == 0) msg += "「健康で気になる所」のいずれか選択してください。\n";

	// 3.数字を入力するフォームは半角のみ入力
	if($("#zip1").val() != "" && !$("#zip1").val().match(/^[0-9]+$/)) msg += "郵便番号1は半角数字のみ入力してください。\n";
	if($("#zip2").val() != "" && !$("#zip2").val().match(/^[0-9]+$/)) msg += "郵便番号2は半角数字のみ入力してください。\n";

	// 4.電話番号に「-」がある場合
	if(!$("#tel").val().match(/^[0-9]+$/)) msg += "電話番号は半角数字のみ入力可能です。\n";

	// 5.その他を選択している場合に限りテキストフォームが未記入
	if($("#ans2_other").prop("checked") && $("#ans2_text").val() == "") msg += "「好きな犬種は？」のその他テキスト欄を入力してください。\n";
	if($("#ans3_other").prop("checked") && $("#ans3_text").val() == "") msg += "「当サイトをどこでお知りになりましたか？」のその他テキスト欄を入力してください。\n";
	if($("#ans4_other").prop("checked") && $("#ans4_text").val() == "") msg += "「健康で気になる所」のその他テキスト欄を入力してください。\n";

	// 6.メールアドレスとメールアドレス(確認)の内容が違う
	if($("#mail1").val() != "" && $("#mail2").val() != ""){
		if($("#mail1").val() != $("#mail2").val()) msg += "メールアドレスが確認と一致しませんでした。\n";
	}

	
	if($("#birth_y").val() != "" && $("#birth_m").val() != "" && $("#birth_d").val() != ""){
		var y = parseInt($('#birth_y').val());
		var m = parseInt($('#birth_m').val());
		var d = parseInt($('#birth_d').val());

		var dt = new Date(y, m - 1, d);
		if(dt == null || dt.getFullYear() != y || dt.getMonth() + 1 != m || dt.getDate() != d) {
			msg += "生年月日の日付を正しく入力してください。\n";
		} else {
			myNow   = new Date();
			myBirth = new Date( 1970, 0, d );
			myBirth.setTime( myNow.getTime() - myBirth.getTime() );
			
			myYear  = myBirth.getUTCFullYear() - y;
			myMonth = myBirth.getUTCMonth() - ( m - 1 );
			
			if( myMonth < 0 ){
				myYear --;
				myMonth += 12;
			}
			if(myYear <= 18){
				msg += "１８歳以下は登録できません。\n";	
			} else {
				
			}
		}
	}

	return msg;

}