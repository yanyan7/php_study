<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu.php');

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){

  if( isset($_POST['upd_user']) ){
      // 更新ボタンが押された場合
      $obj0 = new connect();

      $sql_0 =  'UPDATE ';
      $sql_0 .= '   user ';
      $sql_0 .= 'set ';
      $sql_0 .= '   name = ? ';
      $sql_0 .= '   ,email = ? ';
      $sql_0 .= '   ,password = ? ';
      $sql_0 .= '   ,introduction = ? ';
      $sql_0 .= 'WHERE ';
      $sql_0 .=     'id = ? ';

      $param_0 = array($_POST['name'], $_POST['email'], $_POST['password'], $_POST['introduction'], $_POST['user_id']);
      $ret = $obj0->plural($sql_0, $param_0);
  }

    try{
        // 1. 投稿情報取得
        // クエリ発行
        $obj = new connect();

        $sql =  'SELECT ';
        $sql .=     'id as user_id ';
        $sql .=     ',name ';
        $sql .=     ',email ';
        $sql .=     ',password ';
        $sql .=     ',introduction ';
        $sql .= 'FROM ';
        $sql .=     'user ';
        $sql .= 'WHERE ';
        $sql .=     'id = ? ';

        $param = array($_POST['user_id']);
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
      <title>ユーザー編集</title>
      <script type="text/javascript">
        function submit(formName){
          var target = document.getElementById(formName);
          target.submit();
          //alert("aa");
        }
      </script>
    </head>

    <body>
      <form id="updUser" name="updUser" action="" method="post">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>">

          <p><label for="name">ユーザ名</label></p>
          <input type="text" id="name" name="name" value="<?php echo $row['name'] ?>">

          <p><label for="email">メールアドレス</label></p>
          <input type="text" id="email" name="email" value="<?php echo $row['email'] ?>">

          <p><label for="password">パスワード</label></p>
          <input type="text" id="password" name="password" value="<?php echo $row['password'] ?>">

          <p><label for="introduction">パスワード</label></p>
          <textarea name="introduction" id="introduction" cols="30" rows="10"><?php echo $row['introduction'] ?></textarea>

          <p><input type="submit" id="upd_user" name="upd_user" value="更新"></p>
      </form>

    </body>


</html>
