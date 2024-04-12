<?php

// Include database connection
include "../includes/conn.php";

// Query to select data from ts_products table
$sql = "SELECT images FROM ts_products WHERE product_id = '1'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Unserialize the data
        $unserializedData = unserialize($row['images']);

        // Iterate through the array and create HTML img elements
        foreach ($unserializedData as $imagePath) {
            // Check if the current element is an array (this handles the case when there's only one image path)
            if (is_array($imagePath)) {
                foreach ($imagePath as $path) {
                    echo '<img src="' . $path . '" alt="Image" width="250" height="250">';
                    echo '<br>';
                    echo $path;
                    echo '<br>';
                }
            } else {
                echo '<img src="' . $imagePath . '" alt="Image" width="250" height="250">';
                echo '<br>';
                echo $imagePath;
                echo '<br>';
            }
        }
    }
} else {
    echo "No products found.";
}

// Close database connection
mysqli_close($conn);

?>
