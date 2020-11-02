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

<h3>コメント</h3>

<?php foreach($rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC) as $row_c): ?>

    <?php if( isset($_SESSION['user']) && $_SESSION['user']==$row_c['user_id'] ): ?>
        <!-- ログイン済みかつ、コメント投稿ユーザがログインユーザと一致する場合は編集可能 -->
        <form id="commentEdit" name="commentEdit" action="../comment/edit.php" method="get" class="btn-CI-layout btn-CI-space">
            <input type="hidden" id="comment_id" name="comment_id" value="<?php echo $row_c['comment_id'] ?>">
            <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
            <button type="button" id="c_edit" name="c_edit" onclick="submit('commentEdit')">編集する</button>
        </form>

        <!-- ログイン済みかつ、コメント投稿ユーザがログインユーザと一致する場合は削除可能 -->
        <form id="<?php echo 'commentDestroy' . $row_c['comment_id'] ?>" name="<?php echo 'commentDestroy' . $row_c['comment_id'] ?>"
                class="btn-CI-layout" action="../comment/destroy.php" method="post">
            <input type="hidden" id="comment_id" name="comment_id" value="<?php echo $row_c['comment_id'] ?>">
            <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
            <button type="button" id="c_destroy" name="c_destroy" 
                    onclick="return confirm(<?php echo 'commentDestroy' . $row_c['comment_id'] ?>)">削除する</button>
        </form>
    <?php endif ?>

    <form id="userShow" name="userShow" action="../user/show.php" method="get">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $row_c['user_id'] ?>">

        <p class="subtitle">
          <span>@ </span>
          <input type="text" id="name" name="name" class="show-only link space-PS-subtitle"
                  value="<?php echo $row_c['name'] ?>" onclick="submit('userShow')">
        </p>

        <input type="text" id="content" name="content" class="show-only font-CI-sentence"
                value="<?php echo $row_c['content'] ?>">

        <hr>

        <!-- <table>
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
        </table> -->
    </form>
<?php endforeach ?>

<?php if( isset($_SESSION['user']) && $_SESSION['user']!=$row_p['user_id'] ): ?>
    <!-- ログイン済みかつ、投稿ユーザがログインユーザと異なる場合は投稿可能 -->
    <form id="commentNew" name="commentNew" action="../comment/create.php" method="post">
        <p>投稿する</p>
        <textarea name="comment_input" id="comment_input" cols="30" rows="10"></textarea>
        <input type="submit" id="ins_comment" name="ins_comment" value="投稿" onclick="return confComNew()">
        <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
    </form>
<?php endif ?>