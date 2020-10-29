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
        $sql .=     'id as comment_id ';
        $sql .=     ',content ';
        $sql .= 'FROM ';
        $sql .=     'comment ';
        $sql .= 'WHERE ';
        $sql .=     'id = ? ';

        $param = array($_GET['comment_id']);
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
      <title>コメント編集</title>
      <script type="text/javascript">
        const confirm = () => {
          if(!window.confirm("更新してよろしいですか?")){
            return false;
          }
        }
      </script>
    </head>

    <body>
      <form id="commentEdit" name="commentEdit" action="update.php" method="post">
          <p><label for="comment_id">コメントID</label></p>
          <input type="text" id="comment_id" name="comment_id" value="<?php echo $row['comment_id'] ?>">

          <p><label for="content">コメント</label></p>
          <textarea name="content" id="content" cols="30" rows="10"><?php echo $row['content'] ?></textarea>

          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET['post_id'] ?>">

          <p><input type="submit" id="upd_comment" name="upd_comment" value="更新" onclick="return confirm()"></p>
      </form>

    </body>


</html>
