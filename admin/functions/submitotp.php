<?php
// Set error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

session_start();
include '../../includes/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "../../vendor/autoload.php";



// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form data contains the signup action
    if(isset($_POST['signupAction'])) {
        $id = $_POST['id'];
        // Check if the email already exists
        $sql_check_email = "SELECT * FROM ts_users WHERE id='$id'";
        $result_check_email = $conn->query($sql_check_email);
        if ($result_check_email->num_rows > 0) {
            $admin = $result_check_email->fetch_assoc();
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            if(isset($_POST['password'])){
                $password = md5($_POST["password"]); 
                $confirmPassword = md5($_POST["confirmPassword"]); 
            }else{
                $password = $admin['password'];
                $confirmPassword = $admin['password'];
            }     
            if(isset($_FILES["profile"]) && $_FILES["profile"]["error"] == 0){
                $imageData = file_get_contents($_FILES["profile"]["tmp_name"]);
                $profile = mysqli_real_escape_string($conn, $imageData);
            }else{ 
                $profile = mysqli_real_escape_string($conn, $admin['profile']);
            }
            $otp = $_POST["otp"];
            error_log("Decoded profile data: " . $profile);
            // Perform validation
            if (empty($fullname) || empty($email) || empty($password) || empty($otp)) {
                // Return error response if any field is empty
                echo json_encode(["success" => false, "message" => "All fields are required."]);
                error_log("All fields are required.");
            } elseif ($password != $confirmPassword) {
                // Return error response if passwords do not match
                echo json_encode(["success" => false, "message" => "Passwords do not match."]);
                error_log("Passwords do not match.");
            } else {
                // Insert user into the ts_users table
                $sql_selector = "SELECT * FROM ts_users WHERE id='$id' AND otp='$otp'";
                $result_selector = $conn->query($sql_selector);
                if ($result_selector->num_rows == 1) {
                    $sql_update_user = "UPDATE ts_users SET fullname = '$fullname', email = '$email', profile='$profile', password = '$password', otp=NULL WHERE id = '$id'";
                    if ($conn->query($sql_update_user) === TRUE) {
                        echo json_encode(["success" => true, "message" => "Signup successful!"]);
                    } else {
                        // Return error response if insertion fails
                        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
                        error_log("Error updating user: " . $conn->error);
                    }
                } else {
                    echo json_encode(["success" => false, "message" => "Invalid OTP"]);
                    error_log("Invalid OTP.");
                } 
            }
        } else {
            echo json_encode(["success" => false, "message" => "Invalid Update Profile ID"]);
            error_log("Invalid Update Profile ID.");
        }
    
    } elseif (isset($_POST['otpAction'])) {
        // OTP verification action
        $email = $_POST["email"];
        $id = $_POST["id"];
        if (empty($email)) {
            // Return error response if any field is empty
            echo json_encode(["success" => false, "message" => "Email is Required"]);
            error_log("Email is Required.");
        } else {
            $sql_check_email = "SELECT * FROM ts_users WHERE id='$id'";
            $result_check_email = $conn->query($sql_check_email);

            if ($result_check_email->num_rows > 0) {
                $otp = mt_rand(100000, 999999);
                try {
                    // Initialize PHPMailer
                    $mail = new PHPMailer(true);
                    
                    //Server settings
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                 
                    $mail->Username   = 'barms.epcr@gmail.com';                
                    $mail->Password   = 'hpqcmincttoiwncc';                            
                    $mail->SMTPSecure = "ssl";            
                    $mail->Port       = 465;         

                    //Recipients
                    $mail->setFrom('barms.epcr@gmail.com', 'Tailoring System OTP');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Tailoring System Email Verification OTP';
                    $mail->Body    = 'Good Day Administrator! Please DO NOT show this to anyone. Your OTP is <b>'.$otp.'</b>';

                    if($mail->send()){
                        $sql_store_otp = "UPDATE ts_users SET otp='$otp' WHERE id='$id'";
                        if ($conn->query($sql_store_otp) === TRUE) {
                            // Return success response with OTP
                            echo json_encode(["success" => true, "message" => "OTP has been sent to your email"]);
                        } else {
                            // Error storing OTP
                            echo json_encode(["success" => false, "message" => "Error storing OTP."]);
                            error_log("Error storing OTP: " . $conn->error);
                        }
                    } else {
                        echo json_encode(["success" => false, "message" => "Failed to send OTP through mail"]);
                        error_log("Failed to send OTP through mail.");
                    }
                    
                } catch (Exception $e) {
                    echo json_encode(["success" => false, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
                
            } else {           
                echo json_encode(["success" => false, "message" => "Invalid User"]);
                error_log("Invalid User.");
            }
        }
    } else {
        // Return error response for invalid action
        echo json_encode(["success" => false, "message" => "Invalid action."]);
        error_log("Invalid action.");
    }
} else {
    // Return error response for invalid request method
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    error_log("Invalid request method.");
}

$conn->close();
?>
