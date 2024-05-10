<?php
// Include your database connection code here
session_start();
include 'conn.php';

    $email = $_GET['email'];
    $fullname = $_GET['fullname'];
    $contact_num = $_GET['contact_num'];
    
    // Fetch the matrix name associated with the product ID
    $select = "SELECT * FROM ts_users WHERE email = '$email'";
    $result = $conn->query($select);
    
    if($result->num_rows > 0){
        $update = "UPDATE ts_users SET fullname='$fullname', mobile_number='$contact_num' WHERE email = '$email'";
        $updateres = $conn->query($update);
        if($updateres){
            echo json_encode('success');
        }else{
            echo json_encode(array('error' => 'Something went wrong when updating your profile.'));
        }
    } else {
        echo json_encode(array('error' => 'Please Login First'));
    }

?>
