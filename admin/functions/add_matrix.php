<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../includes/conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $matrix_name = $_POST['matrix_name'];
    $size_name = $_POST['size_name'];
    $measurement_name = $_POST['measurement_name'];
    $measurement_size = $_POST['measurement_size'];
    $additional = $_POST['additional'];

    // Prepare SQL statement to select matrix based on name and size
    $select_stmt = $conn->prepare("SELECT * FROM ts_matrices WHERE matrix_name = ? AND size_name = ?");
    $select_stmt->bind_param("ss", $matrix_name, $size_name);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    // Check if matrix with the same name and size exists
    if ($result->num_rows > 0) {
        echo "Matrix with the same name and size already exists.";
    } else {
        // Prepare and bind SQL statement
        $insert_stmt = $conn->prepare("INSERT INTO ts_matrices (matrix_name, measurement_name, measurement_size, size_name, additional) VALUES (?, ?, ?, ?, ?)");

        // Bind parameters and execute statement for each set of measurement data
        for ($i = 0; $i < count($measurement_name); $i++) {
            $insert_stmt->bind_param("sssss", $matrix_name, $measurement_name[$i], $measurement_size[$i], $size_name, $additional);
            $insert_stmt->execute();
        }

        // Check if all data inserted successfully
        if ($insert_stmt->affected_rows === count($measurement_name)) {
            echo "Matrix added successfully!";
        } else {
            echo "Error: Failed to add matrix.";
        }

        // Close insert statement
        $insert_stmt->close();
    }

    // Close select statement and connection
    $select_stmt->close();
    $conn->close();
}
?>
