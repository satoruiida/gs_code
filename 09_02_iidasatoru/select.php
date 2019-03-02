<?php

session_start();
//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
include "funcs.php";
sessChk();

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("errorSQL:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    // $view .= '<tr><td>'.$res["name"].'</td><td>'.$res["url"].'</td><td>'.$res["comment"].'</td></tr>'; 
    $view .='<tr><td><a href ="detail.php?id='.$res["id"].'">'.$res["name"].'</a></td><td><a target=”_blank” href="https://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&url=search-alias%3Daps&field-keywords='.$res["name"].'"</a>ここをクリック</td><td>'.$res["comment"].'</td>'; 
    $view .='<td><a href ="delete.php?id='.$res["id"].'">[ 削除 ]</a></td></tr>';; //？はここまでがURLというサイン
  
  }
}

?>

<!-- .=は上書きせず、後ろにデータを加えていく -->


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク</title>
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
      <a class="navbar-brand" href="index.php">ブックマーク</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="search">
  <p>キーワード検索は以下から</p>
  <a href="search.php">検索ページへ移動</a>
  <br>
</div>
<div>
    <table class="container jumbotron">
    <tr class ="title">
    <th>本の名前</th>
    <th>本のURL（Amazon検索結果）</th>
    <th>コメント</th>
    <th>削除</th>
    <?=$view?>
    </tr>
    </table>
</div>
<!-- Main[End] -->

</body>
</html>
