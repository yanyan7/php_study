<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";


//コメント削除
$obj_c = new connect();

$sql_c =  'DELETE ';
$sql_c .= 'from ';
$sql_c .= '   comment ';
$sql_c .= 'WHERE ';
$sql_c .=     'user_id = ? ';

$param_c = array($_POST['user_id']);
$ret_c = $obj_c->plural($sql_c, $param_c);


//投稿削除
$obj_p = new connect();

$sql_p =  'DELETE ';
$sql_p .= 'from ';
$sql_p .= '   post ';
$sql_p .= 'WHERE ';
$sql_p .=     'user_id = ? ';

$param_p = array($_POST['user_id']);
$ret_p = $obj_p->plural($sql_p, $param_p);


//ユーザ削除
$obj_u = new connect();

$sql_u =  'DELETE ';
$sql_u .= 'from ';
$sql_u .= '   user ';
$sql_u .= 'WHERE ';
$sql_u .=     'id = ? ';

$param_u = array($_POST['user_id']);
$ret_u = $obj_u->plural($sql_u, $param_u);


// ログアウト
$_SESSION = array();
session_destroy();


//トップに戻る
header('Location: http://localhost:8000/post/index.php');
exit;

?>

