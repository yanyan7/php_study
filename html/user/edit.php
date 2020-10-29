<?php
session_start();  //セッション開始

require_once '../connect.php';
include('../global_menu.php');

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){

    try{
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

        $param = array($_GET['user_id']);
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
        const confirm = () => {
          if(!window.confirm("更新してよろしいですか?")){
            return false;
          }
        }
      </script>
    </head>

    <body>
      <form id="userEdit" name="userEdit" action="update.php" method="post">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>">

          <p><label for="name">ユーザ名</label></p>
          <input type="text" id="name" name="name" value="<?php echo $row['name'] ?>">

          <p><label for="email">メールアドレス</label></p>
          <input type="text" id="email" name="email" value="<?php echo $row['email'] ?>">

          <p><label for="password">パスワード</label></p>
          <input type="text" id="password" name="password" value="<?php echo $row['password'] ?>">

          <p><label for="introduction">自己紹介文</label></p>
          <textarea name="introduction" id="introduction" cols="30" rows="10"><?php echo $row['introduction'] ?></textarea>

          <p><input type="submit" id="upd_user" name="upd_user" value="更新" onclick="return confirm()"></p>
      </form>

    </body>


</html>
