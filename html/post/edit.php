<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu.php');

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){

    try{
        // クエリ発行
        $obj = new connect();

        $sql =  'SELECT ';
        $sql .=     'id as post_id ';
        $sql .=     ',title ';
        $sql .=     ',content ';
        $sql .= 'FROM ';
        $sql .=     'post ';
        $sql .= 'WHERE ';
        $sql .=     'id = ? ';

        $param = array($_GET['post_id']);
        $stmt = $obj->plural($sql, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        $errorMessage = 'データベースエラー';
        //$errorMessage = $sql;
        // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
        // echo $e->getMessage();
    }
}

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title>投稿編集</title>
    </head>

    <body>
      <form id="postEdit" name="postEdit" action="update.php" method="post">
          <p><label for="post_id">投稿ID</label></p>
          <input type="text" id="post_id" name="post_id" value="<?php echo $row['post_id'] ?>">

          <p><label for="title">タイトル</label></p>
          <input type="text" id="title" name="title" value="<?php echo $row['title'] ?>">

          <p><label for="content">本文</label></p>
          <textarea name="content" id="content" cols="30" rows="10"><?php echo $row['content'] ?></textarea>

          <p><input type="submit" id="upd_post" name="upd_post" value="更新"></p>
      </form>

    </body>


</html>
