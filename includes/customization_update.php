<?php
session_start();
include 'conn.php';

// Check if the email and status parameters are received
if(isset($_POST['email']) && isset($_POST['status'])) {
    // Get the email and status from the request
    $email = $_POST['email'];
    $status = $_POST['status'];
    $status2 = 'pending';
    $status3 = 'approved';

    // Log received parameters
    error_log("Email: " . $email);
    error_log("Status: " . $status);

    // Update the customization status
    $update = "UPDATE ts_customization SET status='$status' WHERE email='$email' AND (status = '$status2' OR status = '$status3')";
    $update_res = $conn->query($update);

    // Check if the query executed successfully
    if ($update_res) {
        echo "success"; 
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: Email or status parameters not received";
}

$conn->close();
?>
