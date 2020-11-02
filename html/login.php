<?php
session_start();  //セッション開始

require_once 'connect.php';

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {

    //存在チェック
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

        $email = $_POST["email"];

        try {
            // メールアドレス検索
            $obj = new connect();
            $sql = 'SELECT * FROM user WHERE email = ?';
            $param = array($email);
            $stmt = $obj->plural($sql, $param);

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // 該当メールアドレスあり

                if(password_verify($password, $row['password'])) {    //復号化したパスワードと比較
                // 該当パスワードあり

                    session_regenerate_id(true);
                    $_SESSION["user"] = $row['id'];
                    header("Location: /post/index.php");  // 投稿一覧画面へ遷移
                    exit();  // 処理終了

                } else {
                // 該当パスワードなし

                    $errorMessage = 'メールアドレスあるいはパスワードに誤りがあります。';
                    echo $errorMessage;
                }

            } else {
            // 該当メールアドレスなし

                $errorMessage = 'メールアドレスあるいはパスワードに誤りがあります。';
                echo $errorMessage;
            }

        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
             echo $e->getMessage();
        }
    }
}

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title>ユーザー作成</title>
      <link rel="stylesheet" href="/style/style.css">
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
        <?php include('global_menu_bef_login.php'); ?>

        <form id="userNew" name="userNew" action="" method="post">
            <p><label for="name">ユーザ名</label></p>
            <input type="text" id="name" name="name">

            <p><label for="email">メールアドレス</label></p>
            <input type="text" id="email" name="email">

            <p><label for="password">パスワード</label></p>
            <input type="password" id="password" name="password">

            <!-- <p><label for="image">画像</label></p>
            <input type="file" id="image" name="image"> -->

            <p><input type="submit" id="login" name="login" value="ログイン" onclick="return confirm()"></p>
        </form>
    </body>


</html>
