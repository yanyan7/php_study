<?php
session_start();  //セッション開始

require_once '../connect.php';

if( isset($_POST['logout']) ){
  // ログアウトが押された場合
  $_SESSION = array();
  session_destroy();
}

if( isset($_SESSION['user']) ){
    // ログイン済みの場合表示するヘッダ
    include('../global_menu.php');
}else{
    // 未ログインの場合表示するヘッダ
    include('../global_menu_bef_login.php');
}

// エラーメッセージの初期化
$errorMessage = "";

  try{
      // クエリ発行
      $obj = new connect();

      $sql =  'SELECT ';
      $sql .=     'p.id as post_id ';
      $sql .=     ',p.title as title ';
      $sql .=     ',u.id as user_id ';
      $sql .=     ',u.name as name ';
      $sql .=     ',u.image as image ';
      $sql .= 'FROM ';
      $sql .=     'post p ';
      $sql .= 'left join ';
      $sql .=     'user u ';
      $sql .=     'on ';
      $sql .=     'p.user_id = u.id ';

      $items = $obj->select($sql);

  }catch(PDOException $e){
      $errorMessage = 'データベースエラー';
      //$errorMessage = $sql;
      // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
      // echo $e->getMessage();
  }

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>投稿一覧</title>
        <link rel="stylesheet" href="/style/style.css">
    </head>
    <body>
        <?php foreach($items as $row): ?>

            <form id="postShow" name="postShow" action="show.php" method="get" class="form-PI-1">
                <input type="hidden" id="post_id" name="post_id" value="<?php echo $post_id = $row['post_id'] ?>">

                <input type="text" id="title" name="title" class="show-only link title font-PI-title"
                        value="<?php echo $title = $row['title'] ?>" onclick="submit('postShow')">
            </form>

            <form id="userShow" name="userShow" action="../user/show.php" method="get" class="form-PI-2">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id = $row['user_id'] ?>">

                <p class="subtitle font-PI-subtitle">
                    <span>&nbsp;by </span>
                    <input type="text" id="name" name="name" class="show-only link"
                            value="<?php echo $name = $row['name'] ?>" onclick="submit('userShow')">
                </p>

                <!-- <label for="image">ユーザのイメージ</label>
                <input type="text" id="image" name="image" value="<?php echo $image = $row['image'] ?>"> -->
            </form>

            <hr>

        <?php endforeach ?>
    </body>
</html>
