<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
session_start();
include 'conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/PHPMailer/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/PHPMailer/src/SMTP.php';
require '../fpdf/fpdf.php'; // Include FPDF library
date_default_timezone_set('Asia/Manila');

function generatePDF($base_price, $quantity, $total_additional, $payment_percent, $email, $payer_id, $transaction_id, $order_id, $current_date, $total_payment_rounded, $balance, $order_status, $total_amount, $payer_email, $payer_fullname, $account_fullname, $last_payment_date, $last_total_payment) {
    // Create a new FPDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('paid.png', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());


    // Set font styles
    $pdf->SetFont('Arial', 'B', 16); // Set font to bold
    $pdf->SetTextColor(0, 0, 0); // Set text color to black

    // Add centered title
    $pdf->Cell(0, 10, 'Tailoring System Receipt', 0, 1, 'C');
    // Set font back to normal
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(10);
    // Add payer details in one row
    $pdf->SetLineWidth(0.5); // Set line width
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Draw line from current position to the right edge of the page
    $pdf->Cell(0, 10, 'Account Fullname: ' . $account_fullname, 0, 0, 'L');
    $pdf->Cell(0, 10, 'Account Email: ' . $email, 0, 1, 'R');
    $pdf->Cell(0, 10, 'Payer Fullname: ' . $payer_fullname, 0, 0, 'L');
    $pdf->Cell(0, 10, 'Payer Email: ' . $payer_email, 0, 1, 'R');
    $pdf->Cell(0, 10, 'Payer ID: ' . $payer_id, 0, 0, 'L');
    $pdf->Cell(0, 10, 'Transaction ID: ' . $transaction_id, 0, 1, 'R'); // Align to the right corner
    $pdf->Cell(0, 10, 'Order ID: ' . $order_id, 0, 0, 'L'); // Align to the right corner
    $pdf->Cell(0, 10, 'Date: ' . $current_date, 0, 1, 'R'); // Align to the right corner
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Draw line from current position to the right edge of the page

    // Add details
    $pdf->Ln(5);
    $pdf->Cell(0, 10, 'Payment Details', 0, 1, 'R');
    $pdf->Cell(0, 10, 'Base Price: ', 0, 0, "L");
    $pdf->Cell(0, 10, 'Php. ' . number_format($base_price, 2), 0, 1, "R");
    $pdf->Cell(0, 10, 'Quantity: ', 0, 0, "L");
    $pdf->Cell(0, 10, $quantity, 0, 1, "R");
    $pdf->Cell(0, 10, 'Total Additional: ', 0, 0, "L");
    $pdf->Cell(0, 10, 'Php. ' . number_format($total_additional, 2), 0, 1, "R");
    
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Draw line from current position to the right edge of the page

    $pdf->Cell(0, 10, 'Total Amount: ', 0, 0, "L");
    $pdf->Cell(0, 10, 'Php. ' . number_format($total_amount, 2), 0, 1, "R");
    $pdf->Cell(0, 10, 'Initial Payment ('.$last_payment_date.') (70%) ', 0, 0, "L");
    $pdf->Cell(0, 10, 'Php. ' . $last_total_payment, 0, 1, "R");
    $pdf->Cell(0, 10, 'Balance (30%) ', 0, 0, "L");
    $pdf->Cell(0, 10, 'Php. ' . number_format($total_payment_rounded, 2), 0, 1, "R");

    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Draw line from current position to the right edge of the page
    $pdf->Ln(5);

    $pdf->Cell(0, 10, 'Total Payment(100%) ', 0, 0, "L");
    $pdf->Cell(0, 10, 'Php. ' . number_format($total_amount, 2), 0, 1, "R");
    // Output PDF content as string
    ob_start();
    $pdf->Output(); // Output PDF content
    $pdfContent = ob_get_clean();

    return $pdfContent; 
}

