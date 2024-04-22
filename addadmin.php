<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <!-- <link rel="stylesheet" href="register.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }

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



        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementsByName("password")[0];
            var confirmPasswordInput = document.getElementsByName("repeat_password")[0];

            passwordInput.addEventListener('input', function () {
                checkPasswordStrength();
                checkPasswordMatch();
            });

            confirmPasswordInput.addEventListener('keyup', checkPasswordMatch);
        });

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
                xhr.onload = function () {
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

        function checkUsernameAvailability() {
            var username = document.getElementById("username").value;
            var message = document.getElementById("usernameMessage");

            // Clear message if username field is empty
            if (username.trim() === "") {
                message.innerHTML = "";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_uname.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText.trim() === "exists") {
                        message.innerHTML = "Username is already taken";
                        message.style.color = "red";
                    } else {
                        message.innerHTML = ""; // Clear message if username is available
                    }
                }
            };
            xhr.send("username=" + username);
        }
    </script>
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
        justify-content: right;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 350px;
        background-color: pink;
        padding: 50px;
        margin: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    h3 {
        color: black;
        text-align: center;
        margin-bottom: 45px;
        font-size: 300%;
        margin-top: 5%;

    }

    label {
        font-size: 20px;
        text-align: left;
    }

    #register input[type="password"],
    #register input[type="tel"],
    #register button,
    #register input[type='text'] {
        font-size: 15px;
        width: 100%;
        padding: 10px;
        margin: 0px 0;
        display: inline-block;
        border: 1px solid white;
        border-radius: 5px;
        box-sizing: border-box;
    }

    #register button {
        background-color: blue;
        color: white;
        border: none;
        cursor: pointer;
    }

    #register button:hover {
        background-color: black;
    }
</style>

<body>
    <?php
    require ('db_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($con, $email);
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $contact = stripslashes($_POST['contact']);
        $contact = mysqli_real_escape_string($con, $contact);
        $name = stripslashes($_POST['name']);
        $name = mysqli_real_escape_string($con, $name);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $role = stripslashes($_POST['occupation']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
        } else {
            $query = "SELECT * FROM `users` WHERE `email`='$email'";
            $result = mysqli_query($con, $query);
            $rows = mysqli_num_rows($result);
            if ($rows > 0) {
                $error_message = "email or email already exists";
            } else {
                if (empty($name) || empty($password)) {
                    $error_message = "You must fill in all the fields!";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT into `users` (email, password, name, username, contact, role) VALUES ('$email', '$hashed_password', '$name', '$username', '$contact' , '$role')";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        echo "<div class='form'>
                          <script>alert('Add User Successfully');</script>;
                          <script>window.location.href ='admin.php'</script>;
                          </div>";
                        exit();
                    } else {
                        $error_message = "Error during registration. Please try again later.";
                    }
                }
            }
        }
    }
    ?>
    <div class="container">
        <form id="register" action="" method="post" onsubmit="return validateForm()">
            <h3>REGISTER</h3>
            <?php if (!empty($error_message)) { ?>
                <p class="error">
                    <?php echo $error_message; ?>
                </p>
            <?php } ?>
            <label>Full Name</label>
            <input type="text" class="login-input" name="name" placeholder="Name" Required>
            <label>Contact Number</label>
            <input type="tel" class="login-input" name="contact" id="contact" placeholder="Contact number"
                maxlength="11" required>
            <span id="contactErrorMessage" style="color: red;"></span>

            <script>
                // Function to validate numeric input for contact number
                document.getElementById("contact").addEventListener("input", function (event) {
                    var input = event.target.value;
                    if (!/^\d*$/.test(input)) {
                        event.target.value = input.slice(0, -1);
                    }
                });
            </script>

            <label>Username</label>
            <input type="text" class="login-input" name="username" id="username" placeholder="Username"
                onkeyup="checkUsernameAvailability()" required>
            <p id="usernameMessage" style="color: red;"></p>
            <label>Email</label>
            <input type="text" class="login-input" name="email" id="email" placeholder="Email Address" onblur="validateEmail()"
                oninput="validateEmail()" required />
            <p id="emailErrorMessage" style="color: red;"></p>
            <label>Password</label>
            <div style="position: relative;">
                <input type="password" class="login-input" name="password" id="password" placeholder="Password"
                    onkeyup="suggestStrongPassword()" onfocus="suggestStrongPassword()" required />

                <br>
                <p id="passwordStrengthMessage" style="color: red;"></p>
            </div>


            <label>Confirm Password</label>
            <input type="password" class="login-input" name="confirmPassword" id="confirmPassword"
                placeholder="Confirm Password" onkeyup="checkPasswordMatch()" required />
            <div id="confirmMessage"></div>
            

               
                            
            <select name="occupation"  id="course" class="login-input">
                <option value="Vendor">Vendor</option>
                <option value="Customer">Customer</option>
          
             
           
            </select>
            
     
                      <label class="form-label" for="course">Label</label>
                 
            <br>
            <button type="submit" id="signupButton">Add</button>
            <br>
            <br>
         
        </form>
    </div>
</body>

</html>