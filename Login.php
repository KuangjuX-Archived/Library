<!DOCTYPE html>
<html>
<head>
    <title>Library</title>
</head>
<body>
<h1><strong>Login</strong></h1>
<?php
session_start();
$flag=0;

if(isset($_SESSION["vaild_user"]))
{
    $flag=1;
    $_username=$_SESSION["vaild_user"];
}
else {
    $card = $_POST["card"];
    $username = $_POST["student"];
    $_username=$username;
    //connect database
    $host = 'localhost';
    $database = 'library';
    $user = 'root';
    $password = '';
    $dsn = "mysql:host=$host;dbname=$database";
    try {
        $mysql = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        echo "error:" . $e->getMessage();
        exit;
    }

    $query = "SELECT card_id,username FROM card";
    $stmt = $mysql->prepare($query);
    $stmt->execute();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row["card_id"] == $card && $row["username"] == $username) {
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
    echo '<a href="search.html"><button type="button">Search Books</button></a></br>';
    echo '<a href="borrow.html"><button type="button">Borrow Books</button></a></br>';
    echo '<a href="return.html"><button type="button"><strong>Return Books</strong></button></a></br>';
}
?>
</body>
</html>
