<?php

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

  try{
      // クエリ発行
      $obj = new connect();

      $sql_c =  'SELECT ';
      $sql_c .=     'u.id as user_id ';
      $sql_c .=     ',u.name ';
      $sql_c .=     ',c.id as comment_id ';
      $sql_c .=     ',c.content ';
      $sql_c .= 'FROM ';
      $sql_c .=     'comment c ';
      $sql_c .= 'LEFT JOIN ';
      $sql_c .=     'user u ';
      $sql_c .=     'ON ';
      $sql_c .=     'c.user_id = u.id ';
      $sql_c .= 'WHERE ';
      $sql_c .= '   c.post_id = ? ';

      $param_c = array($_GET['post_id']);
      $stmt_c = $obj->plural($sql_c, $param_c);

  }catch(PDOException $e){
      $errorMessage = 'データベースエラー';
      //$errorMessage = $sql;
      // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
      // echo $e->getMessage();
  }

?>


<?php foreach($rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC) as $row_c): ?>
    <form id="userShow" name="userShow" action="../user/show.php" method="post">
        <table>
        <tr>
            <td><label for="user_id">コメント投稿ユーザID</label></td>
            <td><input type="text" id="user_id" name="user_id" value="<?php echo $row_c['user_id'] ?>"></td>
        </tr>
        <tr>
            <td><label for="name">コメント投稿ユーザ名</label></td>
            <td>
            <input type="text" id="name" name="name" value="<?php echo $row_c['name'] ?>"
            onclick="submit('userShow')">
            </td>
        </tr>
        <tr>
            <td><label for="content">コメント</label></td>
            <td>
            <textarea name="content" id="content" cols="30" rows="10"><?php echo $row_c['content'] ?></textarea>
            </td>
        </tr>
        </table>
    </form>

    <?php if( isset($_SESSION['user']) && $_SESSION['user']==$row_c['user_id'] ): ?>
        <!-- ログイン済みかつ、コメント投稿ユーザがログインユーザと一致する場合は編集可能 -->
        <form id="commentEdit" name="commentEdit" action="../comment/edit.php" method="get">
            <input type="hidden" id="comment_id" name="comment_id" value="<?php echo $row_c['comment_id'] ?>">
            <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
            <button type="button" id="c_edit" name="c_edit" onclick="submit('commentEdit')">編集する</button>
        </form>
    <?php endif ?>

    <p>---------------------------------------------------------</p>
<?php endforeach ?>

<?php if( isset($_SESSION['user']) && $_SESSION['user']!=$row_p['user_id'] ): ?>
    <!-- ログイン済みかつ、投稿ユーザがログインユーザと異なる場合は投稿可能 -->
    <form id="commentNew" name="commentNew" action="../comment/create.php" method="post">
        <p>コメント投稿欄</p>
        <textarea name="comment_input" id="comment_input" cols="30" rows="10"></textarea>
        <input type="submit" id="ins_comment" name="ins_comment" value="投稿">
        <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
    </form>
<?php endif ?>