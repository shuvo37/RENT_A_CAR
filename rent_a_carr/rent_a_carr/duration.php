<?php
require 'connectdb.php';
session_start();
$go_result_page = 0;
$error = '';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $startDateTime = $_POST['startDateTime'];
    $endDateTime = $_POST['endDateTime'];
    $car_id = $_POST['car_id'];
    $user_id = $_SESSION['user_id'];

    $startDateTimeObj = new DateTime($startDateTime);
    $endDateTimeObj = new DateTime($endDateTime);

    if ($startDateTimeObj < new DateTime()) {
        $error = 'The start date and time must be equal to or later than the current time.';
    } elseif ($startDateTimeObj >= $endDateTimeObj) {
        $error = 'The start date and time must be earlier than the end date and time.';
    } else {
        $sql = "SELECT * FROM order_info WHERE car_id = '$car_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error = 'This car is already ordered.';
        } else {
            $sql = "SELECT * FROM car_info WHERE car_id = '$car_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $amount_car = $row['amount'];
                $company = $row['company'];

                $interval = $startDateTimeObj->diff($endDateTimeObj);
                $hours = $interval->h + ($interval->days * 24);

                if ($hours < 1) {
                    $error = 'The duration should be at least 1 hour.';
                } else {
                    $go_result_page = 1;

                    $price = $hours * $amount_car;

                    $sql1 = "SELECT * FROM rating WHERE user_id = '$user_id'";
                    $result1 = $conn->query($sql1);

                     if($result1->num_rows == 1)
                     {

                        $row = $result1->fetch_assoc();
                        
                        $rating = $row['user_rating'];

                        if($rating >=5)
                        {

                            $price = 0;
                            $five = 5;
                            $updateQry1 = "UPDATE rating 
               SET user_rating = user_rating - $five
               WHERE user_id = '$user_id'";
               $upd1 = $conn->query($updateQry1);


                        }


                     }


                    $_SESSION['price'] = $price;
                    $_SESSION['startDateTime'] = $startDateTime;
                    $_SESSION['endDateTime'] = $endDateTime;
                    $_SESSION['car_id'] = $car_id;
                    $_SESSION['company'] = $company;

                }
            } else {
                $error = 'Car not found.';
            }
        }
    }
    
    if ($go_result_page == 1) {
        header("Location: order.php");
        exit();
    }
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Difference Calculator</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Rent-a-car</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    
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

    <div class="container mt-5">
        <h2 class="text-center">Date Difference Calculator</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form id="dateForm" action="duration.php" method="post" class="mt-4">
            <div class="form-group">
                <label for="car_id">Car Id</label>
                <input type="number" class="form-control" id="car_id" name="car_id" placeholder="Enter car id" required>
            </div>
            <div class="form-group">
                <label for="startDateTime">Select Start Date and Time</label>
                <input type="datetime-local" class="form-control" id="startDateTime" name="startDateTime" required>
            </div>
            <div class="form-group">
                <label for="endDateTime">Select End Date and Time</label>
                <input type="datetime-local" class="form-control" id="endDateTime" name="endDateTime" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">GO</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
