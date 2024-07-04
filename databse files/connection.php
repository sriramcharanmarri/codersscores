<?php
$servername="localhost";
$username="root";
$password="";
$dbname="coderscore_udata";
$conn = mysqli_connect($servername,$username,$password,$dbname);
if($conn)
{
    //echo"Connection Established";
    echo"#";
}
else{
    echo"Connection-error Please Check!!";
}

?>