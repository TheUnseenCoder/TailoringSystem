<?php
include '../../includes/conn.php';

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if(isset($_POST['measurement_name']) && isset($_POST['measurement_size']) && isset($_POST['size_name']) && isset($_POST['additional']) && isset($_POST['matrix_id'])) {
        // Get form data
        $matrix_id = $_POST['matrix_id'];
        $measurement_name = $_POST['measurement_name'];
        $measurement_size = $_POST['measurement_size'];
        $size_name = $_POST['size_name'];
        $additional = $_POST['additional'];

        // Update the matrix
        $matrixQuery = "UPDATE ts_matrices SET measurement_name = ?, measurement_size = ?, size_name = ?, additional = ? WHERE matrix_id = ?";
        $stmt = $conn->prepare($matrixQuery);
        $stmt->bind_param("ssssi", $measurement_name, $measurement_size, $size_name, $additional, $matrix_id);
        $stmt->execute();
        
        // Check if the update was successful
        if($stmt->affected_rows > 0){   
            echo "Success: Matrix updated successfully!";
        } else {
            echo "Error: Something went wrong during update.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Please fill all the required fields!";
    }
} else {
    echo "Error: Invalid Action!";
}
?>
