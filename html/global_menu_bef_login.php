<?php
session_start();  //セッション開始

require_once 'connect.php';

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {

    // 入力チェック
    if (empty($_POST["email_gb"])) {

        $errorMessage = 'メールアドレスが未入力です。';
        echo $errorMessage;

    } else if (empty($_POST["password_gb"])) {

        $errorMessage = 'パスワードが未入力です。';
        echo $errorMessage;
    }


    //存在チェック
    if (!empty($_POST["email_gb"]) && !empty($_POST["password_gb"])) {

        $email_gb = $_POST["email_gb"];

        try {
            // メールアドレス検索
            $obj = new connect();
            $sql = 'SELECT * FROM user WHERE email = ?';
            $param = array($email_gb);
            $stmt = $obj->plural($sql, $param);

            $password_gb = $_POST["password_gb"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // 該当メールアドレスあり

                if ($password_gb == $row['password']) {
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
            <title>ログイン</title>
    </head>
    <body>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <legend>ログイン</legend>
            <label for="email_gb">メールアドレス</label><input type="text" id="email_gb" name="email_gb" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email_gb"])) {echo htmlspecialchars($_POST["email_gb"], ENT_QUOTES);} ?>">
            <br>
            <label for="password_gb">パスワード</label><input type="password_gb" id="password_gb" name="password_gb" value="" placeholder="パスワードを入力">
            <br>
            <input type="submit" id="login" name="login" value="ログイン">
        </form>
        <br>
        <form action="/user/new.php" method="get">
            <legend>新規登録</legend>
            <input type="submit" value="新規登録">
        </form>
        <br>
        <form id="toTop" name="toTop" action="<?php echo '/post/index.php' ?>" method="post">
          <input type="submit" id="top" name="top" value="トップに戻る">
        </form>
        <p>***************************************************</p>
    </body>
</html>
