<?php
session_start();  //セッション開始

require_once '../connect.php';

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

      $sql_p =  'SELECT ';
      $sql_p .=     'u.id as user_id ';
      $sql_p .=     ',u.name ';
      $sql_p .=     ',p.title ';
      $sql_p .=     ',p.content ';
      $sql_p .= 'FROM ';
      $sql_p .=     'post p ';
      $sql_p .= 'LEFT JOIN ';
      $sql_p .=     'user u ';
      $sql_p .=     'ON ';
      $sql_p .=     'p.user_id = u.id ';
      $sql_p .= 'WHERE ';
      $sql_p .= '   p.id = ? ';

      //$param_p = $_POST['post_id'];
      $param_p = array($_GET['post_id']);
      $stmt_p = $obj->plural($sql_p, $param_p);
      $row_p = $stmt_p->fetch(PDO::FETCH_ASSOC);

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
      <title>投稿表示</title>
    </head>

    <body>
      <form id="userShow" name="userShow" action="../user/show.php" method="get">
        <table>
          <tr>
            <td><label for="user_id">投稿ユーザID</label></td>
            <td><input type="text" id="user_id" name="user_id" value="<?php echo $row_p['user_id'] ?>"></td>
          </tr>
          <tr>
            <td><label for="name">投稿ユーザ名</label></td>
            <td>
              <input type="text" id="name" name="name" value="<?php echo $row_p['name'] ?>"
              onclick="submit('userShow')">
            </td>
          </tr>
          <tr>
            <td><label for="title">タイトル</label></td>
            <td><input type="text" id="title" name="title" value="<?php echo $row_p['title'] ?>"></td>
          </tr>
          <tr>
            <td><label for="content">本文</label></td>
            <td><textarea name="content" id="content" cols="30" rows="10"><?php echo $row_p['content'] ?></textarea></td>
          </tr>
        </table>
      </form>

      <?php if( isset($_SESSION['user']) && $_SESSION['user']==$row_p['user_id'] ): ?>
        <!-- ログイン済みかつ、投稿ユーザがログインユーザと一致する場合は編集可能 -->
        <form id="postEdit" name="postEdit" action="edit.php" method="get">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
          <button type="button" id="edit" name="edit" onclick="submit('postEdit')">編集する</button>
        </form>

        <!-- ログイン済みかつ、投稿ユーザがログインユーザと一致する場合は削除可能 -->
        <form id="postDestroy" name="postDestroy" action="destroy.php" method="post">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
          <button type="button" id="destroy" name="destroy" onclick="submit('postDestroy')">削除する</button>
        </form>
      <?php endif ?>

      <p>****************************************************</p>

      <!-- コメント一覧 -->
      <?php include('../comment/index.php'); ?>

    </body>
</html>
