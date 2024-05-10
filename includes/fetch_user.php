<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'conn.php';
if(isset($_GET['email'])){
    $email = $_GET['email'];

    $sql = "SELECT profile, fullname, mobile_number FROM ts_users where email = '$email'";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $response = array(
            'profile' => base64_encode($row['profile']),
            'fullname' => $row['fullname'],
            'contact' => $row['mobile_number']
        );
        echo json_encode($response);
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    echo "No email provided!";
}
?>
