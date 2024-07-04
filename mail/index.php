<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
</head>
<body>
    <form method="post">
        <input type="text" name="uname" placeholder="User-name"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="password" name="password1" placeholder="confirm password"><br>
        <input type="submit" value="Sign-in"><br>
    </form>
</body>
</html>
<?php
include("mail.php");
include("otp.php");
if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password1']) && isset($_POST['uname']))
{
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    if($password == $password1)
    {
        $otpData = generateOTP();
        $otp = $otpData['otp'];
        $expiry = $otpData['timestamp'];
        sendmail($email,$otp,$uname);
        session_start();
        $_SESSION['otp'] = $otp;
        $_SESSION['expiry'] = $expiry;
        header("Location: verification.php");
    }
    else
    {
        echo "Password not matched";
    }
}
?>