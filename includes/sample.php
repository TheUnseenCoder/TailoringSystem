<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
session_start();
include 'conn.php';
$order_id = 1;
$payment_checker="SELECT * FROM ts_payments WHERE order_id = '$order_id' LIMIT 1";
$checker_result = $conn->query($payment_checker);
if($checker_result){
    $row_check = $checker_result->fetch_assoc();
    $last_total_payment = $row_check['amount'];
    $last_payment_date = date("m-d-Y", strtotime($row_check['timestamp']));
     
}
echo $last_payment_date; 

?>
