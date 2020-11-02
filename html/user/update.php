<?php
session_start();  //セッション開始

require_once '../connect.php';

// パスワードのハッシュ化
$hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

if( isset($_POST['upd_user']) ){
  // 更新ボタンが押された場合
  $obj0 = new connect();

  $sql_0 =  'UPDATE ';
  $sql_0 .= '   user ';
  $sql_0 .= 'set ';
  $sql_0 .= '   name = ? ';
  $sql_0 .= '   ,email = ? ';
  $sql_0 .= '   ,password = ? ';
  $sql_0 .= '   ,introduction = ? ';
  $sql_0 .= 'WHERE ';
  $sql_0 .=     'id = ? ';

  $param_0 = array($_POST['name'], $_POST['email'], $hash_pass, $_POST['introduction'], $_POST['user_id']);
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
            const target = document.getElementById("updPost");
            target.submit();
        };
      </script>
    </head>

    <body>
      <form id="updPost" name="updPost" action="show.php" method="get">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $_POST['user_id'] ?>">
      </form>
    </body>
</html>

