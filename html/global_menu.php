<?php

try{
    // ユーザ情報取得
    // クエリ発行
    $obj = new connect();

    $sql =  'SELECT ';
    $sql .=     'name ';
    $sql .= 'FROM ';
    $sql .=     'user ';
    $sql .= 'WHERE ';
    $sql .=     'id = ? ';

    $param = array($_SESSION['user']);
    $stmt = $obj->plural($sql, $param);
    $items = $stmt->fetch(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    $errorMessage = 'データベースエラー';
    //$errorMessage = $sql;
    // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
    // echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript">
      const confLogout = () => {
        if(!window.confirm("ログアウトしてよろしいですか?")){
          return false;
        }
      }
    </script>
  </head>
  <body>

    <ul class="menubar">
      <li class="menubar-item">
        <span class="menubar-icon">ようこそ</span>
      </li>
      <li class="menubar-item">
        <form id="postNew" name="postNew" action="<?php echo '/post/new.php' ?>" method="post">
          <input type="submit" id="new" name="new" class="menubar-btn link" value="投稿する">
        </form>
      </li>
      <li class="menubar-item">
        <form id="postIndex" name="postIndex" action="<?php echo '/post/index.php' ?>" method="get">
          <input type="submit" id="top" name="top" class="menubar-btn link" value="トップに戻る">
        </form>
      </li>
      <li class="menubar-item">
        <form id="logout" name="logout" action="<?php echo '/post/index.php' ?>" method="post">
          <input type="submit" id="logout" name="logout" value="ログアウト" class="menubar-btn link" onclick="return confLogout()">
        </form>
      </li>
      <li class="menubar-item">
        <form id="userShow" name="userShow" action="<?php echo $webroot.'/user/show.php' ?>" method="get">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user'] ?>">
          <input type="text" id="name" name="name" class="show-only link menubar-name"
                  value="<?php echo $items['name'] ?>" onclick="submit('userShow')">
        </form>
      </li>
    </ul>

    <hr>

  </body>
</html>
