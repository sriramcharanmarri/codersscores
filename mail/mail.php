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
    $mail->Host = ''//ENter Server Name;
    $mail->SMTPAuth = true;
    $mail->Username = 'verification@codersscores.tech';
    $mail->Password = ''//ENter Password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('', '');//mail,Name
    $mail->addAddress($usermail);
    $mail->isHTML(true);
    $mail->Subject = 'Coders Scores Account Verification';
    $mail->Body = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:800px;overflow:auto;line-height:2">
    <div style="margin:50px auto;width:70%;padding:20px 0">
      <div style="border-bottom:1px solid #eee">
        <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Coders Scores</a>
      </div>
      <p style="font-size:1.1em"><b>Hi,'.$uname.'</b></p>
      <p>Thank you for choosing <b>CodersScores!</b> We are thrilled to have you on board. To ensure the security of your account and provide you with a seamless experience, we kindly request email verification. Please follow the instructions below:</p>
      <p>Use the <b>unique verification code</b> provided to verify your email address. This code will remain valid for the next 5 minutes:</p>
      <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$otp.'</h2>
      <p></p>
      <p style="font-size:0.9em;">If you did not initiate this verification process, please ignore this message.
      If you encounter any difficulties or require assistance, our dedicated support team is ready to help.</p>
      <p>We appreciate your cooperation and look forward to seeing you unlock your potential at CodersScores!</p>
      <hr style="border:none;border-top:1px solid #eee" />
      <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
        <p style="color:black;">Best Regards,</p>
        <p><a href="https://abcd.com" style="color:black;text-decoration:none;"><b>The CodersScores Team.</b></a></p>
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
