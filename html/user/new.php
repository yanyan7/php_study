<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu_bef_login.php');  // 未ログインの場合表示するヘッダ

// ログイン済みの場合
if( isset($_SESSION['user']) ){
  $class = "hide";  // 入力フォームを非表示にする
  echo "既にログイン済みです";
}else {
  $class = "";  // 入力フォームを表示する
}

// 重複エラー(createからの戻り)
$motoURL = $_SERVER['HTTP_REFERER'];
$errorURL = "http://localhost:8000/user/new.php?";

if($motoURL == $errorURL){
  echo "ユーザ名またはメールアドレスが既に登録されています";
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
      <script type="text/javascript">
        const confirm = () => {
          if(!chkName()){
            alert("ユーザ名を入力して下さい");
            return false;
          }

          if(!chkEmail()){
            alert("メールアドレスを入力して下さい");
            return false;
          }

          if(!chkPass()){
            alert("パスワードを入力して下さい");
            return false;
          }

          if(!window.confirm("登録してよろしいですか?")){
            return false;
          }

          return true;
        }

        //ユーザ名空欄チェック
        const chkName = () => {
          const obj = document.getElementById("name");
          if(!obj.value){
            return false;
          }
          return true;
        }

        //メールアドレス空欄チェック
        const chkEmail = () => {
          const obj = document.getElementById("email");
          if(!obj.value){
            return false;
          }
          return true;
        }

        //パスワード空欄チェック
        const chkPass = () => {
          const obj = document.getElementById("password");
          if(!obj.value){
            return false;
          }
          return true;
        }
      </script>
    </head>

    <body>
        <form id="userNew" name="userNew" action="create.php" method="post" class="<?php echo $class ?>">
            <p><label for="name">ユーザ名</label></p>
            <input type="text" id="name" name="name">

            <p><label for="email">メールアドレス</label></p>
            <input type="text" id="email" name="email">

            <p><label for="password">パスワード</label></p>
            <input type="password" id="password" name="password">

            <p><input type="submit" id="create_user" name="create_user" value="登録" onclick="return confirm()"></p>
        </form>
    </body>


</html>
