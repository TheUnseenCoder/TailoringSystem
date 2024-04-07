<?php
    session_start();
    include '../includes/conn.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require "../vendor/autoload.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);

    // Check if the request is a POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['signupAction'])) {
            // Signup action code here
    
            $fullname = $_POST["fullname"];
            $email = $_POST["signupEmail"];
            $password = md5($_POST["password"]); // Encrypt password using md5
            $confirmPassword = md5($_POST["confirm_password"]); // Encrypt confirmPassword using md5
            $otp = $_POST["otp"];
    
            // Perform validation
            if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword) || empty($otp)) {
                echo "All fields are required.";
            } elseif ($password != $confirmPassword) {
                echo "Passwords do not match.";
            } else {
                $sql_check_email = "SELECT * FROM ts_users WHERE email='$email'";
                $result_check_email = $conn->query($sql_check_email);
    
                if ($result_check_email->num_rows > 0) {
                    echo "Email already exists.";
                } else {
                    $sql_selector = "SELECT * FROM ts_signup_otp WHERE email='$email' AND otp='$otp'";
                    $result_selector = $conn->query($sql_selector);
                    if ($result_selector->num_rows == 1) {
                        $sql_insert_user = "INSERT INTO ts_users (fullname, email, password, usertype, account_status) VALUES ('$fullname', '$email', '$password', '1', '1')";
                        if ($conn->query($sql_insert_user) === TRUE) {
                            echo "success";
                        } else {
                            echo "Error: " . $conn->error;
                        }
                    } else {
                        echo "Invalid OTP";
                    } 
                }
            }
    
        } elseif (isset($_POST['otpAction'])) {
            // OTP verification action
            $email = $_POST["signupEmail"];
            if (empty($email)) {
                echo "Email is Required";
            } else {
                $sql_check_email = "SELECT * FROM ts_users WHERE email='$email'";
                $result_check_email = $conn->query($sql_check_email);
    
                if ($result_check_email->num_rows > 0) {
                    echo "Email already exists.";
                } else {
                    $sql_check_otp = "SELECT * FROM ts_signup_otp WHERE email='$email'";
                    $result_check_otp = $conn->query($sql_check_otp);
                    
                    if ($result_check_otp->num_rows > 0) {
                        echo "OTP ALREADY BEEN SENT";
                    } else {
                        $otp = mt_rand(100000, 999999);
                        try {
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
                            $mail->isHTML(true);                                  
                            $mail->Subject = 'Tailoring System OTP';
                            $mail->Body    = 'Please DO NOT show this to anyone. Your OTP is <b>'.$otp.'</b>';
            
                            if($mail->send()){
                                $sql_store_otp = "INSERT INTO ts_signup_otp (email, otp) VALUES ('$email', '$otp')";
                                if ($conn->query($sql_store_otp) === TRUE) {
                                    echo "success";
                                } else {
                                    echo "Error: Storing OTP.";
                                }
                            } else{
                                echo "Error: Failed to send OTP through mail";
                            }
                            
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    
                    }
                }
            }
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Invalid request method.";
    }

    $conn->close();
?>
