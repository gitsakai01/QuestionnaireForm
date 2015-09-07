$(function(){

	// アンケート一覧
	$(".button").click(function(){
		if($(this).data("count") == 0) return;
		$("#ans_cd").val($(this).data("value"));
		$("#frmMain").submit();
	});
	// 0件データ
	$(".button").each(function(){
		if($(this).data("count") == 0) $(this).addClass("nodata").removeClass("button");
	});

	// 詳細ボタン
	$(".detail").click(function(){
		$("#custno").val($(this).data("value"));
		$("#frmMain").submit();
	});

	// 一覧戻る
	$(".list").click(function(){
		$("#frmMain").submit();
	});
	


});