<?php
// Include database connection
include("../includes/conn.php");

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require "../vendor/autoload.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $text = $_POST['text'];

    // Get current date and time with Metro Manila timezone
    $timestamp = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $timestamp_str = $timestamp->format('Y-m-d H:i:s');

    // Prepare and execute SQL statement to insert inquiry
    $stmt = $conn->prepare("INSERT INTO ts_inquiry (first_name, email, phone, gender, inquiry_text, timestamp) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $email, $phone, $gender, $text, $timestamp_str);
    $stmt->execute();

    // Initialize PHPMailer
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
        $mail->setFrom('barms.epcr@gmail.com', 'Tailoring System Inquiry');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'INQUIRY';
        $mail->Body    = 'Thank you for your inquiry. Please wait for the email from our Administrator.';

        // Send email
        $mail->send();
        // Send success message back to AJAX
        echo json_encode(array('success' => true, 'message' => 'Inquiry submitted successfully'));

    } catch (Exception $e) {
        // If sending email fails, send error message back to AJAX
        echo json_encode(array('success' => false, 'message' => 'Failed to send inquiry'));
    }
}
?>
