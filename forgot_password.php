<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgot_password.css" />
    <title>Forgot Password</title>
</head>
<style>
    body {
            font-family: Arial, sans-serif;
            background-image: url('img/kccc.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: pink;
            padding: 20px;
            margin: 100px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        label{
            font-size: 20px;
        }

        .email-form input[type="email"],
        .email-form input[type="submit"] {
            font-size: 15px;
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid white;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .email-form input[type="submit"] {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

        .email-form input[type="submit"]:hover {
            background-color: black;
        }

        #otpForm input[type="text"],
        #otpForm button {
            font-size: 15px;
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid white;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #otpForm button {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

        #otpForm button:hover {
            background-color: black;
        }
</style>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php
        session_start();
        require('db_connect.php');

        // Function to generate OTP
        function generateOTP()
        {
            // Generate a random 6-digit OTP
            return rand(100000, 999999);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['email'])) {
                $email = $_POST['email'];

                // Check if the email exists in the database
                $query = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    // Generate and send OTP
                    $otp = generateOTP();
                    $_SESSION['reset_email'] = $email; // Store email in session for verification
                    $_SESSION['reset_otp'] = $otp; // Store OTP in session for verification

                    // Configure SMTP settings
                    // Configure SMTP settings for Gmail
                    ini_set("SMTP", "smtp.example.com"); // Replace smtp.example.com with your SMTP server address
                    ini_set("smtp_port", "25"); // Replace 587 with your SMTP port number
                    // Send OTP to email
                    $to = $email;
                    $subject = "Password Reset OTP";
                    $message = "Your OTP for password reset is: $otp";                 
                    $headers = "From: your@example.com";

                    if (mail($to, $subject, $message, $headers)) {
                        echo "<p>An OTP has been sent to your email. Please check your inbox and enter the OTP below.</p>";
                        echo '<form id="otpForm" method="post" action="verify_otp.php">
                        <label>Enter OTP:</label>
                        <br>
                        <input type="text" name="otp" required placeholder="Enter code">
                        <br>
                        <button type="submit" id="submitBtn">Continue</button>
                        </form>';
                     
                       
                    } else {
                        echo "<p>Failed to send OTP. Please try again later.</p>";
                    }

                    // Hide the email input form
                    echo '<style>.email-form { display: none; }</style>';
                } else {
                    echo "<p>Email not found. Please enter a valid email address.</p>";
                }
            }
        }
        ?>
        <form action="forgot_password.php" method="post" class="email-form">
            <label style="margin-left: 0;">Email</label>
            <br>
            <input type="email" name="email" placeholder="Email" onblur="validateEmail()" oninput="validateEmail()" required >
            <p id="emailErrorMessage" style="color: red;"></p>
            <input type="submit" value="Continue" class="btn-submit">
        </form>
      
    </div>
</body>
<script>
     function validateEmail() {
            var emailInput = document.getElementById("email");
            var errorMessage = document.getElementById("emailErrorMessage");
            var email = emailInput.value;
            var isValidFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

            if (!isValidFormat) {
                errorMessage.innerHTML = "Invalid email format";
                errorMessage.style.color = "red";
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "check_email.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        if (xhr.responseText.trim() === "exists") {
                            errorMessage.innerHTML = "Email is already in use";
                            errorMessage.style.color = "red";
                        } else {
                            errorMessage.innerHTML = ""; // Clear error message if email is not in use
                        }
                    }
                };
                xhr.send("email=" + email);
            }
        }
</script>

</html>
