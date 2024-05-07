<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
session_start();
include 'conn.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $sql = "UPDATE ts_orders SET order_status = 'order received' WHERE order_id = '$order_id'";
    $result = $conn->query($sql);
    if($result){
        echo "success";
    }else{
        echo "Something went wrong in updating the order status";
    }
} else {
    echo "Invalid Request Type";
}
?>