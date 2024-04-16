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
        // Check if the form data contains the signup action
        if(isset($_POST['signupAction'])) {
            // Your existing signupAction code here
    
            // Example of logging an error message
            error_log("Debug information: Signup action was triggered.");
    
            $fullname = $_POST["fullname"];
            $mobileNum = $_POST["mobileNum"];
            $email = $_POST["signupEmail"];
            $password = md5($_POST["signupPassword"]); // Encrypt password using md5
            $confirmPassword = md5($_POST["confirmPassword"]); // Encrypt confirmPassword using md5
            $otp = $_POST["otp"];
    
            // Perform validation
            if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword) || empty($otp)) {
                // Return error response if any field is empty
                echo json_encode(["success" => false, "message" => "All fields are required."]);
            } elseif ($password != $confirmPassword) {
                // Return error response if passwords do not match
                echo json_encode(["success" => false, "message" => "Passwords do not match."]);
            } else {
                // Check if the email already exists
                $sql_check_email = "SELECT * FROM ts_users WHERE email='$email'";
                $result_check_email = $conn->query($sql_check_email);
    
                if ($result_check_email->num_rows > 0) {
                    // Return error response if email already exists
                    echo json_encode(["success" => false, "message" => "Email already exists."]);
                } else {
                    // Insert user into the ts_users table
                    $sql_selector = "SELECT * FROM ts_signup_otp WHERE email='$email' AND otp='$otp'";
                    $result_selector = $conn->query($sql_selector);
                    if ($result_selector->num_rows == 1) {
                        $sql_insert_user = "INSERT INTO ts_users (fullname, email, password, usertype, account_status) VALUES ('$fullname', '$email', '$password', '1', '1')";
                        if ($conn->query($sql_insert_user) === TRUE) {
                            echo json_encode(["success" => true, "message" => "Signup successful!"]);
                        } else {
                            // Return error response if insertion fails
                            echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
                        }
                    }else{
                        echo json_encode(["success" => false, "message" => "Invalid OTP"]);
                    } 
                }
            }
    
        } elseif (isset($_POST['otpAction'])) {
            // OTP verification action
            $email = $_POST["signupEmail"];
            if (empty($email)) {
                // Return error response if any field is empty
                echo json_encode(["success" => false, "message" => "Email is Required"]);
            }else{
                $sql_check_email = "SELECT * FROM ts_users WHERE email='$email'";
                $result_check_email = $conn->query($sql_check_email);
    
                if ($result_check_email->num_rows > 0) {
                    // Return error response if email already exists
                    echo json_encode(["success" => false, "message" => "Email already exists."]);
                } else {
                    // Check if the OTP matches the one stored in the database
                    $sql_check_otp = "SELECT * FROM ts_signup_otp WHERE email='$email'";
                    $result_check_otp = $conn->query($sql_check_otp);
                    
                    if ($result_check_otp->num_rows > 0) {
                        echo json_encode(["success" => false, "message" => "OTP ALREADY BEEN SENT"]);
                    } else {
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
                            $mail->Body    = 'Please DO NOT show this to anyone. Your OTP is <b>'.$otp.'</b>';
            
                            if($mail->send()){
                                $sql_store_otp = "INSERT INTO ts_signup_otp (email, otp) VALUES ('$email', '$otp')";
                                if ($conn->query($sql_store_otp) === TRUE) {
                                    // Return success response with OTP
                                    echo json_encode(["success" => true, "message" => "OTP has been send to your email"]);
                                } else {
                                    // Error storing OTP
                                    echo json_encode(["success" => false, "message" => "Error storing OTP."]);
                                }
                            }     
                            else{
                                echo json_encode(["success" => false, "message" => "Failed to send OTP through mail"]);
                            }
                            
                        } catch (Exception $e) {
                            echo json_encode(["success" => false, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                        }
                    
                    }
                }
            }
        } else {
            // Return error response for invalid action
            echo json_encode(["success" => false, "message" => "Invalid action."]);
        }
    } else {
        // Return error response for invalid request method
        echo json_encode(["success" => false, "message" => "Invalid request method."]);
    }

    $conn->close();
?>
