<?php
//1. POSTデータ取得

$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'];
$id   = $_POST["id"];   //idを取得

//1.  DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=moriya_db;charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DBConnection Error:'.$e->getMessage());
  }

//３．データ登録SQL作成
$sql = "update gs_bm_table set name=:name, url=:url, comment=:comment where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
  }else{
    //５．index.phpへリダイレクト
    header("Location: index.php");
    exit();
  }

?>
