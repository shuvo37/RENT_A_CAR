
<?php

require 'connectdb.php';
function showAlert($text, $icon, $redirect = null) {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            text: '$text',
            icon: '$icon',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {";
    if ($redirect) {
        echo "window.location.href = '$redirect';";
    }
    echo "}
        });
    });
    </script>";
  }

if (isset($_POST['submit'])) {

    // Debug alert to check if the form submission is detected
   
    // Retrieve and escape form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    

    // Check if the email already exists
    $sql = "SELECT id FROM create_account WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0  ) {
     //   echo "<script>alert('Email has already been taken');</script>";
       // echo "<script>window.location.href = 'new_account.php';</script>";
        showAlert('Email has already been taken.', 'info', 'new_account.php');
   
    } else if (strlen($password) < 4 || strlen($name)==0) {
       // echo "<script>alert('Password must be more than 3 characters or name error');</script>";
        //echo "<script>window.location.href = 'new_account.php';</script>";
        showAlert('Password must be more than 3 characters or name error.', 'info', 'new_account.php');
    
    } else {
        $qry = "INSERT INTO create_account (name, email, password, phone, address) VALUES ('$name', '$email', '$password', '$phone', '$address')";
        $insrt = $conn->query($qry);

        if ($insrt) {
            //echo "<script>alert('Account created successfully');</script>";
            //echo "<script>window.location.href = 'rant_a_car.php';</script>";
         
            showAlert('Account created successfully.', 'success', 'rant_a_car.php');
        } else {
          //  echo "<script>alert('Error occurred during record insertion');</script>";
           // echo "<script>window.location.href = 'new_account.php';</script>";
            showAlert('Error occurred during record insertion.', 'error', 'new_account.php');
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Create New Account</h5>
                        <form id="createAccountForm" method="post">
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
