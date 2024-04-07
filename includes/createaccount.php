<?php 
include("conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "../vendor/autoload.php";
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['fullname']) && isset($_POST['confirm_password']) && isset($_POST['mobile_number'])){

    $user_name = $_POST['user_name'];
    $new_password = md5($_POST['password']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $mobile_number = $_POST['mobile_number'];
    $fullname = $_POST['fullname'];

    if ($password == $confirm_password){
            $selector = "SELECT * FROM ts_users WHERE email = '$user_name'";
            $result = mysqli_query($conn, $selector);
            if(mysqli_num_rows($result) > 0){
                echo "Email Address is Already used!";
            }
            else{            
                $sql = "INSERT INTO ts_users (email, fullname, password, ) VALUES ('$user_name', '$fullname', '$new_password', '$mobile_number')";
                if(mysqli_query($conn, $sql)){
                        echo "success";                 
                }
                else{
                    echo "Account Creation Failed!";
                }
            }
    }else{
        echo "Passwords are not the same!";
    }
}   
else{
    echo "ALL FIELDS ARE REQUIRED";
}

?>