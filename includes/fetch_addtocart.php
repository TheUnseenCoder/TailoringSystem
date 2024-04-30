<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'conn.php';
if(isset($_GET['email'])){
    $email = $_GET['email'];

    $sql = "SELECT ts_addtocart.id, ts_addtocart.email, ts_addtocart.product_id, ts_addtocart.size, ts_addtocart.variant, ts_addtocart.quantity, ts_products.name, ts_products.base_price, ts_products.images, SUM(ts_matrices.additional) AS total_additional
            FROM ts_addtocart 
            INNER JOIN ts_products ON ts_addtocart.product_id = ts_products.product_id 
            LEFT JOIN ts_matrices_associate ON ts_addtocart.product_id = ts_matrices_associate.product_id
            LEFT JOIN ts_matrices ON ts_matrices_associate.matrix_name = ts_matrices.matrix_name AND ts_matrices.size_name = ts_addtocart.size
            WHERE ts_addtocart.email = '$email'
            GROUP BY ts_addtocart.size";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            // Handle images
            if (!empty($row['images'])) {
                $images = unserialize($row['images']);
                $row['images'] = "http://192.168.1.11/tailoringSystem/admin/" . $images[0]; // Get the first image
            } else {
                // Set default image URL
                $row['images'] = "http://192.168.1.11/tailoringSystem/images/default-image-product.png";
            }
        
            $row['size'] = $row['size'] . "(+ ₱" . $row['total_additional'] . ")";
            $rows[] = $row;
        }
        // Return JSON response
        echo json_encode($rows, JSON_UNESCAPED_SLASHES);
    } else {
        echo "0 results";
    }
    $conn->close();
} else {
    echo "No email provided!";
}
?>
