<?php
require 'connectdb.php';
session_start();
date_default_timezone_set('Asia/Dhaka');
 $company = 'company1';
$sql = "SELECT * FROM order_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $car_id = $row['car_id'];
        $ending_time = $row['end_datetime'];

        $endDateTimeObj = new DateTime($ending_time);

        if ($endDateTimeObj < new DateTime()) {
            $updateQry = "UPDATE car_info 
                          SET status ='available'
                          WHERE car_id = '$car_id'";
            $upd = $conn->query($updateQry);

            $deleteQry =  "DELETE FROM order_info WHERE car_id = '$car_id'";
            $upd = $conn->query($deleteQry);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Car - Rent A Car</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .car-container {
      max-height: 80vh; /* Set a max height for the container */
      overflow-y: auto; /* Enable vertical scrolling */
    }
    .card {
      margin-bottom: 1rem;
      position: relative; /* Ensure that the badge is positioned relative to the card */
    }
    .price-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 10px;
      font-size: 16px;
      font-weight: bold;
    }
  </style>
</head>
<body>

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

<div class="container mt-3 car-container">
    <h1 class="my-4 text-center">Select a Car</h1>
    <div class="text-center mb-3">
        <a href="duration.php" class="btn btn-primary">Order now!</a>
    </div>

    <div class="row">

        <?php
        $sql = "SELECT * FROM car_info where company = '$company'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $car_id = htmlspecialchars($row["car_id"]);
                $car_model = htmlspecialchars($row["car_model"]);
                $status = htmlspecialchars($row["status"]);
                $amount = htmlspecialchars($row["amount"]);
                $car_image = htmlspecialchars($row["car_image"]);

                echo '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="price-badge">$' . $amount . '</div>
                        <img class="card-img-top" src="' . $car_image . '" alt="Car Image">
                        <div class="card-body">
                            <h4 class="card-title">Model: ' . $car_model . '</h4>
                            <p class="card-text">Car ID: ' . $car_id . '</p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary">' . $status . '</button>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p class="col-12 text-center">There are no cars available.</p>';
        }

        $conn->close();
        ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
