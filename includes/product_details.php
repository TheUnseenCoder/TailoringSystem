<?php
session_start();
include("conn.php");

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    $query = "SELECT 
                name AS product_name,
                description AS product_description,
                images,
                variants,
                base_price
            FROM 
                ts_products
            WHERE 
                product_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $images = unserialize($row['images']);

        // Adjust image paths
        foreach ($images as &$image) {
            if (empty($image)) {
                $image = 'http://192.168.1.11/TailoringSystem/images/default-image-product.png';
            } else {
                $image = 'http://192.168.1.11/TailoringSystem/admin/' . $image;
            }
        }

        $product_details = array(
            'product_name' => $row['product_name'],
            'product_description' => $row['product_description'],
            'base_price' => $row['base_price'],
            'images' => $images
        );

        $stmt->close();

        // Return the product details as JSON
        echo json_encode(array('product_details' => $product_details), JSON_UNESCAPED_SLASHES);
    } else {
        // If no data found, return an empty response
        echo json_encode(array('error' => 'No product details found for the given ID'));
    }

    $conn->close();
} else {
    // If product_id is not provided, return an empty response
    echo json_encode(array('error' => 'Product ID is missing'));
}
?>
