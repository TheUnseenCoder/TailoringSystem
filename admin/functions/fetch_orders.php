<?php
include '../../includes/conn.php';

function getStatusColorClass($status) {
    switch($status) {
        case 'packing order':
            return 'text-warning'; // Blue color
            break;
        case 'ready for pick up':
            return 'text-primary'; // Green color
            break;
        default:
            return '';
    }    
}
// Pagination parameters
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10; // Adjust as needed

// Calculate the offset
$offset = ($current_page - 1) * $records_per_page;

// Query to fetch products with pagination
// Query to fetch products with pagination
$sql = "SELECT * FROM ts_orders ORDER BY 
    CASE 
        WHEN order_status IN ('packing order', 'ready for pick up', 'order received') THEN 0 
        ELSE 1 
    END, order_id DESC LIMIT $offset, $records_per_page";

$rs = $conn->query($sql);

// Start building the HTML for the table rows
$tableRows = '';

// Check if there are rows returned from the query
if ($rs->num_rows > 0) {
    $i = ($current_page - 1) * $records_per_page + 1;
    while ($row = $rs->fetch_assoc()) {
        $product_id = $row['product_id'];
        $selector = "SELECT * FROM ts_products WHERE product_id = '$product_id'";
        $selres = $conn->query($selector);
        $row2 = $selres->fetch_assoc();
        $product_name = $row2['name'];
        $date = date("F j, Y - H:i A", strtotime($row['timestamp']));
        // Build each table row
        $tableRows .= "<tr>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>$i</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['email'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" .  $product_name . "</h6></td>";
        if (strcasecmp($row['order_status'], 'Order Received') === 0) {
            // If the order status is 'Order Received', display it in green without the select dropdown
            $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0' style='color: green;'>Order Received</h6></td>";
        } else {
            // If the order status is not 'Order Received', display the select dropdown
            $tableRows .= "<td class='border-bottom-0 text-center'><select class='form-select " . getStatusColorClass($row['order_status']) . "' onchange='updateStatus(this, \"". $row['order_id'] . "\", \"" . $row['email'] . "\")'>
                <option value='packing order' ". ($row['order_status'] == 'packing order' ? 'selected' : '') .">Packing Order</option>
                <option value='ready for pick up' ". ($row['order_status'] == 'ready for pick up' ? 'selected' : '') .">Ready for Pick Up</option> 
                </select></td>";
        }
        
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $date . "</h6></td>";


        $tableRows .= "<td class='border-bottom-0 text-center'>";
        $tableRows .= "<a class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#view-modal" . $row['order_id'] . "'>View</a>";
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
