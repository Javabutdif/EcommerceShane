<!DOCTYPE html>
<html lang="en">

<head>
<body>
    <header>
        <h1>E-Commerce Platform</h1>
</body>
</header>
    <meta charset="utf-8" />
    <title>Login</title>
    <!-- <link rel="stylesheet" href="login.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <script>
        function validateForm() {
            var username = document.forms["login"]["username"].value;
            var password = document.forms["login"]["password"].value;

            if (username == "" || password == "") {
                alert("Both username and password must be filled in");
                return false;
            }
        }

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

        function checkUsernameAvailability() {
            var username = document.getElementById("username").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.responseText;
                    var errorMessage = document.getElementById("username-error");
                    if (response === "taken") {
                        errorMessage.innerHTML = "Username is already taken";
                        errorMessage.style.color = "red";
                    } else if (response === "not_found") {
                        errorMessage.innerHTML = "Username not found";
                        errorMessage.style.color = "red";
                    } else {
                        errorMessage.innerHTML = "";
                    }
                }
            };
            xhttp.open("GET", "check_username.php?username=" + username, true);
            xhttp.send();
        }
    </script>
    <?php
    session_start();
    require ('db_connect.php');

    // Initialize login attempts counter
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
  
    // Maximum number of login attempts
    $max_attempts = 3;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == 'admin' && $password == 'admin'){
            header('Location: admin.php');
        }else{
        // Query to check if the username exists in the database
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                if($row['role'] == 'Vendor'){
                header("Location: dashboard.php");
                exit();
                }
                else{
                     header("Location: dashboard2.php");
                exit();
                }
            } else {
                // Increment login attempts
                $_SESSION['login_attempts']++;
                // Debugging: Echo out login attempts
                // echo "Login attempts: " . $_SESSION['login_attempts'] . "<br>";
                // Redirect to forgot password page if login attempts exceed the limit
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    // echo "<script>alert('Too many unsuccessful login attempts! Please reset your password.');</script>";
                    echo "<script>window.location.replace('forgot_password.php');</script>";
                    exit();
                } else {
                    header("Location: login.php?error=Incorrect Username/password");
                    exit();
                }
            }
        } else {
            header("Location: login.php?error=User not found");
            exit();
        }
    }
    }
    ?>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/kccc.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: right;
            align-items: center;
            height: 100vh;
        }

        header {
            background-color: transparent;
            color: black;
           
            padding: 15px 0;
            height: 90vh;
            margin-bottom: 80px;
            font-size: 90%;
            margin-top: 5%;
           
        }

        .container {
            background-color: pink;
            padding: 20px;
            margin: 50px;
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
          
        }

        #login input[type="password"],
        #login button,
        #login input[type='text'] {
            font-size: 15px;
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid white;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #login button {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

        #login button:hover {
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="login.php" method="POST" name="login" onsubmit="return validateForm()" id="login">
            <h3>LOGIN</h3>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error">
                    <?php echo $_GET['error']; ?>
                </p>
            <?php } ?>
            <label>User Name</label>
            <input type="text" class="login-input" name="username" id="username" placeholder="Username"
                onkeyup="checkUsernameAvailability()" autofocus="true" />
            <p id="username-error" style="color: red; margin-bottom: 20px"></p>
            <label>Password</label>
            <div style="position: relative;">
                <input type="password" class="login-input" name="password" id="password" placeholder="Password" />
                <i id="eye-icon" class="fa fa-eye" onclick="togglePassword()"
                    style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <button type="submit" name="submit">LOGIN</button>
            <br><br><br>
            <p class="link">Don't have an Account? <a href="register.php">Register Here!</a></p>

        </form>
    </div>
</body>

</html>