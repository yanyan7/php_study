<?php
session_start();  //セッション開始

//require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once 'connect.php';

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // メールアドレスの入力チェック
    if (empty($_POST["email"])) {  // emptyは値が空のとき
        $errorMessage = 'メールアドレスが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        // 入力したメールアドレスを格納
        $email = $_POST["email"];

        try {
            // クエリ発行
            $obj = new connect();
            $sql = 'SELECT * FROM user WHERE email = ?';
            $param = $email;
            $stmt = $obj->plural($sql, $param);

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //if (password_verify($password, $row['password'])) {
                if ($password == $row['password']) {
                    session_regenerate_id(true);
                    $_SESSION["user"] = $row['id'];
                    header("Location: post/index.php");  // 投稿一覧画面へ遷移
                    //echo "認証成功、DBにデータあり";
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }

}

?>


<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="email">メールアドレス</label><input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
        <br>
        <form action="SignUp.php">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <input type="submit" value="新規登録">
            </fieldset>
        </form>
    </body>
</html>