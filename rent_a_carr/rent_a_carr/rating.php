<?php
require 'connectdb.php'; // Include your database connection file here
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



    $user_id = $_SESSION['user_id'];

    $sql1 = "SELECT * FROM rating WHERE user_id = '$user_id'";
    $result1 = $conn->query($sql1);

    if ($result1->num_rows == 0) {
        // Insert new record if user rating not found
        $zero = 0;
        $_SESSION['user_rating'] = $zero;
        showAlert('You have not rated yet.', 'info', 'rating.php');
    } else {
        // Display user rating if exists
        $row = $result1->fetch_assoc();
        $_SESSION['user_rating'] = $row['user_rating'];
       // showAlert("Your rating is $rating.", 'info', 'rating.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .car-container {
          max-height: 80vh; /* Set a max height for the container */
          overflow-y: auto; /* Enable vertical scrolling */
        }
      </style>
    <title>Rant-a-car</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Rant-a-car</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="service.html">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3 car-container">
    <h1 class="my-4 text-center">Select a Car</h1>
    <div class="row">
     
        <div class="col-lg-4 col-md-6 mb-4">

        <div class = "card center-content">
            <div class="card-header">
               
               <h3>Your rating</h3>

               
            </div>

            <div class="card-body">
               
              <p><strong><?php echo 'you have ordered '.$_SESSION['user_rating']?></strong></p>

               
            </div>

            <div class="card-footer">
               
               <p><strong><?php echo 'Every five order you will get one free'?></strong></p>
 
                
             </div>

             </div>
        </div>


</body>
</html>
