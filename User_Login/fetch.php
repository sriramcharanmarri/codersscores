<?php
include("connection.php");
error_reporting(0);
$query = "SELECT * FROM coders_data";
$data = mysqli_query($connect,$query);
echo "<h1><u>Data_Base Entries</u></h1>";
echo "<br><div style='border:5px outset #04AA6D;text-align:center;height:35px;width:100px;'><a href='login.php'>Logout</a></div><br><br>";
$total = mysqli_num_rows($data);
if($total != 0)
{
    ?>
    <table border="3">
        <tr>
        <th>Name</th>
        <th>User_Name</th>
        <th>Email</th>
        <th>id</th>
        </tr>
    
    <?php
    while($result = mysqli_fetch_assoc($data))
    {
        echo "<tr>
            <td>".$result['id']."</td>
            <td>".$result['name']."</td>
            <td>".$result['uname']."</td>
            <td>".$result['mail']."</td>
        </tr>";
    }
}
else{
    echo"Table has NO records!!!";
}
?>
</table>
<html>
    <head>
        <style>
            a{
                color:white;
            }
            h1
            {
                color:#eeeeee;
            }
            table 
            {
                background-color: #eeeeee;
            }
            th {
  background-color: #04AA6D;
  color: white;
}
        </style>
    </head>
    <body bgcolor="#381A38">
    </body>
</html>