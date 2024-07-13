
<?php
require 'connectdb.php';
$userId = $_GET['user_id'];

// Update the is_apply status after 40 seconds
$updateQuery = "UPDATE apply_for_loan SET is_apply = 1 WHERE user_id = '$userId' AND is_apply = 0 ORDER BY apply_time DESC LIMIT 1";
$conn->query($updateQuery);

header('Location: apply_for_loan.php');
exit;
?>