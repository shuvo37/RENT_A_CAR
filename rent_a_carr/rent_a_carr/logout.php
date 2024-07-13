<?php
// Function to show alert using SweetAlert2
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

// Starting session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Show alert using the function
showAlert('You have been logged out', 'success', 'rant_a_car.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- This page is intentionally left blank because the script handles the logout process -->
</body>
</html>
