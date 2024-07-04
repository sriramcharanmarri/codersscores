<?php
function generateOTP() {
    $length = 6;
    $validity = 5;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $otp = '';

    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[random_int(0, $max)];
    }

    $otpData = array(
        'otp' => $otp,
        'timestamp' => time() + ($validity * 6000) // Validity in seconds
    );

    return $otpData;
}
?>