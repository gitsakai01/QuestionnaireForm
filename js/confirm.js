$(function(){

	// 入力画面に戻る
	$("#btnInput").click(function(){
		$(this).attr("disabled", true);
		$("#frmMain").attr("action", "index.php");
		$("#frmMain").submit();
	});

	// 登録画面
	$("#btnRegist").click(function(){
		$(this).attr("disabled", true);
		$("#frmMain").attr("action", "regist.php");
		$("#frmMain").submit();
	});

	// 戻る
	$("#btnComp").click(function(){
		$(this).attr("disabled", true);
		$("#frmMain").attr("action", "index.php");
		$("#frmMain").submit();
	});

});