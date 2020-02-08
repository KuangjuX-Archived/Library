<!DOCTYPE html>
<html>
<body>
<header>
    <meta charset="UTF-8">
</header>

<?php
//require_once"Connection.php";
function getrandstr()
{
    $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr=str_shuffle($str);
    $rands=substr($randStr,0,10);
    return $rands;
}
function register()
{
    //set up for using PDO
    $host = 'localhost';
    $database = 'library';
    $user = 'root';
    $password = '';

    //set up DSN
    $dsn="mysql:host=$host;dbname=$database";


    $mysql=new PDO($dsn,$user,$password);

    $identify=$_POST["identify"];
    $student_id=$_POST["student"];
    $Major=$_POST["Major"];
    $sql="SELECT identify,student_id FROM school";
    $stmt=$mysql->prepare($sql);
    $stmt->execute();


    $flag=0;

    //查询school表中是否有该学生信息
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        if($row["identify"]==$identify&&$row["student_id"]==$student_id)
        {
            $flag=1;
            break;
        }
    }

    //查询该学生是否办过卡
    $query="SELECT * FROM card WHERE username=$student_id";
    $s=$mysql->query($query);
    if($s->fetch(PDO::FETCH_ASSOC)!=NULL)
    {
        $flag=0;
        echo "You can't register repeatedly.<br/>";
    }
    if($flag==1)
    {


        $debit_card=getrandstr();
        echo"Your debit card account is: ".$debit_card;
        $query="INSERT INTO card(card_id,username,Major) VALUES(:card_id,:username,:Major)";
        $stmt=$mysql->prepare($query);
        //var_dump($mysql);

        //$statement=$stmt->bindParam(':card_id',$debit_card);
        //$stmt->bindParam(':username',$username);
        //var_dump($statement);
        $statement2=$stmt->execute(array(':card_id'=>$debit_card,':username'=>$student_id,':Major'=>$Major));
        //var_dump($statement2);


    }
    else
    {
        echo "You can't register in this library.<br/>";
        //echo date('H:i jS F Y');
        //echo time();
    }

}

register();
echo"<br/>";
?>
<a href="Page.php"><strong>Return</strong></a>
</body>
</html>


