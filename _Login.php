<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>


<?php
//检查是否有会话
$flag=0;
session_start();

if(isset($_SESSION["vaild_user"]))
{
    $flag=1;
    $_username=$_SESSION["vaild_user"];
}

//连接数据库
$host = 'localhost';
$database = 'library';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$database";
try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "error:" . $e->getMessage();
    exit;
}
//取出超级全局变量
if(!isset($_SESSION["vaild_user"]))
{
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $_username = $user;

//执行数据库操作

    $sql = "SELECT * FROM admin";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row["user"] == $user && $row["pass"] = $pass) {
            $flag = 1;
            break;
        }
    }
}
if($flag==0)
{
    echo"You don't have a correct account.</br>";
    echo"Please return to open an account.";
    exit;
}
else
{
    $_SESSION["vaild_user"]=$_username;
    echo '<a href="add_book.html"><button type="button">Add Books</button></a></br>';
    echo '<a href="change.html"><button type="button">Change Books</button></a></br>';
    echo '<a href="appoint.html"><button type="button">Appoint a new administrator</button></a></br>';
    echo '<a href="delete.html"><button type="button"><strong>Delete Books</strong></button>';
}



?>
</body>
</html>
