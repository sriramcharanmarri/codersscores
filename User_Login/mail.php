<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
function sendmail($usermail,$otp,$uname){
    $mail = new PHPMailer(true);
try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = '';
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('', 'Coders Scores');
    $mail->addAddress($usermail);
    $mail->isHTML(true);
    $mail->Subject = 'Coders Scores Verification';
    $mail->Body = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:800px;overflow:auto;line-height:2">
    <div style="margin:50px auto;width:70%;padding:20px 0">
      <div style="border-bottom:1px solid #eee">
        <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Coders Scores</a>
      </div>
      <p style="font-size:1.1em">Hi,'.$uname.'</p>
      <p>Use the following one-time password (OTP) to verify your email address. You can use this email address to sign-in or recover your CodersScores account.This OTP is valid for 5 minutes.</p>
      <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$otp.'</h2>
      <p></p>
      <p style="font-size:0.9em;"><b>If you did not initiate this verification process, please disregard this message.</b></p>
      <hr style="border:none;border-top:1px solid #eee" />
      <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
        <p style="color:black;">Regards</p>
        <p><a href="https://codersscores.tech" style="color:black;text-decoration:none;">Codersscores.tech</a></p>
      </div>
    </div>';
    // Send the email
    $mail->send();
    echo 'OTP sent successfully.';
} catch (Exception $e) {
    echo 'Error: ' . $mail->ErrorInfo;
    echo 'Email could not be sent';
}
}
?>
