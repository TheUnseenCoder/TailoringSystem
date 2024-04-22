<?php
// Include the database connection file
include '../../includes/conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if(isset($_POST['matrix_name']) && isset($_POST['size_name']) && isset($_POST['measurement_size']) && isset($_POST['additional']) && isset($_POST['measurement_name']) && is_array($_POST['measurement_name']) && is_array($_POST['measurement_size'])) {
        // Get the form data
        $matrix_name = $_POST['matrix_name'];
        $size_name = $_POST['size_name'];
        $additional = $_POST['additional'];

        // Convert measurement_name and measurement_size from string to arrays
        $measurement_names = $_POST['measurement_name'];
        $measurement_sizes = $_POST['measurement_size'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO ts_matrices (matrix_name, measurement_name, measurement_size, size_name, additional) VALUES (?, ?, ?, ?, ?)");

        // Loop through measurement names and insert data for each measurement separately
        foreach ($measurement_names as $key => $measurement_name) {
            // Check if measurement size is set for this measurement
            if (isset($measurement_sizes[$key])) {
                $measurement_size = $measurement_sizes[$key];
            } else {
                // If measurement size is not set, set it to empty string or NULL as needed
                $measurement_size = ""; // or NULL
            }
            
            // Bind parameters and execute the statement for each measurement
            $stmt->bind_param("sssss", $matrix_name, $measurement_name, $measurement_size, $size_name, $additional);
            if ($stmt->execute()) {
                // If execution is successful, continue looping
                continue;
            } else {
                // If execution fails, return error message
                echo "Error: " . $stmt->error . "<br>";
                break; // Break the loop if an error occurs
            }
        }

        // Close the statement
        $stmt->close();

        // If no error occurred during the loop, return success message
        if (!isset($stmt->error)) {
            echo "Success: AWIT GUYS";
        }
    } else {
        // If required fields are missing or measurement_name/measurement_size is not an array, return an error message
        echo "Error: Required fields are missing or measurement_name/measurement_size is not an array";
    }
} else {
    // If the form is not submitted via POST method, return an error message
    echo "Error: Form not submitted";
}

// Close the database connection
$conn->close();
?>
