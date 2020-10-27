<?php

try{
    // ユーザ情報取得
    // クエリ発行
    $obj = new connect();

    $sql =  'SELECT ';
    $sql .=     'name ';
    $sql .= 'FROM ';
    $sql .=     'user ';
    $sql .= 'WHERE ';
    $sql .=     'id = ? ';

    $param = array($_SESSION['user']);
    $stmt = $obj->plural($sql, $param);
    $items = $stmt->fetch(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    $errorMessage = 'データベースエラー';
    //$errorMessage = $sql;
    // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
    // echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
    </title>
  </head>
  <body>
    <form id="postIndex" name="postIndex" action="<?php echo '/post/index.php' ?>" method="post">
      <input type="submit" id="top" name="top" value="トップに戻る">
    </form>

    <form id="logout" name="logout" action="<?php echo '/post/index.php' ?>" method="post">
      <input type="submit" id="logout" name="logout" value="ログアウト">
    </form>

    <form id="postNew" name="postNew" action="<?php echo '/post/new.php' ?>" method="post">
      <input type="submit" id="new" name="new" value="投稿する">
    </form>

    <form id="userShow" name="userShow" action="<?php echo $webroot.'/user/show.php' ?>" method="post">
      <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user'] ?>">
      <input type="text" id="name" name="name" value="<?php echo $items['name'] ?>">
    </form>

    <p>***************************************************</p>

  </body>
</html>
