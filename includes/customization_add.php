<?php
session_start();
include 'conn.php';

// Get the email from the request
$email = $_POST['email'];
$description = $_POST['description'];
$date = $_POST['date'];
$time = $_POST['time'];
$status = 'pending';
$status2 = 'approved';

// Query the database to check the status
$sql = "SELECT * FROM ts_customization WHERE email = ? AND status = ? OR status = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $status, $status2);
$stmt->execute();
$result = $stmt->get_result();

$response = array(); // Initialize an array to store response data

if ($result->num_rows > 0) {
    echo "Error: You still have a pending schedule";    
} else {
    
    $insert = "INSERT ts_customization SET email='$email', description='$description', date='$date', time='$time'";
    $insert_res = $conn->query($insert);
    if($insert_res){
        echo "success"; 
    }else{
        echo "Error: Something went wrong upon submitting the schedule";    
    }
    
    
}

$stmt->close();
$conn->close();

?>
