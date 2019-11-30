<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu.php');

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){
    try{
        if( isset($_POST['create_post']) ){
            // 投稿ボタンが押された場合
            $obj = new connect();

            $sql =  'INSERT INTO ';
            $sql .= 'post ';
            $sql .= 'VALUES( ';
            $sql .= '   0 ';   // 自動採番
            $sql .= '   ,? ';
            $sql .= '   ,? ';
            $sql .= '   ,? ';
            $sql .= ') ';

            $param = array($_POST['title'], $_POST['content'], $_SESSION['user']);
            $ret = $obj->plural($sql, $param);
        }
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
      <title>投稿作成</title>
      <script type="text/javascript">
        function submit(formName){
          var target = document.getElementById(formName);
          target.submit();
          //alert("aa");
        }
      </script>
    </head>

    <body>
      <form id="CreatePost" name="CreatePost" action="" method="post">
          <p><label for="title">タイトル</label></p>
          <input type="text" id="title" name="title">

          <p><label for="content">本文</label></p>
          <textarea name="content" id="content" cols="30" rows="10"></textarea>

          <p><input type="submit" id="create_post" name="create_post" value="投稿"></p>
      </form>

    </body>


</html>
