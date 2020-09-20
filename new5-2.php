<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>

<?php
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード名';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$newname=@$_POST['newname'];
$newcomment=@$_POST['newcomment'];
$editnumber=@$_POST['editnumber'];
$editname=@$_POST['editname'];
$editcomment=@$_POST['editcomment'];
$deletenumber=@$_POST['deletenumber'];
$date=date("Y/m/d H:i:s");
$newpassword=@$_POST['newpassword'];
$deletepassword=@$_POST['deletepassword'];
$editpassword=@$_POST['editpassword'];

//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS tbtest3"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATE,"
."password char(32)"
.");";
$stmt=$pdo->query($sql);



//テーブルにデータを入力
if(!empty($newname && $newcomment &&$newpassword)){
    $sql = $pdo -> prepare("INSERT INTO tbtest3 (name, comment,date,password) VALUES (:name, :comment,:date,:password)");
    $sql -> bindParam(':name',$newname, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $newcomment, PDO::PARAM_STR);
    $sql -> bindParam(':date',$date, PDO::PARAM_STR);
    $sql -> bindParam(':password',$newpassword, PDO::PARAM_STR);
    $sql->execute();
}

//編集機能
if(!empty($editnumber&&$editname && $editcomment&&$editpassword)){
$sql = 'UPDATE tbtest3 SET name=:name,comment=:comment, date=:date WHERE id=:id and password=:password';
    $id=$editnumber;
    $password=$editpassword;
    $stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $editname, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $editcomment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $editnumber, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':password', $editpassword, PDO::PARAM_STR);
	$stmt->execute();
}

//削除機能 
if(!empty( $deletenumber &&$deletepassword)){
$sql = 'delete from tbtest3 where id=:id and password=:password';
    $id=$deletenumber;
    $password=$deletepassword;
	$stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $deletenumber, PDO::PARAM_INT);
    $stmt->bindParam(':password', $deletepassword, PDO::PARAM_STR);
    $stmt->execute();

}

?>
<body>
<form method="post" action="new5-2.php">
<input type="text" name="newname" placeholder="名前"><br>
<input type="text" name="newcomment" placeholder="コメント"><br>
<input type="text" name="newpassword" placeholder="パスワード">
<input type="submit" name="submit" value="送信">
</form><br>

<form method="post" action="new5-2.php">
            <input type="text" name="deletenumber"  placeholder="削除対象番号"><br>
            <input type="text" name="deletepassword" placeholder="パスワード">
            <input type="submit" name="delete" value="削除">
        </form><br>

 <form method= "post" action="new5-2.php">
            <input type="text" name="editnumber" placeholder="編集対象番号"><br>
            <input type="text" name="editname" placeholder="名前（編集用）"><br>
            <input type="text" name="editcomment" placeholder="コメント（編集用）"><br>
            <input type="text" name="editpassword" placeholder="パスワード">
            <input type="submit" name="edit" value="編集">
        </form>

<?php        //データを表示

$sql = 'SELECT * FROM tbtest3';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].',';
    echo $row['date'].',';
    echo $row['password'].'<br>';
echo "<hr>";
}
?>
</body>
</html>