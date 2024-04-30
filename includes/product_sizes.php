<?php
session_start();
include("conn.php");

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    $query = "SELECT 
            DISTINCT
                size_name
            FROM 
                ts_matrices_associate ma
            INNER JOIN 
                ts_matrices m ON ma.matrix_name = m.matrix_name
            WHERE 
                ma.product_id = ?
            ORDER BY 
                m.size_name DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sizes = array();

        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row['size_name'];
        }

        $stmt->close();

        // Return the sizes as JSON
        echo json_encode($sizes);
    } else {
        // If no data found, return an empty response
        echo json_encode(array('error' => 'No sizes found for the given product ID'));
    }

    $conn->close();
} else {
    // If product_id is not provided, return an empty response
    echo json_encode(array('error' => 'Product ID is missing'));
}
?>
