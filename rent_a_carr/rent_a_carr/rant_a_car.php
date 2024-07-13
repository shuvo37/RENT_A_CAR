<?php
session_start();
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


if (isset($_POST['login'])) {
  
    $usernameOrEmail = $conn->real_escape_string($_POST['usernameOrEmail']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if username or email and password match
    $sql = "SELECT * FROM create_account WHERE (email = '$usernameOrEmail' OR name = '$usernameOrEmail') AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

       // echo "<script>alert('Login successful');</script>";
        showAlert('Login successful.', 'success', 'home.php');
        //echo "<script>window.location.href = 'home.php';</script>"; 
        
    } else {
       // echo "<script>alert('Invalid email or password');</script>";
       // echo "<script>window.location.href = 'rant_a_car.php';</script>";
        showAlert('Invalid email or password.', 'error', 'rant_a_car.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mt-5">
          <div class="card-header text-center">
            <h3>Login</h3>
          </div>
          <div class="card-body">
            <form action="rant_a_car.php" method="post">
              <div class="mb-3">
                <label for="usernameOrEmail" class="form-label">Username or Email</label>
                <input type="text" class="form-control" id="usernameOrEmail" name="usernameOrEmail" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center mt-3">
            <a href="forget.php" class="text-decoration-none">Forgot Password?</a>
            <br><br>
            <a href="#" class="text-decoration-none">Reset Password</a>
            <br><br>
            <a href="new_account.php" class="text-decoration-none">Create New Account</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>