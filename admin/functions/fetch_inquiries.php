<?php
include '../../includes/conn.php';

// Pagination parameters
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10; // Adjust as needed

// Calculate the offset
$offset = ($current_page - 1) * $records_per_page;

// Query to fetch products with pagination
$sql = "SELECT * FROM ts_inquiry ORDER BY timestamp DESC LIMIT $offset, $records_per_page";
$rs = $conn->query($sql);

// Start building the HTML for the table rows
$tableRows = '';

// Check if there are rows returned from the query
if ($rs->num_rows > 0) {
    $i = ($current_page - 1) * $records_per_page + 1;
    while ($row = $rs->fetch_assoc()) {

        if($row['gender'] == 1){
            $gender = "Male";
        }elseif($row['gender'] == 2){
            $gender = "Female";
        }elseif($row['gender'] == 3){
            $gender = "LGBTQIA+";
        }else{
            $gender = "Prefer not to Say";
        }
       
        // Build each table row
        $tableRows .= "<tr>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>$i</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['full_name'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['email'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['phone'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $gender . "</h6></td>";
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
