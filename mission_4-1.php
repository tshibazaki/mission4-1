<?php

date_default_timezone_set('Asia/Tokyo');


$dsn = 'データベース名';
$user = 'ユーザー名';
$pass = 'パスワード';
$pdo = new PDO($dsn, $user, $pass);


echo <<<EOT
<html>
    <head>
        <title>mission_4-1</title>
    </head>
    <body>
        <h1>掲示板</h1><hr>
EOT;
///////////////////////////////////////////////////////////////////////////////////////////////////
if(!$_POST['edited_no']){
    if($_POST['name'] && $_POST['comment'] && $_POST['password']){

        $sql = 'SELECT * FROM table1';
        $results=$pdo -> query($sql);
        foreach($results as $row){
            $id = $row['id'] + 1;
        }
        $sql=$pdo->prepare("INSERT INTO table1(id, name, comment, password, date) VALUES(:id,:name,:comment,:password,:date)");
        $sql->bindParam(':id', $id, PDO::PARAM_STR);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':password', $password, PDO::PARAM_STR);
        $sql->bindParam(':date', $date, PDO::PARAM_STR);
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $password = $_POST['password'];
        $date = date("Y-m-d H:i:s");
        $sql->execute();

        echo date("Y年m月d日 H時i分")."に投稿を受け付けました"."<br><hr>";
    }
    else if(!$_POST['name'] && !$_POST['comment'] && !$_POST['password']){
    }
    else{
        echo "名前、コメント、パスワードのいずれかが入力されていません。"."<br><hr>";
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['edit_no'] && $_POST['edit_password']){

    $edit_no = $_POST['edit_no'];
    $edit_password = $_POST['edit_password'];
    $sql = 'SELECT * FROM table1';
    $results=$pdo -> query($sql);
    foreach($results as $row){
        if($row['id'] == $edit_no && $row['password'] == $edit_password){
            $edit_name = $row['name'];
            $edit_comment = $row['comment'];
            break;
        }
        else if($row['id'] == $edit_no && $row['password'] != $edit_password){
            echo "パスワードが違います。"."<br><hr>";
            break;
        }
    }
}
else if(!$_POST['edit_no'] && !$_POST['edit_password']){
}
else{
    echo "編集対象番号またはパスワードが入力されていません。"."<br><hr>";
}
if($_POST['edited_no']){
    if($_POST['name'] && $_POST['comment'] && $_POST['password']){

        $id = $_POST['edited_no'];
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $password = $_POST['password'];
        $date = date("Y-m-d H:i:s");

        $sql="update table1 set name='$name' , comment='$comment' , password='$password' , date='$date' where id = $id";
        $result=$pdo->query($sql);

        echo date("Y年m月d日 H時i分")."に編集を受け付けました"."<br><hr>";
    }
    else if(!$_POST['name'] && !$_POST['comment'] && !$_POST['password']){
    }
    else{
        echo "名前、コメント、パスワードのいずれかが入力されていません。"."<br><hr>";
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['delete_no'] && $_POST['delete_password']){

    $delete_no = $_POST['delete_no'];
    $delete_password = $_POST['delete_password'];
    $sql = 'SELECT * FROM table1';
    $results=$pdo -> query($sql);
    foreach($results as $row){
        if($row['id'] == $delete_no && $row['password'] == $delete_password){
            $sql="DELETE from table1 where id=$delete_no";
            $resut=$pdo->query($sql);
            echo date("Y年m月d日 H時i分")."に削除を受け付けました"."<br><hr>";
            break;
        }
        else if($row['id'] == $delete_no && $row['password'] != $delete_password){
            echo "パスワードが違います。"."<br><hr>";
            break;
        }
    }
}
else if(!$_POST['delete_no'] && !$_POST['delete_password']){
}
else{
    echo "削除対象番号またはパスワードが入力されていません。"."<br><hr>";
}

///////////////////////////////////////////////////////////////////////////////////////////////////
echo <<<EOT
        <h2>投稿用フォーム</h2>
        <form method="post" action="mission_4-1.php">
            名前 :<br>
            <input type="text" name="name" placeholder="名前" value="$edit_name"><br>
            コメント :<br>
            <textarea name="comment" rows="4" cols="40" placeholder="コメント">$edit_comment</textarea><br>
            パスワード : <br>
            <input type="text" name="password" placeholder="パスワード" value="$edit_password">&nbsp;
            <input type="hidden" name="edited_no" value="$edit_no">
            <input type="submit" value="投稿">
        </form><br>
        <h2>編集用フォーム</h2>
        <form method="post" action="mission_4-1.php">
            投稿番号 :<br>
            <input type="text" name="edit_no" placeholder="番号"><br>
            パスワード : <br>
            <input type="text" name="edit_password" placeholder="パスワード">&nbsp;
            <input type="submit" value="編集">
        </form><br>
        <h2>削除用フォーム</h2>
        <form method="post" action="mission_4-1.php">
            投稿番号 :<br>
            <input type="text" name="delete_no" placeholder="番号"><br>
            パスワード : <br>
            <input type="text" name="delete_password" placeholder="パスワード">&nbsp;
            <input type="submit" value="削除">
        </form><br><hr>
        <h2>投稿一覧</h2>
    </body>
</html>
EOT;

//////////////////////////////////////////////////////////////////////////////////////

$sql = 'SELECT * FROM table1';
$results=$pdo -> query($sql);
foreach($results as $row){
    echo $row['id'].' '.$row['name'].' '.$row['comment'].' '.$row['date'].'<br>';
}
?>