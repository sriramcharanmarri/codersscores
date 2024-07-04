<?php
$servername="localhost";
$username="root";
$password="";
$dbname="coderscore_login";
$connect1 = mysqli_connect($servername,$username,$password,$dbname);
if($connect1)
{
    echo"_";
}
else{
    echo"Connection-error Please Check!!";
}

?>