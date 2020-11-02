<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu.php');

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title>投稿作成</title>
      <link rel="stylesheet" href="/style/style.css">
      <script type="text/javascript">
        const confirm = () => {
          if(!chkTitle()){
            alert("タイトルを入力して下さい");
            return false;
          }

          if(!chkContent()){
            alert("本文を入力して下さい");
            return false;
          }

          if(!window.confirm("投稿してよろしいですか?")){
            return false;
          }

          return true;
        }

        //タイトル空欄チェック
        const chkTitle = () => {
          const obj = document.getElementById("title");
          if(!obj.value){
            return false;
          }
          return true;
        }

        //本文空欄チェック
        const chkContent = () => {
          const obj = document.getElementById("content");
          if(!obj.value){
            return false;
          }
          return true;
        }
      </script>
    </head>

    <body>
      <form id="postNew" name="postNew" action="create.php" method="post">
          <p><label for="title">タイトル</label></p>
          <input type="text" id="title" name="title">

          <p><label for="content">本文</label></p>
          <textarea name="content" id="content" cols="100" rows="20"></textarea>

          <p><input type="submit" id="create_post" name="create_post" value="投稿" onclick="return confirm()"></p>
      </form>

    </body>


</html>
