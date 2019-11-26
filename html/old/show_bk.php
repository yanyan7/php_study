<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){
    try{
        /*
        ユーザ名、タイトル、本文
        select
          u.name
          ,u.name
          ,p.content
        from
          post p
        left join
          user u
        on
          p.user_id = u.id
        where
          user_id = $_SESSION['user']
        */

        // クエリ発行
        $obj = new connect();

        $sql =  'SELECT ';
        $sql .=     'u.id as user_id ';
        $sql .=     ',u.name ';
        $sql .=     ',c.content ';
        $sql .= 'FROM ';
        $sql .=     'comment c ';
        $sql .= 'LEFT JOIN ';
        $sql .=     'user u ';
        $sql .=     'ON ';
        $sql .=     'c.user_id = u.id ';
        $sql .= 'WHERE ';
        $sql .= '   c.post_id = ? ';

        $param = $_POST['post_id'];
        $stmt = $obj->plural($sql, $param);

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
      <?php foreach($rows = $stmt->fetchAll(PDO::FETCH_ASSOC) as $row): ?>
        <table>
          <form id="commentUser" name="commentUser" action="../user/show.php" method="post">
            <tr>
              <td><label for="name">コメント投稿ユーザID</label></td>
              <td><input type="text" id="user_id" name="user_id" value="<?php echo $name = $row['user_id'] ?>"></td>
            </tr>
            <tr>
              <td><label for="name">コメント投稿ユーザ名</label></td>
              <td>
                <input type="text" id="name" name="name" value="<?php echo $name = $row['name'] ?>"
                onclick="submit('commentUser')">
              </td>
            </tr>
          </form>
          <tr>
            <td><label for="name">コメント</label></td>
            <td><input type="text" id="content" name="content" value="<?php echo $name = $row['content'] ?>"></td>
          </tr>
          <tr>
            <td>--------------------</td>
            <td>----------------------------------------</td>
          </tr>
        </table>
      <?php endforeach ?>
    </body>


</html>
