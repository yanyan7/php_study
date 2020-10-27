<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_POST['create_post']) ){
    // 投稿ボタンが押された場合
    $obj = new connect();

    $sql =  'INSERT INTO ';
    $sql .= 'post ';
    $sql .= 'VALUES( ';
    $sql .= '   0 ';   // 自動採番
    $sql .= '   ,? ';
    $sql .= '   ,? ';
    $sql .= '   ,? ';
    $sql .= ') ';

    $param = array($_POST['title'], $_POST['content'], $_SESSION['user']);
    $ret = $obj->plural($sql, $param);
}

header('Location: http://localhost:8000/post/index.php');
exit;

?>

