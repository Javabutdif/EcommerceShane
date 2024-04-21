<?php
// Include database connection
require('db_connect.php');

// Check if username is set in the POST request
if (isset($_POST['username'])) {
    // Sanitize and escape the username
    $username = mysqli_real_escape_string($con, $_POST['username']);

    // Query to check if the username exists
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Username already exists
        echo "exists";
    } else {
        // Username is available
        echo "available";
    }
} else {
    // If username is not set in the POST request, return an error message
    echo "Username parameter is missing";
}
