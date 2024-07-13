<?php
require 'connectdb.php';
session_start();
date_default_timezone_set('Asia/Dhaka');

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
    $user_amount = $_POST['amount'];
    $req_amount = $_SESSION['price'];
    $car_id = $_SESSION['car_id'];
    $startDateTime =  $_SESSION['startDateTime'];
    $ending_time = $_SESSION['endDateTime'];
    $user_id = $_SESSION['user_id'];
    $company = $_SESSION['company'];

    $sql = "SELECT * FROM order_info WHERE car_id = '$car_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        showAlert('This car is already ordered', 'error', 'order.php');
    } else {
        if ($user_amount == $req_amount) {
            $qry = "INSERT INTO order_info (car_id, start_timedate, end_datetime) VALUES ('$car_id', '$startDateTime', '$ending_time')";
            $insrtorder = $conn->query($qry);

            
            if ($insrtorder) {
                showAlert('Successfully inserted', 'success', 'order.php');

              
                $updateQry = "UPDATE car_info SET status ='not available' WHERE car_id = '$car_id'";
                $conn->query($updateQry);

              
                $qry = "INSERT INTO history (car_id, company, starting_date, ending_date, amount, user_id) VALUES ('$car_id',  '$company', '$startDateTime', '$ending_time', '$user_amount', '$user_id')";
                $conn->query($qry);



                $sql1 = "SELECT * FROM rating WHERE user_id = '$user_id'";
                $result1 = $conn->query($sql1);
        
              
                    if ($result1->num_rows == 0) {
                        // Insert new record
                          $one = 1;
                        $qry = "INSERT INTO rating (user_id,user_rating) 
                                VALUES ('$user_id','$one')";
                        $insrt = $conn->query($qry);
        
                    } else {
                        // Update existing record
                        $one = 1;
                        $updateQry1 = "UPDATE rating 
                        SET user_rating = user_rating + $one 
                        WHERE user_id = '$user_id'";
                       $upd1 = $conn->query($updateQry1);
         
        
        
                    }
                

            } else {
                showAlert('Not inserted', 'error', 'order.php');
            }
        } else {
            showAlert('Given wrong amount of money', 'error', 'order.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment for Order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Rent-a-car</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="service.php">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5><?php echo 'Total Price: ' . $_SESSION['price'] . '$'; ?></h5>
                    <h5><?php echo 'Starting Date: ' . $_SESSION['startDateTime']; ?></h5>
                    <h5><?php echo 'Ending Date: ' . $_SESSION['endDateTime']; ?></h5>
                </div>
                <div class="card-footer">
                    <form method="post" action="order.php">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" name="submit">Order</button>
                        <a href="duration.php" class="btn btn-secondary mt-3">Order Again!</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
