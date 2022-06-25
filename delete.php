<?php
//1. データ取得
$id   = $_GET["id"];

//2. DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=moriya19_moriya_db;charset=utf8;host=mysql57.moriya19.sakura.ne.jp', 'moriya19' ,'moriya19_');
  } catch (PDOException $e) {exit('DBConnection Error:'.$e->getMessage());};
  

//３．データ削除SQL作成
$sql = "delete from gs_bm_table where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}

?>