function sendEmailWithPDF($pdfContent, $email, $transaction_id) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'barms.epcr@gmail.com';                
        $mail->Password   = 'hpqcmincttoiwncc';                            
        $mail->SMTPSecure = "ssl";            
        $mail->Port       = 465;      

        // Email content
        $mail->setFrom('barms.epcr@gmail.com', 'Tailoring System Payment Receipt');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject = 'Payment Receipt for Transaction ID: ' . $transaction_id;
        $mail->Body    = 'Here is the payment receipt for your order. Please locate the attached PDF file.';
        $mail->addStringAttachment($pdfContent, 'Receipt.pdf', 'base64', 'application/pdf');

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    // Get current date
    
    $current_date = date('m-d-Y');
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $payer_email = $_POST['payer_email'];
    $payer_fullname = $_POST['payer_givenname'] . " " . $_POST['payer_familyname'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $variant = $_POST['variant'];
    $base_price = $_POST['base_price'];
    $total_additional = $_POST['total_additional'];
    $total_payment_rounded = $_POST['remaining_balance'];
    $balance = 0;
    $payer_id = $_POST['payer_id'];
    $transaction_id = $_POST['transaction_id'];
    $payment_status = "fully paid";


    $payment_checker="SELECT * FROM ts_payments WHERE order_id = '$order_id' LIMIT 1";
    $checker_result = $conn->query($payment_checker);
    if($checker_result){
        $row_check = $checker_result->fetch_assoc();
        $last_total_payment = $row_check['amount'];
        $total_amount = $last_total_payment + $total_payment_rounded;
        $last_payment_date = date("m-d-Y", strtotime($row_check['timestamp']));
         
    }
    $last_total_payment = $total_amount - $total_payment_rounded;

    $account_name_sel = "SELECT * FROM ts_users WHERE email = '$email'";
    $account_name_selres = $conn->query($account_name_sel);
    if($account_name_selres->num_rows > 0){
        $account_name_sel_row = $account_name_selres->fetch_assoc();
        $account_fullname = $account_name_sel_row['fullname'];
    }else{
        $account_fullname = $payer_fullname;
    }
    
    $selector = "SELECT * FROM ts_payments WHERE transaction_id = '$transaction_id'";
    $sel_res = $conn->query($selector);
    if($sel_res->num_rows < 1){
        $qty = "SELECT * FROM ts_products WHERE product_id='$product_id'";
        $qty_res = $conn->query($qty);
        $row_qty = $qty_res->fetch_assoc();
        if($row_qty['quantity'] >= $quantity){
            $current_qty = $row_qty['quantity'] - $quantity;
            $update_qty = "UPDATE ts_products SET quantity='$current_qty' WHERE product_id = '$product_id'";
            if($conn->query($update_qty)){
                $sql = "UPDATE ts_orders SET payment_status = '$payment_status' WHERE order_id = '$order_id'";
                $result = $conn->query($sql);
                if($result){
                    $sql2 = "INSERT INTO ts_payments SET transaction_id='$transaction_id', payer_id='$payer_id', buyer_email='$email', payer_fullname='$payer_fullname', payer_email='$payer_email', order_id='$order_id', amount='$total_payment_rounded', balance='$balance', payment_status='$payment_status'";
                    $result2 = $conn->query($sql2);
                    if($result2){ 
                        $pdfContent = generatePDF($base_price, $quantity, $total_additional, $payment_percent, $email, $payer_id, $transaction_id, $order_id, $current_date, $total_payment_rounded, $balance, $payment_status1, $total_amount, $payer_email, $payer_fullname, $account_fullname, $last_payment_date, $last_total_payment);
                            if (sendEmailWithPDF($pdfContent, $email, $transaction_id)) {
                                echo "success";
                            } else {
                                echo 'Failed to send email';
                            }
                    }else{
                        echo 'Failed to Insert Payment in the Database';
                    }
                }else{
                    echo 'Failed to Update Order in the Database';
                }   
            }else{
                echo 'Error Updating Product Quantity in the Database';
            }
        }else{
            echo 'Unfortunately you did not reach the remaining stock, Please try again.';
        }
    }else{
        echo "success";
    }
} else {
    echo "Invalid Request Type";
}
?>
