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
      <link rel="stylesheet" href="/style/style.css">
      <script type="text/javascript">
        //入力チェック(削除)
        const confirm = (form) => {
          if(!window.confirm("削除してよろしいですか?")){
            return false;
          }
          form.submit();
        }

        //コメント入力チェック
        const confComNew = () => {
          if(!chkComment()){
            alert("コメントを入力して下さい");
            return false;
          }

          if(!window.confirm("投稿してよろしいですか?")){
            return false;
          }

          return true;
        }

        //コメント空欄チェック
        const chkComment = () => {
          const obj = document.getElementById("comment_input");
          if(!obj.value){
            return false;
          }
          return true;
        }
      </script>
    </head>

    <body>
      <?php if( isset($_SESSION['user']) && $_SESSION['user']==$row_p['user_id'] ): ?>
        <!-- ログイン済みかつ、投稿ユーザがログインユーザと一致する場合は編集可能 -->
        <form id="postEdit" name="postEdit" action="edit.php" method="get" class="btn-PS-layout btn-PS-space">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
          <button type="button" id="edit" name="edit" onclick="submit('postEdit')">編集する</button>
        </form>

        <!-- ログイン済みかつ、投稿ユーザがログインユーザと一致する場合は削除可能 -->
        <form id="postDestroy" name="postDestroy" action="destroy.php" method="post" class="btn-PS-layout">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">
          <button type="button" id="destroy" name="destroy" onclick="return confirm(postDestroy)">削除する</button>
        </form>
      <?php endif ?>

      <form id="userShow" name="userShow" action="../user/show.php" method="get">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $row_p['user_id'] ?>">
       
        <p class="subtitle space-PS-subtitle">
          <span>@ </span>
          <input type="text" id="name" name="name" class="show-only link"
                  value="<?php echo $row_p['name'] ?>" onclick="submit('userShow')">
        </p>

        <input type="text" id="title" name="title" class="show-only title font-PS-title space-PS-title"
                value="<?php echo $row_p['title'] ?>" readonly>
        
        <!-- <input type="text" id="content" name="content" class="show-only font-PS-sentence space-PS-sentence"
                value="<?php echo $row_p['content'] ?>"> -->
        <textarea name="content" id="content" cols="100" rows="20" class="show-only" readonly><?php echo $row_p['content'] ?></textarea>
      </form>

      <hr>

      <!-- コメント一覧 -->
      <?php include('../comment/index.php'); ?>

    </body>
</html>
