<html>
<head>
 <title>Login Page</title>
<style >
*{
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
fieldset {
  background-color: #eeeeee;
  display: inline-block;
  
}
h3
{
    color:white;
}

legend {
  background-color: gray;
  color: white;
  padding: 5px 10px;
}
form
{
   text-align:center;
}

</style>
</head>
<body bgcolor="ffffff">
<h1 align=center><font color="Black" face="Calibri">Login Form</font></h1>
<hr width=25% height=50%>
  <form action="#" method="POST">
	<fieldset border="1">
		<legend align=center>Login</legend><br>
		<label for="uname"><b>Username : </b></label>
		<input type="text" name="username"  placeholder=username required><br><br>
		<label for="password"><b>Password : </b></label>
		<input type="password" name="password"  placeholder=password><br><br>
    		<input type="submit" name="Login" value="Login"><br><br>
        <a href="formtable1.php">Signup Here</a><br>
    		</label>
                <span class="psw">***_____________________________________***</span>
		
        </fieldset>
 </form>
</body>
</html>
<?php
error_reporting(0);
 include("loginconnection.php");
 if(isset($_POST['Login']))
 {
    $login=false;
    $user=$_POST['username'];
    $pass=$_POST['password'];
    //$query="SELECT * FROM coderscore_login_data WHERE username='$user' && password='$pass'";
    $query="SELECT * FROM login WHERE uname='$user'";
    $data=mysqli_query($connect1,$query);
    $total=mysqli_num_rows($data);
    if($total == 1)
    {
      $login = true;
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $user;
      while($row=mysqli_fetch_assoc($data))
      {
        if(password_verify($pass , $row['password'])){
        echo"<h3 color='black'>Login Sucessfull%</h3>";
        header('location:userprofile.php');
        //echo"<br><center><img src='1486.gif' height=100px width=100px ></center>";
        
        //echo"<meta http-equiv ='refresh' content ='2; window.location='fetch.php''>";
        //header('location:fetch.php');
        }
        else
        {
          echo "Wrong password";
        }
        
      }
    }
    else{
        echo"<br><center>Invalid Login!!</center>";
    }
 }
?>