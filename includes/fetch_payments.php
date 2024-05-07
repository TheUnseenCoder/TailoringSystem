<?php
include 'conn.php';
$_GET['email']="eull8902@gmail.com";
if(isset($_GET['email'])){
    $email = $_GET['email']; // Retrieve the email parameter

    // SQL query to fetch data
    $sql = "SELECT transaction_id, payer_id, payer_fullname, order_id, payment_status, timestamp FROM ts_payments WHERE buyer_email = '$email' ORDER BY order_id DESC, timestamp DESC";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Output data of each row
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        // Return JSON response
        echo json_encode($rows);
    } else {
        echo "0 results";
    }
    $conn->close();
} else {
    echo "There is no stored email!";
}
?>
