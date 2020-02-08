<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appoint</title>
</head>
<body>
<?php
session_start();
$host='localhost';
$database="library";
$username='root';
$password='';
$dsn="mysql:host=$host;dbname=$database";
try{
    $db=new PDO($dsn,$username,$password);
}
catch(PDOException $e)
{
    echo"Error:".$e;
}
$user=$_POST["user"];
$pass=$_POST["pass"];
$query="SELECT * FROM admin";
$statement=$db->prepare($query);
$statement->execute();
while($row=$statement->fetch(PDO::FETCH_ASSOC))
{
    if($row["user"]==$user)
    {
        echo"You can't appoint an existing administrator"."</br>";
        echo"Please return to try again.</br>";
        echo"<a href='appoint.html'><button type='button'><strong>Return</strong></button></a>";
        exit;
    }
}
$sql="INSERT INTO admin(user,pass) VALUES(:user,:pass)";
$stmt=$db->prepare($sql);
$stmt->execute(array(':user'=>$user,':pass'=>$pass));
$message=$stmt->errorInfo();
if($message[2])
{
    echo "Execute error:".$message[2]."</br>";
}
else{
    echo "You have appoint a new administrator successfully"."</br>";
}
?>
<a href="_Login.php"><button type="button"><strong>Return</strong></button></a>
</body>
</html>
