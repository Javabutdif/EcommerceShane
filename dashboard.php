<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>User Dashboard</title>
</head>

<body>
    <div class="container">

        <center>
            <h1 class="mb-4">E-COMMERCE PLATFORM</h1>
        </center>
        <center>
            <p class="clock" id="clock"></p>
        </center>
        <h1>This is Vendor Dashboard</h1>
        <a href="#" class="btn btn-danger btn-logout" onclick="confirmLogout()">Logout</a>
    </div>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = 'logout.php';
            }
        }


        function updateClock() {
            const clockElement = document.getElementById('clock');
            const currentTime = new Date();
            const hours = currentTime.getHours();
            const minutes = currentTime.getMinutes();
            const period = hours >= 12 ? 'pm' : 'am';


            const formattedHours = hours % 12 || 12;

            const formattedTime = `${formattedHours}:${minutes < 10 ? '0' : ''}${minutes} ${period}`;
            clockElement.innerText = formattedTime;
        }


        setInterval(updateClock, 1000);


        updateClock();
    </script>
</body>

</html>