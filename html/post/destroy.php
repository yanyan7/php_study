<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";


//コメント削除
$obj = new connect();

$sql =  'DELETE ';
$sql .= 'from ';
$sql .= '   comment ';
$sql .= 'WHERE ';
$sql .=     'post_id = ? ';

$param = array($_POST['post_id']);
$ret = $obj->plural($sql, $param);


//投稿削除
$obj0 = new connect();

$sql_0 =  'DELETE ';
$sql_0 .= 'from ';
$sql_0 .= '   post ';
$sql_0 .= 'WHERE ';
$sql_0 .=     'id = ? ';

$param_0 = array($_POST['post_id']);
$ret = $obj0->plural($sql_0, $param_0);


//トップに戻る
header('Location: http://localhost:8000/post/index.php');
exit;

?>

