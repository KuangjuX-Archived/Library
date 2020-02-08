<!DOCTYPE html>
<html>
<head>
    <title>Library</title>
</head>
<body>
    <h1>Library of Qcx</h1>
    <?php
    session_start();
    $searchtype=$_POST["searchtype"];
    $searchterm=trim($_POST["searchterm"]);

    if(!$searchterm||!$searchtype)
    {
        echo"<p>You don't search information about book,</br>".
            "please return to select.</p>";
        exit;
    }
    switch($searchtype)
    {
        case"Title":
        case"Lable":
        case"Book_id":
            break;
        default:
            echo"<p>This is an invalid option, </br>".
                "please return to select.</p>";
            exit;
    }

    //set up DSN
    $username="root";
    $password="";
    $host="localhost";
    $db_name="library";
    $dsn="mysql:host=$host;dbname=$db_name";


    //连接数据库
    try
    {
        $db=new PDO($dsn,$username,$password);

        //perform query
        $query="SELECT * FROM book WHERE $searchtype LIKE ?";
        $stmt=$db->prepare($query);

        $stmt->execute(array("%$searchterm%"));

        //get number of returned rows


        while($result=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo"<p><strong>".$result["Title"]."</strong>";
            echo"</br>Lable:".$result["Lable1"]." ".$result["Lable2"]." ".$result["Lable3"]." ".$result["Lable4"]." ".$result["Lable5"];
            echo"</br>Book_id:".$result["Book_id"];
            echo "</br>The number of this book is ".$result["Number"];
        }

        $db=NULL;

    }
    catch(PDOException $e)
    {
        echo"Error".$e->getMessage();
        exit;
    }


    ?>
</br>
<a href="Login.php">Return</a><br/>
<a href="Page.php">Home</a>
</body>
</html>


