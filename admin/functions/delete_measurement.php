<?php
include '../../includes/conn.php';

// Check if the request is POST and if matrix_name_base64 is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matrix_number'])) {
    // Decode matrix_name_base64
    $matrix_number = $_POST['matrix_number'];

    // Delete the item from the database
    $deleteQuery = "DELETE FROM ts_matrices WHERE matrix_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $matrix_number);
    $stmt->execute();

    // Check if the deletion was successful
    if($stmt->affected_rows > 0){   
        echo "success";
    } else {
        echo "error";
    }

    // Close the statement
    $stmt->close();
} else {
    // If request is not POST or matrix_name_base64 is not set
    echo "error";
}
?>
