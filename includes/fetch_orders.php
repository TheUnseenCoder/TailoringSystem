<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'conn.php';
if(isset($_GET['email'])){
    $email = $_GET['email'];

    $sql = "SELECT ts_orders.order_id, ts_orders.email, ts_orders.product_id, ts_orders.size, ts_orders.variant, ts_orders.quantity, ts_products.name,
    ts_products.base_price, ts_products.description, ts_products.images, ts_orders.total_additional, ts_orders.payment_status, ts_orders.order_status, 
    (SELECT ts_payments.balance 
     FROM ts_payments 
     WHERE ts_orders.order_id = ts_payments.order_id 
     ORDER BY ts_payments.id DESC 
     LIMIT 1) AS balance,
    SUM(ts_payments.amount) AS amount
    FROM ts_orders 
    INNER JOIN ts_products ON ts_orders.product_id = ts_products.product_id 
    INNER JOIN ts_payments ON ts_orders.email = ts_payments.buyer_email AND ts_orders.order_id = ts_payments.order_id
    WHERE ts_orders.email = '$email' AND ts_orders.order_status != 'order received'
    GROUP BY ts_orders.order_id";


    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            // Handle images
            if($row['payment_status'] == "partially paid"){
                $row['payment_status']  = "Partially Paid";
            }elseif($row['payment_status'] == "fully paid"){
                $row['payment_status']  = "Fully Paid";
            }
            if($row['order_status'] == "packing order"){
                $row['order_status']  = "Packing Order";
            }elseif($row['order_status'] == "ready for pick up"){
                $row['order_status']  = "Ready for pick up";
            }elseif($row['order_status'] == "order received"){
                $row['order_status']  = "Order Received";
            }
            

            if (!empty($row['images'])) {
                $images = unserialize($row['images']);
                $row['images'] = "http://192.168.1.11/tailoringSystem/admin/" . $images[0]; // Get the first image
            } else {
                // Set default image URL
                $row['images'] = "http://192.168.1.11/tailoringSystem/images/default-image-product.png";
            }
            $row['total_additional'] = $row['total_additional'] * $row['quantity'];
            $row['size'] = $row['size'] . "(+ ₱" .  $row['total_additional'] . ")";
            $rows[] = $row;
        }
        // Return JSON response
        echo json_encode($rows, JSON_UNESCAPED_SLASHES);
    } else {
        echo "0 results";
    }
    $conn->close();
} else {
    echo "No email provided!";
}
?>
