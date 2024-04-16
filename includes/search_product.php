<?php
// Include database connection
include("conn.php");

// Check if the search query parameter is set
if(isset($_GET["query"])) {
    // Get the search query
    $query = $_GET["query"];

    // Prepare SQL statement to search for products
    $sql = "SELECT * FROM ts_products WHERE name LIKE '%$query%'";

    // Execute SQL query
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if(mysqli_num_rows($result) > 0) {
        // Array to store search results
        $response["products"] = array();

        // Fetch and store each product in the response array
        while($row = mysqli_fetch_assoc($result)) {
            $product = array();
            $product["product_id"] = $row["product_id"];
            $product["name"] = $row["name"];
            $product["base_price"] = $row["base_price"];
            
            // Decode the serialized image data
            $images = unserialize($row["images"]);

            // Extract the first image URL
            $imageUrl = !empty($images) ? "http://192.168.1.7/TailoringSystem/admin/" . $images[0] : "http://192.168.1.7/TailoringSystem/images/default-image-product.png";
            $product["image"] = $imageUrl;

            array_push($response["products"], $product);
        }

        // Send JSON response with unescaped slashes
        echo json_encode($response, JSON_UNESCAPED_SLASHES);
    } else {
        // No products found
        $response["message"] = "No products found matching the search query.";
        echo json_encode($response);
    }
} else {
    // Search query parameter not set
    $response["error"] = true;
    $response["message"] = "Search query parameter not set.";
    echo json_encode($response);
}
?>
