<?php
session_start();
require('db_connect.php');

function generateOTP()
{
    // Generate a random 6-digit OTP
    return rand(100000, 999999);
}

// Check if the session contains the email
if (isset($_SESSION['reset_email'])) {
    $email = $_SESSION['reset_email'];

    // Generate new OTP
    $otp = generateOTP();
    $_SESSION['reset_otp'] = $otp;

    // Send OTP to email
    $to = $email;
    $subject = "Password Reset OTP";
    $message = "Your OTP for password reset is: $otp";
    $headers = "From: your@example.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
