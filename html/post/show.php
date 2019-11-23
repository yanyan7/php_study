<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){
    try{

        // 1. 投稿情報取得
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

        $param_p = $_POST['post_id'];
        $stmt_p = $obj->plural($sql_p, $param_p);
        $row_p = $stmt_p->fetch(PDO::FETCH_ASSOC);

        // 2. コメント情報取得
        // クエリ発行
        //$obj = new connect();

        $sql_c =  'SELECT ';
        $sql_c .=     'u.id as user_id ';
        $sql_c .=     ',u.name ';
        $sql_c .=     ',c.content ';
        $sql_c .= 'FROM ';
        $sql_c .=     'comment c ';
        $sql_c .= 'LEFT JOIN ';
        $sql_c .=     'user u ';
        $sql_c .=     'ON ';
        $sql_c .=     'c.user_id = u.id ';
        $sql_c .= 'WHERE ';
        $sql_c .= '   c.post_id = ? ';

        $param_c = $_POST['post_id'];
        $stmt_c = $obj->plural($sql_c, $param_c);

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
      <title>投稿一覧</title>
      <script type="text/javascript">
        function submit(formName){
          var target = document.getElementById(formName);
          target.submit();
          //alert("aa");
        }
      </script>
    </head>

    <body>
      <form id="postUser" name="commentUser" action="../user/show.php" method="post">
        <table>
          <tr>
            <td><label for="user_id">投稿ユーザID</label></td>
            <td><input type="text" id="user_id" name="user_id" value="<?php echo $user_id = $row_p['user_id'] ?>"></td>
          </tr>
          <tr>
            <td><label for="name">投稿ユーザ名</label></td>
            <td>
              <input type="text" id="name" name="name" value="<?php echo $name = $row_p['name'] ?>"
              onclick="submit('postUser')">
            </td>
          </tr>
          <tr>
            <td><label for="title">タイトル</label></td>
            <td><input type="text" id="title" name="title" value="<?php echo $title = $row_p['title'] ?>"></td>
          </tr>
          <tr>
            <td><label for="content">本文</label></td>
            <td><input type="text" id="content" name="content" value="<?php echo $content = $row_p['content'] ?>"></td>
          </tr>
          <tr>
            <td>********************</td>
            <td>****************************************</td>
          </tr>
        </table>
      </form>

      <?php foreach($rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC) as $row_c): ?>
        <form id="commentUser" name="commentUser" action="../user/show.php" method="post">
          <table>
            <tr>
              <td><label for="user_id">コメント投稿ユーザID</label></td>
              <td><input type="text" id="user_id" name="user_id" value="<?php echo $user_id = $row_c['user_id'] ?>"></td>
            </tr>
            <tr>
              <td><label for="name">コメント投稿ユーザ名</label></td>
              <td>
                <input type="text" id="name" name="name" value="<?php echo $name = $row_c['name'] ?>"
                onclick="submit('commentUser')">
              </td>
            </tr>
            <tr>
              <td><label for="content">コメント</label></td>
              <td><input type="text" id="content" name="content" value="<?php echo $content = $row_c['content'] ?>"></td>
            </tr>
            <tr>
              <td>--------------------</td>
              <td>----------------------------------------</td>
            </tr>
          </table>
        </form>
      <?php endforeach ?>
    </body>


</html>
