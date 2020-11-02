<?php
session_start();  //セッション開始

require_once '../connect.php';

// エラーメッセージの初期化
$errorMessage = "";

if( isset($_POST['create_user']) ){
    // 投稿ボタンが押された場合

    //重複チェック
    //ユーザ名
    $obj_cn = new connect();

    $sql_cn =  'SELECT ';
    $sql_cn .= '   id as user_id ';
    $sql_cn .= 'FROM ';
    $sql_cn .= '   user ';
    $sql_cn .= 'WHERE ';
    $sql_cn .= "   name = '" . $_POST['name'] . "'";

    $items_cn = $obj_cn->select($sql_cn);

    if(!empty($items_cn)){ 
        header("Location: new.php");  // 作成画面へ戻る
        exit;
    }

    //メールアドレス
    $obj_ce = new connect();

    $sql_ce =  'SELECT ';
    $sql_ce .= '   email ';
    $sql_ce .= 'FROM ';
    $sql_ce .= '   user ';
    $sql_ce .= 'WHERE ';
    $sql_ce .= "   email = '" . $_POST['email'] . "'";

    $items_ce = $obj_ce->select($sql_ce);

    if(!empty($items_ce)){ 
        header("Location: new.php");  // 作成画面へ戻る
        exit;
    }


    // パスワードのハッシュ化
    $hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);


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

    $param = array($_POST['name'], $_POST['email'], $hash_pass, $_POST['introduction']);
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

