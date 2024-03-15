<?php 
include("conn.php");

if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['otp']) && isset($_POST['confirm_password'])){

    $user_name = $_POST['user_name'];
    $new_password = md5($_POST['password']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $otp = $_POST['otp'];

    if ($password == $confirm_password){
        $sql = "UPDATE ts_users set password  = '$new_password', reset_password_otp = '', reset_password_created_at = '' WHERE email = '$user_name' and reset_password_otp = '$otp'";
        if(mysqli_query($conn, $sql)){
            if(mysqli_affected_rows($conn)){
                echo "success";
            }
            else{
                echo "RESET PASSWORD FAILED";
            }
        }
        else{
            echo "RESET PASSWORD FAILED WRONG OTP";
        }
    }
    else{
        echo "Passwords are not the same!";
    }
}
else{
    echo "ALL FIELDS ARE REQUIRED";
}

?>