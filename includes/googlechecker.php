<?php
ini_set ('display_errors', 1); ini_set ('display_startup_errors', 1); error_reporting (E_ALL); 
include "conn.php";

if(isset($_POST['email']) && isset($_POST['fullname'])){
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    $sql = "SELECT email FROM ts_users WHERE email = '$email'";
        if ($result =$conn->query($sql)) {
            if(mysqli_num_rows($result) > 0){
                echo "success";
            }else{
                echo"Sign Up with your gmail first.";
            }
        } else {
            echo $conn->connect_error;
        }
}    
else{
    echo "DID NOT GET ANY EMAIL AND FULLNAME";
}

?>