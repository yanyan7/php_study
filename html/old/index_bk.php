<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){
    try{
/*
        // 1. 投稿情報取得
        // クエリ発行
        $obj = new connect();
        $sql = 'SELECT * FROM post WHERE user_id = ?';
        $param = $_SESSION['user'];
        $stmt = $obj->plural($sql, $param);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // データあり
            $post_id = $row['post_id'];
            $title = $row['title'];
        } else {
            // 該当データなし
            $errorMessage = '投稿データなし';
        }        

        // 2. ユーザ情報取得
        // クエリ発行
        $obj = new connect();
        $sql = 'SELECT * FROM user WHERE id = ?';
        $param = $_SESSION['user'];
        $stmt = $obj->plural($sql, $param);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // データあり
            $name = $row['name'];
            $image = $row['image'];
            $user_id = $_SESSION['user'];
        } else {
            // 該当データなし
            $errorMessage = 'ユーザーデータなし';
        }
*/

        // クエリ発行
        $obj = new connect();
        $sql =  'SELECT ';
        $sql .=     'p.id as post_id ';
        $sql .=     ',p.title as title ';
        $sql .=     ',u.name as name ';
        $sql .=     ',u.image as image ';
        $sql .= 'FROM ';
        $sql .=     'post p ';
        $sql .= 'left join ';
        $sql .=     'user u ';
        $sql .=     'on ';
        $sql .=     'p.user_id = u.id ';
        $sql .= 'WHERE ';
        $sql .=     'u.id = ?';

        $param = $_SESSION['user'];
        $stmt = $obj->plural($sql, $param);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // データあり
            $post_id = $row['post_id'];
            $title = $row['title'];
            $name = $row['name'];
            $image = $row['image'];
            $user_id = $_SESSION['user'];
        } else {
            // 該当データなし
            $errorMessage = 'ユーザーデータなし';
        }
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
    </head>
    <body>
        <p>ユーザのイメージ</p>
        <input type="text" id="image" name="image" value="<?php echo $image ?>">
        <p>投稿のタイトル</p>
        <input type="text" id="title" name="title" value="<?php echo $title ?>">
        <p>ユーザの名前</p>
        <input type="text" id="name" name="name" value="<?php echo $name ?>">
        <p>投稿ID（非表示にする）</p>
        <form id="post" name="post" action="show.php" method="post">
            <input type="text" id="post_id" name="post_id" value="<?php echo $post_id ?>">
        </form>
        <p>ユーザID（非表示にする）</p>
        <form id="user" name="user" action="../user.php" method="post">
            <input type="text" id="user_id" name="user_id" value="<?php echo $user_id ?>">
        </form>
    </body>


</html>