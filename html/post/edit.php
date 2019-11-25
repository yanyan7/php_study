<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){

  if( isset($_POST['upd_post']) ){
      // 更新ボタンが押された場合
      $obj0 = new connect();

      $sql_0 =  'UPDATE ';
      $sql_0 .= '   post ';
      $sql_0 .= 'set ';
      $sql_0 .= '   title = ? ';
      $sql_0 .= '   ,content = ? ';
      $sql_0 .= 'WHERE ';
      $sql_0 .=     'id = ? ';

      $param_0 = array($_POST['title'], $_POST['content'], $_POST['post_id']);
      $ret = $obj0->plural($sql_0, $param_0);
  }

    try{
        // 1. 投稿情報取得
        // クエリ発行
        $obj = new connect();

        $sql =  'SELECT ';
        $sql .=     'id as post_id ';
        $sql .=     ',title ';
        $sql .=     ',content ';
        $sql .= 'FROM ';
        $sql .=     'post ';
        $sql .= 'WHERE ';
        $sql .=     'id = ? ';

        $param = array($_POST['post_id']);
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
      <title>投稿編集</title>
      <script type="text/javascript">
        function submit(formName){
          var target = document.getElementById(formName);
          target.submit();
          //alert("aa");
        }
      </script>
    </head>

    <body>
      <form id="updPost" name="updPost" action="" method="post">
          <p><label for="post_id">投稿ID</label></p>
          <input type="text" id="post_id" name="post_id" value="<?php echo $row['post_id'] ?>">

          <p><label for="title">タイトル</label></p>
          <input type="text" id="title" name="title" value="<?php echo $row['title'] ?>">

          <p><label for="content">本文</label></p>
          <textarea name="content" id="content" cols="30" rows="10"><?php echo $row['content'] ?></textarea>

          <p><input type="submit" id="upd_post" name="upd_post" value="更新"></p>
      </form>

    </body>


</html>
