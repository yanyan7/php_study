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

    try{
        if( isset($_POST['create_user']) ){
            // 投稿ボタンが押された場合

            // userテーブルに登録
            $obj = new connect();

            $sql =  'INSERT INTO ';
            $sql .= 'user ';
            $sql .= 'VALUES( ';
            $sql .= '   0 ';   // 自動採番
            $sql .= '   ,? ';
            $sql .= '   ,? ';
            $sql .= '   ,? ';
            $sql .= '   ,? ';
            $sql .= '   ,NULL ';
            $sql .= ') ';

            $param = array($_POST['name'], $_POST['email'], $_POST['password'], $_POST['introduction']);
            $ret = $obj->plural($sql, $param);

            // 登録したユーザ情報でログインする
            $sql_1 =  'SELECT ';
            $sql_1 .= '   id as user_id ';
            $sql_1 .= 'FROM ';
            $sql_1 .= '   user ';
            $sql_1 .= 'WHERE ';
            $sql_1 .= '   name = ? ';

            $param_1 = array($_POST['name']);
            $stmt = $obj->plural($sql_1, $param_1);
            $items = $stmt->fetch(PDO::FETCH_ASSOC);

            session_regenerate_id(true);
            $_SESSION["user"] = $items['user_id'];
            header("Location: ../post/index.php");  // 投稿一覧画面へ遷移
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
      <title>ユーザー作成</title>
      <script type="text/javascript">
        function submit(formName){
          var target = document.getElementById(formName);
          target.submit();
          //alert("aa");
        }
      </script>
      <style>
        .hide{display: none;}
      </style>
    </head>

    <body>
        <form id="CreateUser" name="CreateUser" action="" method="post" class="<?php echo $class ?>">
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
