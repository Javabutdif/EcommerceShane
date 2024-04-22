 <?php 
     session_start();
    $con = mysqli_connect('localhost', 'root', '', 'db_event');

        $sqlTable = "SELECT id, name, email, contact FROM users WHERE role = 'Vendor'";
        $result = mysqli_query($con, $sqlTable);

        if($result) {
            $listPerson = [];   
            while($row = mysqli_fetch_assoc($result)) {
                $listPerson[] = $row;
            }
        } else {
            // Handle errors, such as invalid SQL or database connection issues
            echo "Error: " . mysqli_error($con);
        }

         if(isset($_POST["delete"])){
          $id = $_POST['idNum'];
        
          
          
         
          if(!$con) {
              die("Connection failed: " . mysqli_connect_error());
          }
        
              $sql = "DELETE FROM users WHERE id = '$id';";
        
              if (mysqli_query($con, $sql)) {
                echo '<script>alert("User has been deleted.");</script>';
        
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            
              mysqli_close($con);
        
        }
             if(isset($_POST["edit"])){
    $_SESSION["editNum"] = $_POST['idNum'];
    echo '<script>';
    echo 'window.location.href = "editAdmin.php";';
    echo '</script>';
  }
       
  ?>
       
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Vendors</title>
</head>
<body>
    <a class="btn btn-danger " href="admin.php">Back</a>
<h1 class="text-center">Registered Vendors Information</h1>
<br>

  <div class="container">
<table id="example" class="table table-striped table-hover display compact " style="width:100%">
    <thead  style="background-color: #144c94">
        <tr>
            <th class="text-white">ID</th>
            <th class="text-white">Name</th>
            <th class="text-white">Email</th>
            <th class="text-white">Contact</th>
            <th class="text-white">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($listPerson as $person): ?>
            <tr>
                <td><?php echo $person['id']; ?></td>
                <td><?php echo $person['name'] ?></td>
                <td><?php echo $person['email']; ?></td>
                <td><?php echo $person['contact']; ?></td>
              
               
                <td class="align-middle">
       <div  class="d-flex justify-content-center align-items-center gap-3">
    <form action="vendors.php" method="POST">
        <button type="submit" name="edit" class="btn btn-primary">Edit</button>
        <input type="hidden" name="idNum" value="<?php echo $person['id']; ?>"/>
        </form>
        <form action="vendors.php" method="POST" class="delete-form">
                            <input type="hidden" name="idNum" value="<?php echo $person['id']; ?>" />
                            <button type="submit" name="delete" class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to delete this Vendor?')">Delete</button>
                        </form>
        </div>
</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
  </div>

 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>


</body>
</html>
    
  <script>
new DataTable('#example');
  </script>

<script>
document.getElementById("deleteBtn").addEventListener("click", function() {
    if (confirm("Are you sure you want to delete this Student?")) {
        document.getElementById("deleteForm").submit();
    }
});
</script>