<?php
include "conn.php";
// Get data from POST request

if(isset($_POST['email']) && isset($_POST['fullname'])){


    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    $selector = "SELECT email FROM ts_users WHERE email = '$email'";
    $result = mysqli_query($conn, $selector);
    if(mysqli_num_rows($result) > 0){
        echo "The email is already in use!";
    }else{
            // Insert data into database
        $sql = "INSERT INTO ts_users (email, fullname) VALUES ('$email', '$fullname')";
        if ($conn->query($sql)) {
            echo "success";
        } else {
            echo $conn->connect_error;
        }
    }    
}
else{
    echo "DID NOT GET ANY EMAIL AND FULLNAME";
}

?>