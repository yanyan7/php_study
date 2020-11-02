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
        <link rel="stylesheet" href="/style/style.css">
        <script type="text/javascript">
            const confirm = () => {
                if(!window.confirm("退会してよろしいですか?")){
                    return false;
                }
                document.userDestroy.submit();
            }
        </script>
    </head>
    <body>
        <?php if( isset($_SESSION['user']) && $_SESSION['user']==$items[0]['user_id'] ): ?>
            <form id="userEdit" name="userEdit" action="edit.php" method="get" class="btn-US-layout btn-US-space">
                <!-- ログイン済みかつ、ユーザがログインユーザと一致する場合は編集可能 -->
                <button type="button" id="edit" name="edit" onclick="submit('userEdit')">編集する</button>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>">
            </form>

            <form id="userDestroy" name="userDestroy" action="destroy.php" method="post" class="btn-US-layout">
                <!-- ログイン済みかつ、ユーザがログインユーザと一致する場合は削除可能 -->
                <button type="button" id="destroy" name="destroy" onclick="return confirm()">退会する</button>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>">
            </form>
        <?php endif ?>

        <input type="hidden" id="user_id" name="user_id" value="<?php echo $items[0]['user_id'] ?>">
        <p><input type="text" id="name" name="name" class="show-only title font-US-title" value="<?php echo $items[0]['name'] ?>"></p>
        <textarea name="introduction" id="introduction" cols="30" rows="10" class="show-only" placeholder="自己紹介が未入力です" readonly><?php echo $items[0]['introduction'] ?></textarea>

        <hr>

        <h3>投稿一覧</h3>

        <?php if($items[0]['post_id']): ?>
            <!-- 投稿がある場合は表示する -->
            <?php foreach($items as $row): ?>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>">
                <input type="hidden" id="name" name="name" value="<?php echo $row['name'] ?>">
  
                <form id="postShow" name="postShow" action="../post/show.php" method="get">
                    <input type="hidden" id="post_id" name="post_id" value="<?php echo $row['post_id'] ?>">

                    <input type="text" id="title" name="title" class="show-only link" value="<?php echo $row['title'] ?>"
                            onclick="submit('postShow')">   

                    <hr>
                </form>
            <?php endforeach ?>
        <?php endif ?>
    </body>


</html>
