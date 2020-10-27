<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_POST['create_user']) ){
    // 投稿ボタンが押された場合

    // userテーブルに登録
    $obj = new connect();

    $sql =  'INSERT INTO ';
    $sql .= 'user ';
    $sql .= 'VALUES( ';
    $sql .= '   0 ';   // 自動採番
    $sql .= '   ,? ';
    $sql .= '   ,? ';
    $sql .= '   ,? ';
    $sql .= '   ,? ';
    $sql .= '   ,NULL ';
    $sql .= ') ';

    $param = array($_POST['name'], $_POST['email'], $_POST['password'], $_POST['introduction']);
    $ret = $obj->plural($sql, $param);

    // 登録したユーザ情報でログインする
    $sql_1 =  'SELECT ';
    $sql_1 .= '   id as user_id ';
    $sql_1 .= 'FROM ';
    $sql_1 .= '   user ';
    $sql_1 .= 'WHERE ';
    $sql_1 .= '   name = ? ';

    $param_1 = array($_POST['name']);
    $stmt = $obj->plural($sql_1, $param_1);
    $items = $stmt->fetch(PDO::FETCH_ASSOC);

    session_regenerate_id(true);
    $_SESSION["user"] = $items['user_id'];
    header("Location: ../post/index.php");  // 投稿一覧画面へ遷移
}

?>

