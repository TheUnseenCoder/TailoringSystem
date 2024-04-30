<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    include "../../includes/conn.php";

    // Process form data
    $productName = isset($_POST['productName']) ? $_POST['productName'] : '';
    $productDescription = isset($_POST['productDescription']) ? $_POST['productDescription'] : '';
    $productBasePrice = isset($_POST['productBasePrice']) ? $_POST['productBasePrice'] : '';
    $variants = isset($_POST['variants']) ? $_POST['variants'] : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    // Check if the product name already exists
    $checkQuery = "SELECT * FROM ts_products WHERE name = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $productName);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // If product name already exists, return an error response
        $response = [
            'success' => false,
            'message' => 'Error: Product name already exists'
        ];
    } else {
        // Handle file uploads
        $uploadedImages = [];

        // Check if files are uploaded
        if (!empty($_FILES['productImages']['name']) && is_array($_FILES['productImages']['error'])) {
            // Iterate over each uploaded file
            foreach ($_FILES['productImages']['error'] as $key => $error) {
                // Check if the file has been uploaded successfully
                if ($error === UPLOAD_ERR_OK) {
                    $file_tmp = $_FILES['productImages']['tmp_name'][$key];
                    $uploadDir = '../uploads/';
                    $file_name = basename($_FILES['productImages']['name'][$key]);
                    $destination = $uploadDir . $file_name;

                    // Move the uploaded file to the destination directory
                    if (move_uploaded_file($file_tmp, $destination)) {
                        // Store the path relative to the "uploads" directory for database insertion
                        $uploadedImages[] = 'uploads/' . $file_name;
                    }
                }
            }
        }

        // Serialize the uploaded images array
        $serializedImages = serialize($uploadedImages);

        // Insert data into the database
        $insertQuery = "INSERT INTO ts_products (name, description, base_price, variants, quantity, images) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sssssis", $productName, $productDescription, $productBasePrice, $variants, $quantity, $serializedImages);
        $insertResult = $insertStmt->execute();

        if ($insertResult) {
            $response = [
                'success' => true,
                'message' => 'Product added successfully'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error: Failed to add product'
            ];
        }
    }

    // Close prepared statements
    $checkStmt->close();
    $insertStmt->close();

    // Close database connection
    $conn->close();

    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If script is accessed directly, return an error response
    $response = [
        'success' => false,
        'message' => 'Direct access not allowed'
    ];
    
    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
