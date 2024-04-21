<?php
session_start();

// Check if the OTP submitted by the user matches the one stored in the session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['reset_otp'])) {
    $otp_entered = $_POST['otp'];

    if ($otp_entered == $_SESSION['reset_otp']) {
        // OTP is correct, redirect to reset password page
        header("Location: reset_password.php");
        exit();
    } else {
        // OTP is incorrect, display error message
        $error_message = "Invalid OTP. Please try again.";
    }
} else {
    // Invalid request, redirect to forgot password page
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgot_password.css" />
    <title>Verify OTP</title>
</head>
<style>
    body {
    background-Color: white;
    background-size: cover; /* Ensure the background image covers the entire viewport */
    backdrop-filter: blur(5px); /* Adjust the blur radius as needed */
}
    label{
        margin-left: -200px;
    }
    input{
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    button{
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        width: 100%;
  
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        font-size: 16px;
    }
    button:hover{
        background-color: black;
    }

    
</style>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        
        <?php
          echo "<p>An OTP has been sent to your email. Please check your inbox and enter the OTP below.</p>";
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <form method="post" action="verify_otp.php">
            <label>Enter OTP:</label>
            <br>
            <input type="text" name="otp" required>
            <button type="submit">Submit OTP</button>
        </form>
        <p>Remember your password? <a href="login.php">Login</a></p>
    </div>
</body>

</html>
