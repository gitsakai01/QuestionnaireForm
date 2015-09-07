<?php

// 質問1
define("ANS1_1", "１８～１９歳");
define("ANS1_2", "２０～２４歳");
define("ANS1_3", "２５～２９歳");
define("ANS1_4", "３０～３４歳");
define("ANS1_5", "３５～３９歳");
define("ANS1_6", "４０～４４歳");
define("ANS1_7", "４５～５１歳");
define("ANS1_8", "５０～５４歳");
define("ANS1_9", "５５歳以上");

// 質問2
define("ANS2_1", "プードル");
define("ANS2_2", "ダックスフンド");
define("ANS2_3", "チワワ");
define("ANS2_4", "柴犬");
define("ANS2_5", "ポメラニアン");
define("ANS2_6", "ヨークシャー・テリア");
define("ANS2_7", "パピヨン");
define("ANS2_8", "フレンチ・ブルドッグ");
define("ANS2_9", "ミニチュア・シュナウザー");
define("ANS2_10", "パグ");
define("ANS2_11", "ウェルシュ・コーギー");
define("ANS2_12", "ビーグル");
define("ANS2_13", "ラブラドール・レトリバー");
define("ANS2_14", "ゴールデン・レトリバー");
define("ANS2_15", "ジャック・ラッセル・テリア");
define("ANS2_16", "ジャーマン・シェパード・ドッグ");
define("ANS2_17", "ドーベルマン");
define("ANS2_18", "ＭＩＸ");
define("ANS2_19", "その他");

// 質問3
define("ANS3_1", "ハガキ");
define("ANS3_2", "メールマガジン");
define("ANS3_3", "検索エンジン");
define("ANS3_4", "会報誌");
define("ANS3_5", "イベント");
define("ANS3_6", "チラシ");
define("ANS3_7", "友人・知人・家族の紹介");
define("ANS3_8", "ＴＶ");
define("ANS3_9", "覚えていない");
define("ANS3_10", "その他");

// 質問4
define("ANS4_1", "ない");
define("ANS4_2", "足");
define("ANS4_3", "関節");
define("ANS4_4", "目");
define("ANS4_5", "皮膚");
define("ANS4_6", "歯");
define("ANS4_7", "鼻");
define("ANS4_8", "耳");
define("ANS4_9", "胃腸");
define("ANS4_10", "指");
define("ANS4_11", "その他");


// XSS
function h($value){
	if(empty($value)) return $value;
	return htmlspecialchars($value);
}







?>