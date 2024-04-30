<?php
include '../../includes/conn.php';

function getStatusColorClass($status) {
    switch($status) {
        case 'pending':
            return 'text-warning'; // Blue color
            break;
        case 'approved':
            return 'text-primary'; // Green color
            break;
        case 'rejected':
            return 'text-danger'; // Red color
            break;
        case 'done':
            return 'text-success'; // Purple color
            break;
        case 'cancelled':
            return 'text-danger'; // Yellow color
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
$sql = "SELECT * FROM ts_customization ORDER BY 
    CASE 
        WHEN status IN ('pending', 'approved') THEN 0 
        ELSE 1 
    END, customize_id DESC LIMIT $offset, $records_per_page";

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
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['email'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['date'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['time'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'>
        <select class='form-select " . getStatusColorClass($row['status']) . "' onchange='updateStatus(this, \"". $row['customize_id'] . "\", \"" . $row['email'] . "\")'>";
        if($row['status'] == 'cancelled'){
            $tableRows .= "<option value='cancelled' ". ($row['status'] == 'cancelled' ? 'selected' : '') .">Cancelled</option>";
        }elseif ($row['status'] == 'approved') {
            $tableRows .= "<option value='pending' ". ($row['status'] == 'pending' ? 'selected' : '') .">Pending</option>
                        <option value='approved' ". ($row['status'] == 'approved' ? 'selected' : '') .">Approved</option>
                        <option value='done' ". ($row['status'] == 'done' ? 'selected' : '') .">Done</option>";
        }elseif($row['status'] == 'pending'){
            $tableRows .= "<option value='pending' ". ($row['status'] == 'pending' ? 'selected' : '') .">Pending</option>
                            <option value='approved' ". ($row['status'] == 'approved' ? 'selected' : '') .">Approved</option>
                            <option value='rejected' ". ($row['status'] == 'rejected' ? 'selected' : '') .">Rejected</option>";
        }elseif($row['status'] == 'done'){
            $tableRows .= "<option value='pending' ". ($row['status'] == 'pending' ? 'selected' : '') .">Pending</option>
                            <option value='approved' ". ($row['status'] == 'approved' ? 'selected' : '') .">Approved</option>
                            <option value='done' ". ($row['status'] == 'done' ? 'selected' : '') .">Done</option>";
        }elseif($row['status'] == 'rejected'){
            $tableRows .= "<option value='pending' ". ($row['status'] == 'pending' ? 'selected' : '') .">Pending</option>
                            <option value='rejected' ". ($row['status'] == 'rejected' ? 'selected' : '') .">Rejected</option>";
        }

        $tableRows .= "</select>
            </td>";


        $tableRows .= "<td class='border-bottom-0 text-center'>";
        $tableRows .= "<a class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#view-modal" . $row['customize_id'] . "'>View</a>";
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
