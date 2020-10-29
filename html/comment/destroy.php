<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

//削除処理
$obj0 = new connect();

$sql_0 =  'DELETE ';
$sql_0 .= 'from ';
$sql_0 .= '   comment ';
$sql_0 .= 'WHERE ';
$sql_0 .=     'id = ? ';

$param_0 = array($_POST['comment_id']);
$ret = $obj0->plural($sql_0, $param_0);

?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title></title>
      <script type="text/javascript">
        window.onload = function() {
            const target = document.getElementById("commentDestroy");
            target.submit();
        };
      </script>
    </head>

    <body>
      <form id="commentDestroy" name="commentDestroy" action="../post/show.php" method="get">
          <input type="hidden" id="post_id" name="post_id" value="<?php echo $_POST['post_id'] ?>">
      </form>
    </body>
</html>

