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
    </head>

    <body>
      <form id="postNew" name="postNew" action="create.php" method="post">
          <p><label for="title">タイトル</label></p>
          <input type="text" id="title" name="title">

          <p><label for="content">本文</label></p>
          <textarea name="content" id="content" cols="30" rows="10"></textarea>

          <p><input type="submit" id="create_post" name="create_post" value="投稿"></p>
      </form>

    </body>


</html>
