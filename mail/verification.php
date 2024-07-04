<?php
session_start();
if(isset($_POST['otp']))
{
    $userOTP = $_POST['otp']; 
    $expiryTimestamp = $_SESSION['expiry'];
    $isOTPValid = verifyOTP($userOTP, $expiryTimestamp);
    if ($isOTPValid) {
        header("Location: user.php");
    } else {
        // OTP is invalid or expired
        echo "Invalid or expired OTP!";
    }
}
function verifyOTP($userOTP, $expiryTimestamp) {
    if (time() <= $expiryTimestamp) {
        if ($userOTP === $_SESSION['otp']) {
            //ikkda adatabase lo user details save cheyali
            return true;
        }
    }
    // OTP is invalid or expired
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
</head>
<body>
    <form method="post">
        <input type="text" name="otp" placeholder="Enter OTP Sent to your mail">
        <input type="submit" value="Verify">
    </form>
</body>
</html>
