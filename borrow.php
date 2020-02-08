
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>borrow</title>
</head>
<body>
<?php
session_start();
$host="localhost";
$user="root";
$pass="";
$database="library";

$dsn="mysql:host=$host;dbname=$database";
/*try
{
    $db=new PDO($dsn,$user,$pass);
    $card_id=$_POST["card_id"];
    $username=$_POST["username"];
    $Major=$_POST["Major"];
    $book_id=$_POST["book_id"];
    $number=$_POST["number"];
    $date=$_POST["date"];
    $time=time();
    $stmt=$db->prepare("SELECT * FROM book WHERE Book_id=?");
    if($stmt->execute(array($book_id)))
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            if($row['Book_id']==$book_id) $flag=1;
            else
            {
                $flag=0;
                echo "There is not this book in this library"."<br/>";
                exit;
            }
        }
    }
    if($date<1||$date>30)
    {
        $flag=0;
    }
    if($flag==0)
    {
        echo"You have written wrong information."."</br>".
            "Please return to write again.";
    }
    if($flag)
    {
        $stmt2=$db->prepare("SELECT * FROM card WHERE card_id=?");
        $stmt2->execute(array($card_id));
        $stmt4=$db->prepare("SELECT * FROM school WHERE student_id=?");
        $stmt4->execute(array($username));
        $sum1=0;
        $sum2=0;

        while($result_1=$stmt2->fetch(PDO::FETCH_ASSOC)&&$result_2=$stmt4->fetch(PDO::FETCH_ASSOC))
        {

            if($result_1["Major"]==$result_2["Major"])
            {
                $sum1+=$result_1["number"];
            }
            else
            {
                $sum2+=$result_1["number"];
            }
            if($sum1>20&&sum2>10&&($time-result_1["time"])>$result_1["date"]*86400)
            {
                $flag=0;
                break;
            }

        }
    }

    if($flag==1)
    {
        $sql="INSERT INTO card (card_id,username,book_id,Major,number,date,time) VALUES(:card_id,:username,:book_id,:Major,:number,:date,:time)";
        $stmt3=$db->prepare($sql);
        if($stmt3->execute(array(':card_id'=>$card_id,':username'=>$username,':book_id'=>$book_id,':Major'=>$Major,':number'=>$number,':date'=>$date,'time'=>$time)))
        {
            echo"You have already borrowed this book successful."."<br/>";
        }
        else
        {
            echo"You failed to borrow this book,please return to try again."."<br/>";
        }
        $sql3="SELECT number FROM book WHERE Book_id=?";
        $statement3=$db->prepare($sql3);
        $statement3->execute(array($book_id));
        $row=$statement3->fetch(PDO::FETCH_ASSOC);
        $total_number=$row["number"];


        $sql2="UPDATE book SET number=? WHERE Book_id=?";

        $statement=$db->prepare($sql2);
        $flag=$statement->execute([$total_number-$number,$book_id]);
        if($flag)
        {
            echo"The book in this library have been removed"."<br/>";
        }
        else{
            echo"the book in this library failed to be removed."."<br/>";
        }

    }


}
catch(PDOException $e)
{
    echo"Error".$e->getMessage();

    exit;
}*/
$card_id=$_POST["card_id"];
$username=$_POST["username"];
$Major=$_POST["Major"];
$book_id=$_POST["book_id"];
$number=$_POST["number"];
$date=$_POST["date"];
function connect($dsn,$pass,$user)//连接数据库
{
    try{
        $db=new PDO($dsn,$user,$pass);
        $db->exec("set names utf8");
        return $db;


    }
    catch(PDOException $exception)
    {
        echo"Connection error".$exception;

    }

}

$db=connect($dsn,$pass,$user);

function judge_time($card_id)//判断上次借书是否超过期限
{

    global $db;
    $query="SELECT * FROM record WHERE card_id=?";
    //$db->exec("utf8");
    $stmt=$db->prepare($query);
    $stmt->execute(array($card_id));
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        //var_dump($row);
        if($row==array())return true;
        $out_time=strtotime($row["out_time"]);
        $date=$row["date"];
        $time=time();
        if($time-$out_time<$date*86400)
        {
            continue;
        }
        else{
            return false;
        }
    }
    return true;

}

function judge_book($book_id,$number,$Major)//判断所借书的专业和数量
{

    global $db;
    $stmt=$db->prepare("SELECT * FROM book WHERE Book_id=?");
    $stmt->execute(array($book_id));
    $arr=$stmt->fetch(PDO::FETCH_ASSOC);
    if($number<=$arr["Number"])
    {
        if(($Major==$arr["Major"]&&$number<=20)||$number<=10)
        {
            return true;
        }


    }
    return false;

}



function borrow($book_id,$card_id,$number,$date,$Major)
{
    if(judge_book($book_id,$number,$Major)&&judge_time($card_id)&&$date>=1&&$date<=30)
    {
        global $db;
        //更新借书记录
        $out_time=date('Y-m-d H:i:s',time());
        $sql="INSERT INTO record(card_id,Book_id,out_time,Major,number,date) VALUES (:card_id,:Book_id,:out_time,:Major,:number,:date)";

        $operate=$db->prepare($sql);
        $arr=array(":card_id"=>$card_id,":Book_id"=>$book_id,":number"=>$number,
            ":out_time"=>$out_time,":Major"=>$Major,":date"=>$date);
        $operate->execute($arr);


        //在图书列表中更改
        $temp=$db->prepare("SELECT Number FROM book WHERE Book_id=?");
        $temp->execute(array($book_id));
        $total_number=$temp->fetch(PDO::FETCH_ASSOC)["Number"];

        $operate_2=$db->prepare("UPDATE book SET Number=? WHERE Book_id=?");
        $operate_2->execute(array($total_number-$number,$book_id));

        echo "You have borrow books successful";
        return;
    }

    echo "You can't borrow books from here.";
    return;


}

borrow($book_id,$card_id,$number,$date,$Major);








?>
</body>
</html>

