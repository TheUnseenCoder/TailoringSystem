<?php
// Include your database connection code here
session_start();
include '../../includes/conn.php';

// Check if the matrix name is provided in the query string
if (isset($_GET['matrix_name'])) {
    // Get the matrix name from the query string
    $matrix_name = $_GET['matrix_name'];

    // Start building the measurements table
    $measurements_table = "<center><div class='measurements-container'><br>";
    $measurements_table .= "<h1>PRODUCTS THAT USE THIS MATRIX</h1></center><br>";
    $measurements_table .=
        "<div class='text-end mx-5'>
            <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#addProductModal-". base64_encode($matrix_name) ."'>Add Product</button>
        </div>";

    // Prepare the SQL statement with a placeholder for the matrix name
    $associate_query = "SELECT DISTINCT matrix_name, product_id, ass_id FROM ts_matrices_associate WHERE matrix_name = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($associate_query);

    // Bind the parameter
    $stmt->bind_param("s", $matrix_name);

    // Execute the query
    $stmt->execute();

    // Get the result
    $associate_result = $stmt->get_result();

    // Check if there are measurements available
    if ($associate_result->num_rows > 0) {
        // Initialize an array to store measurements for each size
        $associate = array();

        $measurements_table .= "<center><table id='myTable' class='table text-nowrap mb-0 align-middle' style='justify-content: center;'>";

        $measurements_table .=
            "<thead class='text-dark fs-4'>
                <tr>
                <th class='border-bottom-0'>
                    <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Product Name</h6>
                </th>
                <th class='border-bottom-0'>
                    <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Action</h6>
                </th>
                </tr>
            </thead>";
        $measurements_table .= "<tbody>";
        
        while ($row = $associate_result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $product_select = "SELECT * FROM ts_products WHERE product_id = '$product_id'";
            $product_result = $conn->query($product_select);
            $row1 = $product_result->fetch_assoc();
            $product_name = $row1['name'];

            $measurements_table .=      
                "<tr>
                    <td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $product_name . "</h6></td>
                    <td class='border-bottom-0 text-center'>
                        <a class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#view-product". $row['product_id'] ."'>View</a>
                        <button class='btn btn-sm btn-danger me-2' onclick='confirmDelete2(\"" . $row['ass_id'] . "\")'>Remove</button>
                    </td>
                </tr>";

        }
        // Close the table and container
        $measurements_table .= "</tbody></table></div></center>";

    } else {
        // If no measurements found, return empty content
        $measurements_table .= "";
    }
    // Return the measurements table
    echo $measurements_table;
    // Close the statement
    $stmt->close();
} else {
    // If matrix name is not provided in the query string, return empty content
    echo "";
}
?>