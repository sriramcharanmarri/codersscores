<?php
function generateOTP() {
    $validity = 5; // 5 minutes
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $alphaPart = substr(str_shuffle($alphabet), 0, 2);
    $numberPart = substr(str_shuffle($numbers), 0, 2);
    $remainingPart = substr(str_shuffle($alphabet . $numbers), 0, 2);
    $otp = str_shuffle($alphaPart . $numberPart . $remainingPart);
    $otpData = array(
        'otp' => $otp,
        'timestamp' => time() + ($validity * 60) // Validity in seconds
    );
    return $otpData;
}
?>
