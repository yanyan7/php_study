<?php
session_start();  //セッション開始

require_once '../connect.php';

if( isset($_POST['ins_comment']) ){
    // コメントが投稿された場合
    $obj0 = new connect();

    $sql_i = 'INSERT INTO ';
    $sql_i .= '   comment ';
    $sql_i .= '   VALUES( ';
    $sql_i .= '   0';    // id ※DB側で自動採番される
    $sql_i .= '   ,? ';  // content
    $sql_i .= '   ,? ';  // post_id
    $sql_i .= '   ,? ';  // user_id
    $sql_i .= '   ) ';

    $param_i = array($_POST['comment_input'], $_POST['post_id'], $_SESSION['user']);
    $ret = $obj0->plural($sql_i, $param_i);
  }

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title></title>
      <script type="text/javascript">
        window.onload = function() {
            const target = document.getElementById("commentCreate");
            target.submit();
        };
      </script>
    </head>

    <body>
      <form id="commentCreate" name="commentCreate" action="../post/show.php" method="get">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_POST['post_id'] ?>">
      </form>
    </body>
</html>
