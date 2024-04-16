<?php
include '../../includes/conn.php';

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if(isset($_POST['productName']) && isset($_POST['matrix_name'])) {
        // Get form data
        $productName = $_POST['productName'];
        $matrixName = $_POST['matrix_name'];

        // Check if the product exists
        $productQuery = "SELECT * FROM ts_products WHERE name = ?";
        $stmt = $conn->prepare($productQuery);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $product_id = $row['product_id'];

            // Check if the product is already associated with another matrix
            $matrixCheckQuery = "SELECT * FROM ts_matrices_associate WHERE product_id = ?";
            $stmt = $conn->prepare($matrixCheckQuery);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                // Product is already registered in other matrices
                echo "Error: This product is already registered in other matrices";
            } else {
                // Insert the product into the specified matrix
                $insertProductQuery = "INSERT INTO ts_matrices_associate (product_id, matrix_name) VALUES (?, ?)";
                $stmt = $conn->prepare($insertProductQuery);
                $stmt->bind_param("is", $product_id, $matrixName);
        
                // Execute the statement
                if ($stmt->execute()) {
                    // Product added successfully
                    echo "Success: Product added successfully!";
                } else {
                    // Error occurred while adding product
                    echo "Error: Error occurred while adding product";
                }
        
                // Close the statement
                $stmt->close();
            }
        } else {
            // Product is not available
            echo "Error: The product is not available";
        }
       
    } else {
        // Required fields are not filled
        echo "Error: Please fill all the required fields!";
    }
}
?>
