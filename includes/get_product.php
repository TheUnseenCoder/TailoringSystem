<?php
include("conn.php");

// Fetch product details
$product_id = $_GET['product_id'];
$product_query = "SELECT * FROM ts_products WHERE product_id = '$product_id'";
$product_result = $conn->query($product_query);

// Fetch matrices associated with the product
$matrix_query = "SELECT m.* FROM ts_matrices m INNER JOIN ts_matrices_associate ma ON m.matrix_name = ma.matrix_name WHERE ma.product_id = '$product_id'";
$matrix_result = $conn->query($matrix_query);

// Combine product and matrices data into an array
$response = array();

if ($product_result->num_rows > 0) {
    while ($row = $product_result->fetch_assoc()) {
        $product_data = array(
            "name" => $row["name"],
            "description" => $row["description"],
            "base_price" => $row["base_price"],
            "images" => $row["images"] // Add images field if needed
        );
    }

    $response["product"] = $product_data;
}

if ($matrix_result->num_rows > 0) {
    $matrices_data = array();
    while ($row = $matrix_result->fetch_assoc()) {
        $matrix_data = array(
            "matrix_name" => $row["matrix_name"],
            "measurement_name" => $row["measurement_name"],
            "measurement_size" => $row["measurement_size"],
            "size_name" => $row["size_name"],
            "additional" => $row["additional"]
        );
        array_push($matrices_data, $matrix_data);
    }

    $response["matrices"] = $matrices_data;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
