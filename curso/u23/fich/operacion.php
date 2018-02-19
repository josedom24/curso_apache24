<?
if($_GET["op"]=="suma")
        {
                echo "La suma es ".($_GET["op1"]+$_GET["op2"]);
        }
if($_GET["op"]=="resta")
        {
                echo "La reata es ".($_GET["op1"]-$_GET["op2"]);
        }
if($_GET["op"]=="multiplicacion")
        {
                echo "La multiplicacion es ".($_GET["op1"]*$_GET["op2"]);
        }
if($_GET["op"]=="division")
        {
                echo "La diviison es ".($_GET["op1"]/$_GET["op2"]);
        }
?>

