<?php
include '../../includes/conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID and new account status from the form
    $user_id = $_POST['user_id'];
    $new_status = $_POST['account_status'];

    // Update the account status in the database
    $sql = "UPDATE ts_users SET account_status = '$new_status' WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the page where the update form was submitted from
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // If the form is not submitted via POST method, redirect to an error page or display an error message
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
