<?php
include '../../includes/conn.php';

// Pagination parameters
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10; // Adjust as needed

// Calculate the offset
$offset = ($current_page - 1) * $records_per_page;

// Query to fetch products with pagination
$sql = "SELECT * FROM ts_products LIMIT $offset, $records_per_page";
$rs = $conn->query($sql);

// Start building the HTML for the table rows
$tableRows = '';

// Check if there are rows returned from the query
if ($rs->num_rows > 0) {
    $i = ($current_page - 1) * $records_per_page + 1;
    while ($row = $rs->fetch_assoc()) {
        // Build each table row
        $tableRows .= "<tr>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>$i</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['name'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['base_price'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'>";
        $tableRows .= "<a class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#view-modal" . $row['product_id'] . "'>View</a>";
        $tableRows .= "<a class='btn btn-sm btn-success me-2' data-bs-toggle='modal' data-bs-target='#update-modal" . $row['product_id'] . "'>Update</a>";
        $tableRows .= "</td>";
        $tableRows .= "</tr>";
        $i++;
    }
} else {
    // If no records found, display a message in the table
    $tableRows = "<tr><td colspan='4' class='text-center'>No records found.</td></tr>";
}

// Output the table rows
echo $tableRows;

// Close the database connection
$conn->close();
?>
