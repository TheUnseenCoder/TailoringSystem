<?php
// products.php
include("conn.php");

// Fetch products from the database
$view = "SELECT * FROM ts_products";
$view_rs = $conn->query($view);

// Prepare an array to hold product data
$products = array();

// Loop through the database result and add each product to the array
while ($row1 = $view_rs->fetch_assoc()) {
    // Check if images field is empty or not
    if (!empty($row1['images'])) {
        // If images field is not empty, unserialize it
        $imageArray = unserialize($row1['images']);
        // Extract the first image URL
        $imageUrl = isset($imageArray[0]) ? "http://192.168.1.7/TailoringSystem/admin/" . $imageArray[0] : '';
    } else {
        // If images field is empty, use default image URL
        $imageUrl = "http://192.168.1.7/TailoringSystem/images/default-image-product.png";
    }

    // Create product array
    $product = array(
        'product_id' => $row1['product_id'],
        'name' => $row1['name'],
        'base_price' => $row1['base_price'],
        'image' => $imageUrl
    );

    // Add product to the products array
    array_push($products, $product);
}

// Return products data as JSON with unescaped slashes
echo json_encode($products, JSON_UNESCAPED_SLASHES);
?>
