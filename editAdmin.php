<?php
    session_start();

    

        $con = mysqli_connect('localhost', 'root', '', 'db_event');
        $idNum = $_SESSION["editNum"];
		$sql = "SELECT * FROM users WHERE id = '$idNum'";
		$result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if($user["id"] != null){
			
			$_SESSION['id_number'] = $user["id"];
			$_SESSION['name'] = $user["name"];
			$_SESSION['email'] = $user["email"];
			$_SESSION['contact'] = $user["contact"];
			$_SESSION['role'] = $user["role"];
	
		
		
		}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<form action="editAdmin.php" method="POST">
<section class="vh-100">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                <a class="btn btn-danger" href="admin.php">Back</a>
                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Edit Profile</p>
                <form class="mx-1 mx-md-4">
                    <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="idnum" class="form-control" name="idnum" value="<?php echo $_SESSION['id_number'] ?>" readonly />
                      <label class="form-label" for="idnum">ID </label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="lName" class="form-control" name="lName" value="<?php echo $_SESSION['name'] ?>" required />
                      <label class="form-label" for="lName">Name</label>
                    </div>
                  </div>
                  

                  
                  <div class="d-flex flex-row align-items-center mb-4">
                  
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="email" id="email" class="form-control" value="<?php echo $_SESSION['email'] ?>" name="email" readonly />
                      <span id="email-response" style="font-family: 'Source Sans Pro'; font-size:0.8em; color:red; font-weight:bold; display:block;"></span>
                      <label class="form-label" for="email">Email</label>
                    </div>
                    
                  </div>
                  
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="contact" class="form-control" value="<?php echo $_SESSION['contact'] ?>" name="contact" required />
                      <label class="form-label" for="address">Contact</label>
                    </div>
                  </div>
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" value="<?php echo $_SESSION['role'] ?>" id="role" class="form-control" name="role" readonly />
                      <label class="form-label" for="role">Role</label>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button class="btn btn-primary btn-lg" type="submit" name="submitEdit">Save Changes</button>
                  </div>
                </form>
              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="/INSURANCE/sign.webp" class="img-fluid" alt="Sample image">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</form>
    
</body>
</html>

<?php
$con = mysqli_connect('localhost', 'root', '', 'db_event');






// get the post records
if(isset($_POST["submitEdit"])){
$idNum =$_POST['idnum'];
$Name = $_POST['lName'];
$contact = $_POST['contact'];
$email = $_POST['email'];


// database insert SQL code

$sql = "UPDATE `users` SET  `name` = '$Name', `contact`= '$contact' WHERE `id` = '$idNum'";
 

// insert in database 
if (mysqli_query($con, $sql)) {
	
  echo "<script>Swal.fire({
    title: 'Notification',
    text: 'Edit Profile Successfull',
    icon: 'success',
    showConfirmButton: false,
    timer: 1500
  });</script>";

	        $_SESSION['id_number'] = "";
			$_SESSION['fname'] = "";
			$_SESSION['lname'] = "";
			$_SESSION['contact'] ="";
			$_SESSION['email'] = "";
			$_SESSION['role'] ="";
}
else{
	
  
}

}



// Close connection
mysqli_close($con);
?>
