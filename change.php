<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change</title>
</head>
<body>
<?php
$flag=0;
session_start();
$host="localhost";
$database="library";
$username="root";
$password="";
$dsn="mysql:host=$host;dbname=$database";
try{
    $db=new PDO($dsn,$username,$password);
}
catch(PDOException $e)
{
    echo"Error:".$e->getMessage();
}
if(isset($_SESSION["user"])&&isset($_SESSION["pass"]))
{
    $flag=1;
}
if(!isset($_SESSION["user"])||!isset($_SESSION["pass"]))
{
    $book_id=$_POST["book_id"];
    $Major=$_POST["Major"];
    $Lable1=$_POST["Lable1"];
    $Lable2=$_POST["Lable2"];
    $Lable3=$_POST["Lable3"];
    $Lable4=$_POST["Lable4"];
    $Lable5=$_POST["Lable5"];

    $sql="SELECT * FROM book";
    $stmt=$db->prepare($sql);
    $stmt->execute();
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        if($row["Book_id"]==$book_id)
        {
            if($Major!=NULL&&($Lable1||$Lable2||$Lable3||$Lable4||$Lable5)!=NULL)
            {
                $sql_2="UPDATE book SET Major=:Major,Lable1=:Lable1,Lable2=:Lable2,".
                    "Lable3=:Lable3,Lable4=:Lable4,Lable5=:Lable5 WHERE Book_id=$book_id";
                $stmt_2=$db->prepare($sql_2);
                $stmt_2->execute(array(":Major"=>$Major,":Lable1"=>$Lable1,":Lable2"=>$Lable2,
                    ":Lable3"=>$Lable3,":Lable4"=>$Lable4,":Lable5"=>$Lable5));

                $message=$stmt_2->errorInfo();
                if($message[2])
                {
                    echo"Fail to update:".$message[2];
                }
                else
                {
                    echo"You have changed books in the library.";
                }
            }

        }
        else continue;
    }




}
?>
</body>
</html>


