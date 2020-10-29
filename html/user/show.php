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
    $sql .=     'user u ';
    $sql .= 'left join ';
    $sql .=     'post p ';
    $sql .=     'on ';
    $sql .=     ' u.id = p.user_id ';
    $sql .= 'WHERE ';
    $sql .=     'u.id = ? ';

    $param = array($_GET['user_id']);
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
    </head>
    <body>
        <table>
            <tr>
                <td><label for="user_id">ユーザID</label></td>
                <td><input type="text" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>"></td>
            </tr>
            <tr>
                <td><label for="name">ユーザの名前</label></td>
                <td>
                    <input type="text" id="name" name="name" value="<?php echo $items[0]['name'] ?>">
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

        <?php if( isset($_SESSION['user']) && $_SESSION['user']==$items[0]['user_id'] ): ?>
            <form id="userEdit" name="userEdit" action="edit.php" method="get">
                <!-- ログイン済みかつ、ユーザがログインユーザと一致する場合は編集可能 -->
                <button type="button" id="edit" name="edit" onclick="submit('userEdit')">編集する</button>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>">
            </form>

            <form id="userDestroy" name="userDestroy" action="destroy.php" method="post">
                <!-- ログイン済みかつ、ユーザがログインユーザと一致する場合は削除可能 -->
                <button type="button" id="destroy" name="destroy" onclick="submit('userDestroy')">削除する</button>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>">
            </form>
        <?php endif ?>

        <p>************************************************************************</p>

        <?php if($items[0]['post_id']): ?>
            <!-- 投稿がある場合は表示する -->
            <?php foreach($items as $row): ?>
                <table>
                    <tr>
                        <td><label for="user_id">ユーザID</label></td>
                        <td><input type="text" id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="name">ユーザの名前</label></td>
                        <td>
                            <input type="text" id="name" name="name" value="<?php echo $row['name'] ?>">
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td><label for="image">ユーザのイメージ</label></td>
                        <td><input type="text" id="image" name="image" value="<?php echo $row['image'] ?>"></td>
                    </tr>
                    -->
                <form id="postShow" name="postShow" action="../post/show.php" method="get">
                    <tr>
                        <td><label for="post_id">投稿ID</label></td>
                        <td><input type="text" id="post_id" name="post_id" value="<?php echo $row['post_id'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="title">投稿のタイトル</label></td>
                        <td>
                            <input type="text" id="title" name="title" value="<?php echo $row['title'] ?>"
                            onclick="submit('postShow')">
                        </td>
                    </tr>
                </table>

                <p>--------------------------------------------------------------------------------</p>
                </form>
            <?php endforeach ?>
        <?php endif ?>
    </body>


</html>
