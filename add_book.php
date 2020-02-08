<?php

function book()
{
    $host = 'localhost';
    $database = 'library';
    $user = 'root';
    $password = '';
    $dsn="mysql:host=$host;dbname=$database";
    try
    {
        $mysql=new PDO($dsn,$user,$password);
    }
    catch(PDOException $e)
    {
        echo "error:".$e->getMessage();
        exit;
    }

    $Book_id=$_POST["Book_id"];
    $Title=$_POST["Title"];
    $Major=$_POST["Major"];
    $Number=$_POST["Number"];
    $Lable1=$_POST["Lable1"];
    $Lable2=$_POST["Lable2"];
    $Lable3=$_POST["Lable3"];
    $Lable4=$_POST["Lable4"];
    $Lable5=$_POST["Lable5"];

    $flag=0;

    $query="SELECT Book_id FROM book";
    $stmt=$mysql->prepare($query);
    $stmt->execute();
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        if($row["Book_id"]==$Book_id)
        {
            $flag=1;
            break;
        }
    }

    if($flag==0)
    {
        $sql1="INSERT INTO book(Book_id,Title,Major,Number,Lable1,Lable2,Lable3,Lable4,Lable5)".
              "VALUES(:Book_id,:Title,:Major,:Number,:Lable1,:Lable2,:Lable3,:Lable4,:Lable5)";
        $statement1=$mysql->prepare($sql1);
        $statement1->bindParam(":Book_id",$Book_id);
        $statement1->bindParam(":Title",$Title);
        $statement1->bindParam(":Major",$Major);
        $statement1->bindParam(":Number",$Number);
        $statement1->bindParam("Lable1",$Lable1);
        $statement1->bindParam("Lable2",$Lable2);
        $statement1->bindParam("Lable3",$Lable3);
        $statement1->bindParam("Lable4",$Lable4);
        $statement1->bindParam("Lable5",$Lable5);

        $statement1->execute();

    }
}
book();
