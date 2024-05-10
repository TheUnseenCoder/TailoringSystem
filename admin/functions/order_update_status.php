<?php
include '../../includes/conn.php';

$id = $_POST['id']; // Get the ID of the record to be updated
$newStatus = $_POST['status']; // Get the new status value from the AJAX request
$email = $_POST['email'];

$selector = "SELECT * FROM ts_orders WHERE email='$email' AND (order_status = 'packing order' OR order_status = 'ready to pick up')";
$selector_res = $conn->query($selector);
if($selector_res->num_rows > 0){
    updateStatus($conn, $newStatus, $id);
}

function updateStatus($conn, $newStatus, $id)
{
    $updateQuery = "UPDATE ts_orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newStatus, $id);

    if ($stmt->execute()) {
        // If update successful, send success response
        echo 'success';
    } else {
        // If update failed, send error response
        echo 'Something went wrong when updating the customization schedule status!';
    }
}

?>
