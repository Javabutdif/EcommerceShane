<?php
require('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Check if the email exists in the database
    $query  = "SELECT * FROM `users` WHERE `email`='$email'";
    $result = mysqli_query($con, $query);
    $rows   = mysqli_num_rows($result);

    if ($rows > 0) {
        echo "exists"; // Email is already in use
    } else {
        // Email is not in use
        // You can add additional checks or validations here if needed
        echo ""; // Empty response
    }
} else {
    // Invalid request
    echo "Invalid request";
}
