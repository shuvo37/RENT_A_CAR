
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body></body>

<?php
require('connectdb.php');

 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    // Insert data into database
    $sql = "INSERT INTO create_account (name, email, password, phone, address) VALUES ('$name', '$email', '$password', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "New account created successfully";
   
        
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;

    }

    // Close connection
    // $conn->close();
}




?>

</body>
</html>