<?php
// DB接続情報
include("funcs.php");
$pdo = db_con();

// POSTデータを受け取る
$name = $_POST["name"];
$url = $_POST["url"];
$comment = $_POST["comment"];

// try-catch
try{
	// // データベースへの接続を表すPDOインスタンスを生成
	// $pdo = new PDO($name,$url,$comment);

	// //  SQL文 :idは、名前付きプレースホルダ
	// $sql = "select * from gs_bm_table where name = :name";

	// // プリペアドステートメントを作成
	// $stmt = $pdo->prepare($sql);

	// // プレースホルダと変数をバインド
	// $stmt -> bindParam(":name",$name);
	// $stmt -> execute(); //実行
	$stmt = $pdo->prepare("SELECT FROM gs_bm_table(name, url, comment)VALUES(:name,:url,:comment)");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$status = $stmt->execute();

	// データを取得
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	$view .= '<tr><td>'.$rec["name"].'</td><td><a target=”_blank” href="https://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&url=search-alias%3Daps&field-keywords='.$rec["name"].'"</a>'.$rec["url"].'</td><td>'.$rec["comment"].'</td></tr>'; 
	// 接続を閉じる
	//$pdo = null; スクリプト終了時に自動で切断されるので不要
}catch (PDOException $e) {
	// UTF8に文字エンコーディングを変換します
	exit(mb_convert_encoding($e->getMessage(),'UTF-8','SJIS-win'));   
}
function escape1($str)
{
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>検索結果</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/assignment.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">検索結果</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <table class="container jumbotron">
    <tr class ="title">
    <th>本の名前</th>
    <th>本のURL（Amazon検索結果）</th>
    <th>コメント</th>
    <?=$rec?>
    </tr>
    </table>
</div>
<!-- Main[End] -->

</body>
</html>
