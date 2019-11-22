<?php

//DB接続
try{
  //$pdo = new PDO('mysql:host=localhost;dbname=study_db;charset=utf8', 'sakurai', 'Sakurai@0329');
  $pdo = new PDO('mysql:host=mysql;dbname=study_db;charset=utf8', 'sakurai', 'Sakurai@0329');
} catch(PDOException $e){
    echo "接続エラー:{$e->getMessage()}";
  }

//クエリ発行
foreach($pdo->query('select * from post') as $row){
  echo "<p>$row[id]: $row[title]: $row[content]: $row[user_id]";
}



$pdo = null;

?>

