<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu_bef_login.php');  // 未ログインの場合表示するヘッダ

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){
  // ログイン済みの場合
  $class = "hide";  // 入力フォームを非表示にする
  echo "既にログイン済みです";

}else {
  $class = "";  // 入力フォームを表示する
}

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title>ユーザー作成</title>
      <style>
        .hide{display: none;}
      </style>
    </head>

    <body>
        <form id="userNew" name="userNew" action="create.php" method="post" class="<?php echo $class ?>">
            <p><label for="name">ユーザ名</label></p>
            <input type="text" id="name" name="name">

            <p><label for="email">メールアドレス</label></p>
            <input type="text" id="email" name="email">

            <p><label for="password">パスワード</label></p>
            <input type="password" id="password" name="password">

            <p><input type="submit" id="create_user" name="create_user" value="登録"></p>
        </form>
    </body>


</html>
