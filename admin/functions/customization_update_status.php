<?php
include '../../includes/conn.php';

$id = $_POST['id']; // Get the ID of the record to be updated
$newStatus = $_POST['status']; // Get the new status value from the AJAX request
$email = $_POST['email'];

$selector = "SELECT * FROM ts_customization WHERE email='$email' AND (status = 'approved' OR status = 'pending')";
$selector_res = $conn->query($selector);

if ($_POST['status'] == 'approved' || $_POST['status'] == 'pending') {
    if ($selector_res->num_rows > 0) {
        echo 'This schedule cannot be updated! The user have an approved schedule or new pending schedule!';
    } else {
        updateStatus($conn, $newStatus, $id);
    }
} else {
    updateStatus($conn, $newStatus, $id);
}

function updateStatus($conn, $newStatus, $id)
{
    $updateQuery = "UPDATE ts_customization SET status = ? WHERE customize_id = ?";
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
