<?php
// Check if the item ID is provided in the request
if (isset($_GET['id'])) {
    // Get the item ID from the request
    $itemId = $_GET['id'];

    // Your database connection code
    include 'conn.php'; // Include your database connection script

    // SQL query to delete the item from the cart based on the provided item ID
    $sql = "DELETE FROM ts_addtocart WHERE id = $itemId";

    // Perform the deletion operation
    if ($conn->query($sql) === TRUE) {
        // Deletion successful
        echo "Item deleted successfully";
    } else {
        // Error in deletion
        echo "Error deleting item: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Item ID not provided in the request
    echo "Item ID not provided";
}
?>
