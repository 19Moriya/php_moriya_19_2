<?php
//１．PHP
//select.phpの[PHPコードだけ！]をマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET["id"];
include("funcs.php");  //funcs.phpを読み込む（関数群）

//2. DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=moriya_db;charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DBConnection Error:'.$e->getMessage());
  }

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id"); //SQLをセット
$stmt->bindValue(':id',   $id,    PDO::PARAM_INT);
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
 //SQL成功の場合
 while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
  //以下でリンクの文字列を作成, $r["id"]でidをdetail.phpに渡しています
  $view .= '<a href="detail.php?id='.h($r["id"]).'">';
  $view .= h($r["id"])."|".h($r["name"]);
  $view .= '</a>';
  $view .= '<a href="delete.php?id='.h($r["id"]).'">';
  $view .= "[削除]<br>";
  $view .= '</a>';
}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
   <legend>ブックマークアプリ</legend>
     <label>書籍名<input type="text" name="name"></label><br>
     <label>URL<input type="text" name="url"></label><br>
     <label><textArea name="comment" rows="4" cols="40"></textArea></label><br>
     <!-- idを隠して送信 -->
     <input type="hidden" name="id" value="<?=$row["id"]?>">
     <!-- idを隠して送信 -->
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>




