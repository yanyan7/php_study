<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_POST['upd_comment']) ){
    // 更新ボタンが押された場合
    $obj0 = new connect();

    $sql_0 =  'UPDATE ';
    $sql_0 .= '   comment ';
    $sql_0 .= 'set ';
    $sql_0 .= '   content = ? ';
    $sql_0 .= 'WHERE ';
    $sql_0 .=     'id = ? ';

    $param_0 = array($_POST['content'], $_POST['comment_id']);
    $ret = $obj0->plural($sql_0, $param_0);
}

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title></title>
      <script type="text/javascript">
        window.onload = function() {
            const target = document.getElementById("commentUpd");
            target.submit();
        };
      </script>
    </head>

    <body>
      <form id="commentUpd" name="commentUpd" action="../post/show.php" method="get">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_POST['post_id'] ?>">
      </form>
    </body>
</html>

