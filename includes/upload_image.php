<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['image'])) {
    $email = $_POST['email'];
    $image = $_POST['image'];

    // Decode the base64 image string
    $decodedImage = base64_decode($image);

    // Save the image to the server
    $uploadPath = "uploads/";
    $filename = $email . "_" . time() . ".png"; // You can change the file format if needed
    $filePath = $uploadPath . $filename;
    file_put_contents($filePath, $decodedImage);

    // Update the user's profile image in the database using prepared statement
    $sql = "UPDATE ts_users SET profile = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $decodedImage, $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Image uploaded and database updated successfully
        echo "Image uploaded and database updated successfully";
            unlink($filePath);

    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
