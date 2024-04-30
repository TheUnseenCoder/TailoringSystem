<?php
session_start();
include 'conn.php';

// Get the email from the request
$email = $_GET['email'];
$status = "approved";
$status2 = "pending";

// Query the database to check the status
$sql = "SELECT * FROM ts_customization WHERE email = ? AND (status = ? OR status = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $status, $status2);
$stmt->execute();
$result = $stmt->get_result();

$response = array(); // Initialize an array to store response data

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Fetch relevant data
    $description = $row['description'];
    $date = date('F j, Y', strtotime($row['date']));
    $time = date('g:i A', strtotime($row['time']));
    $datetime = $date . ' ' . $time;
    $status = $row['status'];
    
    // Build response array
    $response['success'] = true;
    $response['description'] = $description;
    $response['datetime'] = $datetime;
    $response['status'] = $status;
} else {
    // If no customization is scheduled
    $response['success'] = false;
    $response['message'] = "No customization is scheduled";
}

$stmt->close();
$conn->close();

// Encode response array to JSON and output
echo json_encode($response);
?>
