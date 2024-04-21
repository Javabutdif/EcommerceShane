<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="reset_password.css" />
    <title>Reset Password</title>

    <?php
    session_start(); // Start the session
    
    require ('db_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmPassword'];

        // Validate passwords
        if ($password != $confirm_password) {
            echo "Passwords do not match.";
        } else {
            // Reset the user's password in the database
            if (isset($_SESSION['reset_email'])) {
                $email = $_SESSION['reset_email'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password='$hashed_password' WHERE email='$email'";

                if (mysqli_query($con, $query)) {
                    // Clear session variables
                    unset($_SESSION['reset_email']);
                    unset($_SESSION['reset_otp']);

                    echo "Password reset successfully. You can now <a href='login.php'>login</a> with your new password.";
                    exit();
                } else {
                    echo "Error updating password: " . mysqli_error($con);
                }
            } else {
                echo "Reset email not found in session.";
            }
        }
    }
    ?>

    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            // var confirmPasswordInput = document.getElementsBy("confirmPassword")[0];
            var message = document.getElementById("confirmMessage");

            if (password === confirmPassword) {
                message.innerHTML = "Passwords match";

                message.style.color = "green";
            } else {
                message.innerHTML = "Passwords do not match";

                message.style.color = "red";
            }
        }




        function suggestStrongPassword() {
            var passwordInput = document.getElementById("password");
            var password = passwordInput.value;
            var message = document.getElementById("passwordStrengthMessage");
            var hasUppercase = /[A-Z]/.test(password);
            var hasLowercase = /[a-z]/.test(password);
            var hasNumbers = /\d/.test(password);
            var hasSpecialChars = /[!@#$%^&*]/.test(password);

            message.innerHTML = "";

            if (!hasUppercase) {
                message.innerHTML += "Include at least one uppercase letter, ";
            }
            if (!hasLowercase) {
                message.innerHTML += "<span>one lowercase letter, </span><br> ";
            }
            if (!hasNumbers) {
                message.innerHTML += "one number, ";
            }
            if (!hasSpecialChars) {
                message.innerHTML += "<span>special character (!@#$%^&*),<span><br> ";
            }
            if (password.length < 8) {
                message.innerHTML += "<span>Password should be at least 8 characters long </span>";
            }

            if (message.innerHTML !== "") {
                message.style.color = "red";
            } else {
                message.innerHTML = "Strong password";
                message.style.color = "green";
            }
        }

        function validateForm() {
            var password = document.getElementById("password").value;
            var message = document.getElementById("passwordStrengthMessage");
            var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

            if (!strongRegex.test(password)) {
                message.innerHTML = "Password should be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters (!@#$%^&*)";
                message.style.color = "red";
                return false;
            }
            message.innerHTML = "";
            return true;
        }
    </script>

</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: white;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: peachpuff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    label {
        font-size: 20px;
    }

    #resetPass input[type="password"],
    #resetPass input[type="submit"] {
        font-size: 25px;
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    #resetPass input[type="submit"] {
        background-color: blue;
        color: white;
        border: none;
        cursor: pointer;
    }

    #resetPass input[type="submit"]:hover {
        background-color: black;
    }
</style>

<body>
    <div class="container">
        <form method="post" id="resetPass">
            <h2>Reset Password</h2>
            <label>New Password:</label>
            <br>
            <input type="password" class="login-input" name="password" id="password" placeholder="Password"
                onkeyup="suggestStrongPassword()" onfocus="suggestStrongPassword()" required />
            <div class="border">
                <div id="password-strength-meter"></div>
            </div>
            <br>
            <p id="passwordStrengthMessage" style="color: red;"></p><br>
            <label class="label1">Confirm Password:</label>
            <br>
            <input type="password" class="login-input" name="confirmPassword" id="confirmPassword"
                placeholder="Confirm Password" onkeyup="checkPasswordMatch()" required />
            <div id="confirmMessage"></div>
            <div class="form-group">
                <input type="submit" value="Sign Up" name="signup" id="submit" class="btn">
            </div>
        </form>
    </div>
</body>

</html>