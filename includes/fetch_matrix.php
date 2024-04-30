<?php
// Include your database connection code here
session_start();
include 'conn.php';

// Check if the product ID is provided in the query string
if (isset($_GET['product_id'])) {
    // Get the product ID from the query string
    $product_id = $_GET['product_id'];
    
    // Fetch the matrix name associated with the product ID
    $select = "SELECT * FROM ts_matrices_associate WHERE product_id = '$product_id'";
    $result = $conn->query($select);
    
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $matrix_name = $row['matrix_name'];
        
        // Prepare the SQL statement to fetch measurements for the matrix
        $measurement_query = "SELECT DISTINCT size_name, measurement_name, measurement_size, additional FROM ts_matrices WHERE matrix_name = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($measurement_query);

        // Bind the parameter
        $stmt->bind_param("s", $matrix_name);

        // Execute the query
        $stmt->execute();

        // Get the result
        $measurement_result = $stmt->get_result();

        // Check if there are measurements available
        if ($measurement_result->num_rows > 0) {
            // Initialize an array to store measurements for each size
            $measurements_by_size = array();

            // Fetch and organize measurements by size
            while ($measurement_row = $measurement_result->fetch_assoc()) {
                $size_name = $measurement_row['size_name'];
                $measurement_name = $measurement_row['measurement_name'];
                $measurement_size = $measurement_row['measurement_size'];
                $additional = $measurement_row['additional'];
                // Store measurements by size name
                $measurements_by_size[$size_name][$measurement_name] = array('measurement_size' => $measurement_size, 'additional' => $additional);
            }

            // Return the measurements as JSON
            echo json_encode($measurements_by_size);
        } else {
            // If no measurements found, return empty content
            echo json_encode(array('error' => 'No Measurement Available'));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array('error' => 'No Matrix Associated with Product'));
    }
} else {
    // If product_id is not provided, return an empty response
    echo json_encode(array('error' => 'Product ID is missing'));
}
?>
