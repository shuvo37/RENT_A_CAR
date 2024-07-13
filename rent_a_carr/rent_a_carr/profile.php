<?php
require 'connectdb.php';
session_start();

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

// Fetch the image path from the database if it exists
$sql = "SELECT * FROM images WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    // Image found, set session variable for profile image
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_img'] = 'Images/' . $row['file'];
} else {
    // No image found, set default image path
    $_SESSION['user_img'] = 'pro.png'; // Adjust with your default image path
}

// Handle image upload
if(isset($_POST['submit'])) {
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = 'Images/' . basename($file_name); // Adjusted folder path
    $directory = 'Images';

    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }

    // Check if user already has an image record
    $sql = "SELECT * FROM images WHERE user_id = $user_id";
    $result1 = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result1) == 0) {
        // Insert new record if none exists
        $query = "INSERT INTO images (user_id, file) VALUES ('$user_id', '$file_name')";
        $result = mysqli_query($conn, $query);

        if($result) {
            // If insertion successful, move the uploaded file to the folder
            if(move_uploaded_file($tempname, $folder)) {
                $_SESSION['user_img'] = 'Images/' . $file_name; // Update session variable with new image path
              //  echo "<script>alert('File uploaded successfully');</script>";
              
                showAlert('File uploaded successfully', 'success', 'profile.php');
            
            } else {
                echo "<script>alert('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Error inserting file details into database');</script>";
        }
    } else {
        // Update existing record if user already has an image
        $updateQry = "UPDATE images SET file = '$file_name' WHERE user_id = $user_id";
        $res = $conn->query($updateQry);

        if($res) {
            // If update successful, move the uploaded file to the folder
            if(move_uploaded_file($tempname, $folder)) {
                $_SESSION['user_img'] = 'Images/' . $file_name; // Update session variable with new image path
               
           
                showAlert('File uploaded successfully', 'success', 'profile.php');
            } else {
                echo "<script>alert('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Error updating file details in database');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">rent-a-car</a>
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
                    <a class="nav-link" href="service.php">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Left side content (profile information, etc.) -->
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?php echo isset($_SESSION['user_img']) ? htmlspecialchars($_SESSION['user_img']) : 'pro.png'; ?>" class="rounded-circle mb-3" id="profileImage" alt="Profile Image" style="width: 150px; height: 150px;">
                    <h5 class="card-title"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?></h5>
                    
                    <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                        <input type="file" class="form-control bg-secondary mb-3" id="fileInput"  name="image" accept="image/*" onchange="previewImage(event)">
                        <button type="submit" name="submit" class="btn btn-primary">Upload Image</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- Right side content (transaction history) -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Transaction History</h5>
                    <ul class="list-group">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            $id = $_SESSION['user_id'];
                            $sql = "SELECT * FROM history WHERE user_id = ? ORDER BY starting_date DESC LIMIT 10";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $startDateTime = $row['starting_date'];
                                    $endDateTime = $row['ending_date'];
                                    $amount = $row['amount'];
                                    $company = $row['company'];
                                    $car_id = $row['car_id'];

                                    echo '<li class="list-group-item">
                                        <strong>Car ID:</strong> ' . htmlspecialchars($car_id) . '<br>
                                        <strong>Company:</strong> ' . htmlspecialchars($company) . '<br>
                                        <strong>Starting Date Time:</strong> ' . htmlspecialchars($startDateTime) . '<br>
                                        <strong>Ending Date Time:</strong> ' . htmlspecialchars($endDateTime) . '<br>
                                        <strong>Amount:</strong> ' . htmlspecialchars($amount) . '$<br>
                                    </li>';
                                }
                            } else {
                                echo '<li class="list-group-item">No transaction history found.</li>';
                            }
                            $stmt->close();
                        } else {
                            echo '<li class="list-group-item">Please log in to see your transaction history.</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('profileImage');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>
