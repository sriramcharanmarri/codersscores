<?php
include("connection.php");
include("loginconnection.php");
include("mail.php");
include("otp.php");
error_reporting(0);
?>
<html>
<head>
<title>Form with table</title>
<marquee direction=right bgcolor="#eeeeee">!!! Welcome to CODERSCORE !!!</marquee>
<style>
fieldset{
background-color:#eeeeee; 
display:inline-block;
}
legend {
  background-color: gray;
  color: white;
  padding: 5px 10px;
}
</style>
</head>
<body>
<center><h1 title="Welcome"><font color="black">Sign Up Here</font></h1><hr height=40% width=20%></center>
<center>
<fieldset style=padding:43px;>
	<legend align="center"><font size=4.5>Personal Info</font></legend>
	<form action="formtable1.php" method="POST" onsubmit="sendEmail(); reset(); return false;"><table cellspacing="8" align=center>
	<tr>
		<td>Name</td>
		<td>: <input type="text" name="name" placeholder="Full Name" required>
		</td>
	</tr>
	<tr>
		<td>Email</td>
		<td>: <input type="email" name="mail" id="email" placeholder="abcd@sai.com" maxlength=31 required></td>
    </tr>
	<tr>
		<td>Username</td>
		<td>: <input type="text" name="uname" placeholder="User_Name"  required>
		</td>
	</tr>
	<tr>
		<td>Password</td>
		<td>: <input type="password" name="pass" placeholder="password" pattern="(?=.*[a-z]).{8,}" title="It should Not contain special characters other than '_' and should contain atleast 8 characters" required>
		</td>
	</tr>
	<tr>
		<td>Confirm Password</td>
		<td>: <input type="password" name="cpass" placeholder="Confirm password" required>
		</td>
	</tr>      
	</table><br>
	<input type="submit" name="Register" value="Register">
</form>
</fieldset>
</center>	
</body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
session_start();
$name =$_POST['name'];
$mail =$_POST['mail'];
$uname =$_POST['uname'];
$pass=$_POST['pass'];
$cpass=$_POST['cpass'];
$_SESSION['userotp'] = true;
$exists=false;
$query3="SELECT * FROM coderscore_login_data WHERE uname='$uname'";
$data3=mysqli_query($connect1,$query3);
$total=mysqli_num_rows($data3);
if($total == 1)
{
	$exists =true;
}
else{
	$exists = false;
}
if($exists == false){
	if($pass == $cpass && $exists==false){
		$_SESSION['name'] = $name;
		$_SESSION['mail'] = $mail;
		$_SESSION['uname'] = $uname;
		$_SESSION['cpass'] = $cpass;
        $otpData = generateOTP();
        $otp = $otpData['otp'];
        $expiry = $otpData['timestamp'];
        sendmail($mail,$otp,$uname);
        session_start();
        $_SESSION['otp'] = $otp;
        $_SESSION['expiry'] = $expiry;
        header("Location: verification.php");
	}
	else{
		echo"<center> >>>Please Check the Password Again!!!</center>";
	}	
}
else{
	echo "<Center> >>>UserAccount already exist >>> Failed to enter!!!</center>";
}
}
?>

