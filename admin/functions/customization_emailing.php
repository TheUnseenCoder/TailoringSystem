<?php 
include '../../includes/conn.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require "../../vendor/autoload.php";

    // Get current date and time with Metro Manila timezone
    $timestamp = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $timestamp_str = $timestamp->format('Y-m-d');

    // Prepare and execute SQL statement to insert inquiry
    $select = "SELECT * FROM ts_customization WHERE date = '$timestamp_str' AND emailing_status = 0 AND status = 'approved'";
    $result = $conn->query($select);
    while($row = $result->fetch_assoc()){
        // Initialize PHPMailer
        $customize_id = $row['customize_id'];
        $email = $row['email'];
        $time = $row['time'];
        $formatted_time = date('g:i A', strtotime($time));
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
            $mail->setFrom('barms.epcr@gmail.com', 'Tailoring System Customization Schedule');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'CUSTOMIZATION SCHEDULE';
            $mail->Body    = 'Good Day! I am reminding you that you have an schedule today ' . $timestamp_str . ' at ' . $formatted_time;

            // Send email
            $mail->send();
            // Send success message back to AJAX
            echo "Emailed successfully ";
            $update = "UPDATE ts_customization SET emailing_status=1 WHERE customize_id = '$customize_id'";
            $results = $conn->query($update);
            if($results){
                echo "Updated successfull";
            }else{
                echo "Something Went Wrong ";
            }

        } catch (Exception $e) {
            // If sending email fails, send error message back to AJAX
            echo json_encode(array('success' => false, 'message' => 'Failed to send inquiry'));
        }
    }
?>
