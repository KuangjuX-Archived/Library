<!DOCTYPE html>
<html>
<body>
<meta charset="UTF-8">
<title>Qcx of Library</title>

<?php
class Page
{
    public $content;
    public $buttons=array("Home"=>"Page.php","Register"=>"register.html","Login"=>"Login.html","Search"=>"search.html");

    public function Display()
    {
        $this->DisplayHeader();
        $this->content;
        $this->DisplayMenu($this->buttons);
        $this->DisplayFooter();

    }

    public function DisplayHeader()
    {
        ?>
        <header>
            <img src="logo.gif" alt="logo" height="80" width="80"/>
            <h1><strong>Qcx of library</strong></h1>
        </header>
        <?php
    }

    public function DisplayMenu($buttons)
    {
        foreach($buttons as $name=>$url)
        {
            echo "<h><a href='$url'>$name</a></h><br/>";
        }
    }

    public function DisplayFooter()
    {
        ?>
        <footer>
            <p>&copy;Qcx of Library.</br>
            please see our
            <a href="legal.html">legal information</a></p>
        </footer>
        <?php
    }
}
?>
</body>
</html>


<?php
 $pgone=new Page();
 $pgone->content="<p>At Qcx of Library,we offer a number
of services. Perhaps the productivity of your employees would
improve if we re-engineered your business.Maybe all your business
needs is a fresh mission statement,or a new batch of buzzwords.</p>";

 $pgone->Display();