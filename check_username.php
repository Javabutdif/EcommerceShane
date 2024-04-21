<?php
// Include your database connection file
require('db_connect.php');

// Check if username is provided in the request
if (isset($_GET['username'])) {
    // Sanitize the username to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_GET['username']);

    // Query to check if the username exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Username exists in the database
        echo 'exist';
    } else {
        // Username does not exist in the database
        echo 'not_found';
    }
} else {
    // Username is not provided in the request
    echo 'error';
}

// Close database connection
mysqli_close($con);
