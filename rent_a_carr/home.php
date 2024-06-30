
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first');</script>";
    echo "<script>window.location.href = 'rant_a_car.php';</script>";
    exit();
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
        .card {
          margin-bottom: 1rem;
        }
      </style>
  <title>Bootstrap Example</title>
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
                        <a class="nav-link" href="profile.html">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">Home</a>
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
          <!-- Car 1 -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <img class="card-img-top" src="car_se.png" alt="company">
              <div class="card-body">
                <h5 class="card-title">Select Car</h5>
                <p class="card-text">Choose from a variety of cars available for rent.</p>
              </div>
      
              <div class="card-footer text-center">
                <a href="company.php" class="btn btn-primary">select company</a>
                </div>
            </div>
          </div>
      
          <!-- Car 2 -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <img class="card-img-top" src="rating.png" alt="rating">
              <div class="card-body">
                <h5 class="card-title">Your Rating</h5>
             <p class="card-text">Rate your experience with our service.</p>
              </div>
              <div class="card-footer text-center">
                <a href="#" class="btn btn-primary">Go to Your Rating</a>
                </div>
            </div>
          </div>
      
          <!-- Car 3 -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <img class="card-img-top" src="dis.png" alt="discount">
              <div class="card-body">
                <h5 class="card-title">Discount Percentage</h5>
                <p class="card-text">Check out the latest discounts and offers.</p>
              </div>
              <div class="card-footer text-center">
                <a href="#" class="btn btn-primary">Go to Discount Percentage</a>
                </div>
            </div>
          </div>

</body>
</html>
