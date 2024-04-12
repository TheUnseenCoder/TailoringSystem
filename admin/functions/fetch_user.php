<?php
include '../../includes/conn.php';

// Pagination parameters
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10; // Adjust as needed

// Calculate the offset
$offset = ($current_page - 1) * $records_per_page;

// Query to fetch products with pagination
$sql = "SELECT * FROM ts_users WHERE usertype='1' ORDER BY account_status DESC LIMIT $offset, $records_per_page";
$rs = $conn->query($sql);

// Start building the HTML for the table rows
$tableRows = '';

// Check if there are rows returned from the query
if ($rs->num_rows > 0) {
    $i = ($current_page - 1) * $records_per_page + 1;
    while ($row = $rs->fetch_assoc()) {
        $profileImage = $row['profile'] ? 'data:image/jpeg;base64,' . base64_encode($row['profile']) : '../images/default_profile.png';

        if($row['account_status'] == 0){
            $account_status = "Inactive";
        }else{
            $account_status = "Active";
        }
        // Build each table row
        $tableRows .= "<tr>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>$i</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><img src='". $profileImage . "' alt='Profile Image' class='rounded-circle mx-auto d-block' style='width: 50px; height: 50px;'></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['fullname'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['email'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'>";
        // Dropdown menu for account status
        $tableRows .= "<form action='functions/fetch_user_update_status.php' method='post'>";
        $tableRows .= "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
        $tableRows .= "<select name='account_status' class='form-select' onchange='this.form.submit()'  style='color: " . ($row['account_status'] == '1' ? 'green' : 'red') . ";'>";
        $tableRows .= "<option value='1'" . ($row['account_status'] == '1' ? ' selected' : '') . ">Active</option>";
        $tableRows .= "<option value='0'" . ($row['account_status'] == '0' ? ' selected' : '') . ">Inactive</option>";
        $tableRows .= "</select>";
        $tableRows .= "</form>";
        $tableRows .= "</td>";
        $tableRows .= "<td class='border-bottom-0 text-center'>";
        $tableRows .= "<a class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#view-modal" . $row['id'] . "'>View</a>";
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
