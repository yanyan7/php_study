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

    $sql =  'SELECT ';
    $sql .=     'p.id as post_id ';
    $sql .=     ',p.title as title ';
    $sql .=     ',u.id as user_id ';
    $sql .=     ',u.name as name ';
    $sql .=     ',u.image as image ';
    $sql .=     ',u.introduction as introduction ';
    $sql .= 'FROM ';
    $sql .=     'post p ';
    $sql .= 'left join ';
    $sql .=     'user u ';
    $sql .=     'on ';
    $sql .=     'p.user_id = u.id ';
    $sql .= 'WHERE ';
    $sql .=     'u.id = ? ';

    $param = array($_POST['user_id']);
    $stmt = $obj->plural($sql, $param);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <title>ユーザー表示</title>
        <script type="text/javascript">
            function submit(formName){
                var target = document.getElementById(formName);
                target.submit();
            }
        </script>
    </head>
    <body>
        <form id="toUserEdit" name="toUserEdit" action="edit.php" method="post">
            <table>
                <tr>
                    <td><label for="user_id">ユーザID</label></td>
                    <td><input type="text" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="name">ユーザの名前</label></td>
                    <td>
                        <input type="text" id="name" name="name" value="<?php echo $items[0]['name'] ?>"
                        onclick="submit('user')">
                    </td>
                </tr>
                <!--
                <tr>
                    <td><label for="image">ユーザのイメージ</label></td>
                    <td><input type="text" id="image" name="image" value="<?php echo $items[0]['image'] ?>"></td>
                </tr>
                -->
                <tr>
                    <td><label for="introduction">自己紹介文</label></td>
                    <td><textarea name="introduction" id="introduction" cols="30" rows="10"><?php echo $items[0]['introduction'] ?></textarea></td>
                </tr>
            </table>
            <?php if( isset($_SESSION['user']) ): ?>
              <input type="submit" id="edit" name="edit" value="編集する">
            <?php endif ?>
            <p>************************************************************************</p>
        </form>

        <?php foreach($items as $row): ?>
            <form id="toPostShow" name="toPostShow" action="../post/show.php" method="post">
                <table>
                    <tr>
                        <td><label for="user_id">ユーザID</label></td>
                        <td><input type="text" id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="name">ユーザの名前</label></td>
                        <td>
                            <input type="text" id="name" name="name" value="<?php echo $row['name'] ?>"
                            onclick="submit('user')">
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td><label for="image">ユーザのイメージ</label></td>
                        <td><input type="text" id="image" name="image" value="<?php echo $row['image'] ?>"></td>
                    </tr>
                    -->
                    <tr>
                        <td><label for="post_id">投稿ID</label></td>
                        <td><input type="text" id="post_id" name="post_id" value="<?php echo $row['post_id'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="title">投稿のタイトル</label></td>
                        <td>
                            <input type="text" id="title" name="title" value="<?php echo $row['title'] ?>"
                            onclick="submit('toPostShow')">
                        </td>
                    </tr>
                </table>
                <p>--------------------------------------------------------------------------------</p>
            </form>
        <?php endforeach ?>
    </body>


</html>
