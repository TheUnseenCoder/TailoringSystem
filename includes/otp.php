<?php 
include("conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "../vendor/autoload.php";

if (isset($_POST['user_name'])){

    $user_name = $_POST['user_name'];
    $date = date('Y-m-d H:i:s');

    try{
        $otp = random_int(100000, 999999);
    }catch (Exception $e){
        $otp = random_int(100000, 999999);
    }

    $sql = "UPDATE ts_users set reset_password_otp  = '$otp', reset_password_created_at = '$date' WHERE email = '$user_name'";
    if(mysqli_query($conn, $sql)){
        if(mysqli_affected_rows($conn)){
           
            $mail = new PHPMailer(true);

            try {
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
                $mail->addAddress($user_name);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Tailoring System Change Password OTP';
                $mail->Body    = 'Please DO NOT show this to anyone. Your OTP is <b>'.$otp.'</b>';

                if($mail->send())
                    echo 'success';
                else
                    echo 'Failed to send OTP through mail';
                
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        else{
            echo "RESET PASSWORD FAILED";
        }
    }
    else{
        echo "RESET PASSWORD FAILED WRONG EMAIL";
    }

}

?>