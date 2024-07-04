<?php
$servername="localhost";
$username="root";
$password="";
$dbname="coderscore_udata";
$connect = mysqli_connect($servername,$username,$password,$dbname);
if($connect)
{
    //echo"Connection Established";
    echo"#";
}
else{
    echo"Connection-error Please Check!!";
}

?>