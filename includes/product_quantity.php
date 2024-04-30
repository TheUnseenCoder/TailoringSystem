<?php
// Assuming you have a database connection established already
session_start();
include("conn.php");
// Retrieve the product ID from the request
if (isset($_GET['product_id'])) {
$product_id = $_GET['product_id'];

// Query to fetch the current quantity of the product
$query = "SELECT quantity FROM ts_products WHERE product_id = $product_id";

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    // If the query fails, return an error response
    echo json_encode(array("error" => "Failed to fetch current quantity."));
    exit;
}

// Check if the product exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the current quantity from the result
    $row = mysqli_fetch_assoc($result);
    $current_quantity = $row['quantity'];

    // Return the current quantity as JSON response
    echo json_encode(array("current_quantity" => $current_quantity));
} else {
    // If the product does not exist, return an error response
    echo json_encode(array("error" => "Product not found."));
}

// Close the database connection
mysqli_close($conn);
} else {
    // If product_id is not provided, return an empty response
    echo json_encode(array('error' => 'Product ID is missing'));
}
?>
