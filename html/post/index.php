<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_SESSION['user']) ){
    try{
        // クエリ発行
        $obj = new connect();

        $sql =  'SELECT ';
        $sql .=     'p.id as post_id ';
        $sql .=     ',p.title as title ';
        $sql .=     ',u.id as user_id ';
        $sql .=     ',u.name as name ';
        $sql .=     ',u.image as image ';
        $sql .= 'FROM ';
        $sql .=     'post p ';
        $sql .= 'left join ';
        $sql .=     'user u ';
        $sql .=     'on ';
        $sql .=     'p.user_id = u.id ';

        $items = $obj->select($sql);

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
        <form id="tmpToPostCreate" name="tmpToPostCreate" action="create.php" method="post">
            <p><button type="submit" id="post_create" name="post_create">投稿する（暫定の配置）</button></p>
        </form>

        <form id="tmpLogout" name="tmpLogout" action="../login.php" method="post">
            <p><button type="submit" id="logout" name="logout">ログアウト（暫定の配置）</button></p>
        </form>

        <?php foreach($items as $row): ?>
            <form id="toUserShow" name="toUserShow" action="../user/show.php" method="post">
                <table>
                    <tr>
                        <td><label for="user_id">ユーザID</label></td>
                        <td><input type="text" id="user_id" name="user_id" value="<?php echo $user_id = $row['user_id'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="name">ユーザの名前</label></td>
                        <td>
                            <input type="text" id="name" name="name" value="<?php echo $name = $row['name'] ?>"
                            onclick="submit('toUserShow')">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="image">ユーザのイメージ</label></td>
                        <td><input type="text" id="image" name="image" value="<?php echo $image = $row['image'] ?>"></td>
                    </tr>
                </table>
            </form>
            <form id="toPostShow" name="toPostShow" action="show.php" method="post">
                <table>
                    <tr>
                        <td><label for="post_id">投稿ID</label></td>
                        <td><input type="text" id="post_id" name="post_id" value="<?php echo $post_id = $row['post_id'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="title">投稿のタイトル</label></td>
                        <td>
                            <input type="text" id="title" name="title" value="<?php echo $title = $row['title'] ?>"
                            onclick="submit('toPostShow')">
                        </td>
                    </tr>
                </table>
            </form>
            <p>--------------------------------------------------------------------------------</p>
        <?php endforeach ?>
    </body>


</html>
