<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Books</title>
</head>
<body>
<?php
session_start();
$host="localhost";
$database="library";
$username="root";
$password="";
$dsn="mysql:host=$host;dbname=$database";
try
{
    $db=new PDO($dsn,$username,$password);
}
catch(PDOException $e)
{
    echo "Connection Error: ".$e;
}
$card_id=$_POST['card_id'];
$user=$_POST['user'];
$Book_id=$_POST['Book_id'];
$number=$_POST['number'];
/*$sql="SELECT * FROM library WHERE card_id=$card_id";
$stmt=$db->prepare($sql);
$stmt->execute();
$message=$stmt->errorInfo();
if($message[2])
{
    echo "We can't select the book you borrow.</br>";
    echo "Please return to try again.</br>";
}
else
{
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        if($number==$row["number"])
        {
            $sql_2="DELETE FROM card WHERE Book_id=$Book_id";
            $stmt_2=$db->prepare($sql_2);
            $stmt_2->execute();

            $sql_3="SELECT * FROM  book WHERE Book_id=$Book_id";
            $stmt_3=$db->prepare($sql_3);
            $stmt_3->execute();
            $row_2=$stmt->fetch(PDO::FETCH_ASSOC);
            $book_number=$row_2["number"];

            $sql_4="UPDATE book SET number=$number+$book_number WHERE Book_id=$Book_id";
            $stmt_4=$db->prepare();
            $stmt_4->execute();
        }
        else
        {
            $number_2=$row["number"];
            $sql_5="UPDATE card SET number=$number-$number_2 WHERE Book_id=$Book_id";
            $stmt_5=$db->prepare($sql_5);
            $stmt_5->execute();

            $sql_6="SELECT * FROM  book WHERE Book_id=$Book_id";
            $stmt_6=$db->prepare($sql_3);
            $stmt_6->execute();
            $row_3=$stmt->fetch(PDO::FETCH_ASSOC);
            $book_number_2=$row_2["number"];

            $sql_7="UPDATE book SET number=$number+$book_number_2 WHERE Book_id=$Book_id";
            $stmt_7=$db->prepare($sql_7);
            $stmt_7->execute();
        }
    }
*/
function judge_time($card_id,$Book_id)//判断是否超时还书
{
    global $db;
    $query="SELECT * FROM record WHERE card_id=? AND Book_id=?";
    $stmt=$db->prepare($query);
    $stmt->execute(array($card_id,$Book_id));
    while($result=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        $out_time=strtotime($result["out_time"]);
        $lasting_time=$result["date"]*86400;
        $now_time=time();
        if($now_time-$out_time<$lasting_time)
        {
            return true;
        }
        echo "You will be refused to lend book a week.<br/>";
        return false;
    }

}

function return_book($card_id,$user,$Book_id,$number)
{
    global $db;
    if(judge_time($card_id,$Book_id))
    {
        $sql="SELECT * FROM record WHERE card_id=? AND Book_id=?";
        $statement=$db->prepare($sql);
        $statement->execute(array($card_id,$Book_id));
        $result=$statement->fetch(PDO::FETCH_ASSOC);
        //修改record记录
        if($number==$result["number"])
        {
            $query="DELETE FROM record WHERE card_id=? AND Book_id=?";
            $operation_1=$db->prepare($query);
            $operation_1->execute(array($card_id,$Book_id));
        }
        else
        {
            $query="UPDATE record SET number=?";
            $operation_2=$db->prepare($query);
            $operation_2->execute(array($result["number"]-$number));
        }
        //修改book列表
        $query="SELECT * FROM book WHERE Book_id=$Book_id";
        $stmt=$db->query($query);
        $result_2=$stmt->fetch(PDO::FETCH_ASSOC);
        $old_number=$result_2["Number"];


        $book_operation="UPDATE book SET Number=$old_number+$number";
        $db->query($book_operation);
        echo "You have return books successfully";


    }
    else
    {
        echo "You can't return books. </br>";
    }
}
return_book($card_id,$user,$Book_id,$number);



?>
</body>
</html>

