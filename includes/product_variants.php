<?php
include "conn.php";

// Fetch product variants based on product_id
if (isset($_GET['product_id'])) {
$product_id = $_GET['product_id']; // Assuming product_id is passed via GET parameter
$sql = "SELECT * FROM ts_products WHERE product_id = $product_id";
$result = $conn->query($sql);

// Check if there are any variants found
if ($result->num_rows > 0) {
    // Output JSON array of variants
    $variants = array();
    while($row = $result->fetch_assoc()) {
        $variants[] = $row['variants'];
    }
    echo json_encode($variants);
} else {
    echo "No variants found for this product";
}

$conn->close();
} else {
    // If product_id is not provided, return an empty response
    echo json_encode(array('error' => 'Product ID is missing'));
}
?>
