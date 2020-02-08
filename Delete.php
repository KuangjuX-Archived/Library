<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Books</title>
</head>
<body>
<?php
session_start();
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
$book_id=$_POST["book_id"];
$sql="DELETE FROM book WHERE Book_id=$book_id";
$stmt=$db->prepare($sql);
$stmt->execute();

$message=$stmt->errorInfo();

if($message[2])
{
    echo"Error".$message[2];
}
else
{

    echo"Delete successfully";
}
?>
<a href="_Login.php"><button button="button"><strong>Return</strong></button></a>
</body>
</html>
