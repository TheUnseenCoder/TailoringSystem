<?php
include '../../includes/conn.php';

$id = $_POST['id']; // Get the ID of the record to be updated
$newStatus = $_POST['status']; // Get the new status value from the AJAX request
$email = $_POST['email'];

// Check if the new status is 'approved' or 'pending'
if ($newStatus == 'approved' || $newStatus == 'pending') {
    // Query to check if the user has an existing approved schedule
    $selector = "SELECT * FROM ts_customization WHERE email='$email' AND status = 'approved'";
    $selector_res = $conn->query($selector);

    // If there is an existing approved schedule for the user
    if ($selector_res->num_rows > 0) {
        echo 'This schedule cannot be updated! The user already has an approved schedule.';
    } else {
        // Update the status if there are no existing approved schedules
        updateStatus($conn, $newStatus, $id);
    }
} else {
    // If the new status is neither 'approved' nor 'pending', update the status without any additional checks
    updateStatus($conn, $newStatus, $id);
}

// Function to update the status in the database
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
