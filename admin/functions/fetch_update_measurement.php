<?php
session_start();
include '../../includes/conn.php';

// Check if the matrix name is provided in the query string
if (isset($_GET['matrix_name'])) {
    // Get the matrix name from the query string
    $matrix_name = $_GET['matrix_name'];

    // Prepare the SQL statement with a parameter placeholder
    $sql = "SELECT * FROM ts_matrices WHERE matrix_name = ?";
    $stmt = $conn->prepare($sql);

    // Bind the matrix_name parameter to the placeholder
    $stmt->bind_param("s", $matrix_name);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Start building the HTML for the table rows
    $tableRows = '';
    $tableRows .= 
    "<table id='myTable' class='table text-nowrap mb-0 align-middle' style='justify-content: center;'>
        <thead class='text-dark fs-4'>
        <tr>
            <th class='border-bottom-0'>
                <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>ID</h6>
            </th>
            <th class='border-bottom-0'>
                <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Measurement Name</h6>
            </th>
            <th class='border-bottom-0'>
                <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Measurement Size</h6>
            </th>
            <th class='border-bottom-0'>
                <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Size Name</h6>
            </th>
            <th class='border-bottom-0'>
                <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Additional</h6>
            </th>
            <th class='border-bottom-0'>
                <h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Action</h6>
            </th>
        </tr>
        </thead>
        <tbody>";
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $matrix_name_base64 = base64_encode($row['matrix_name']);
        $matrix_number = $row['matrix_id'];
        $tableRows .= "<tr>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>$i</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['measurement_name'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['measurement_size'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['size_name'] . "</h6></td>";
        $tableRows .= "<td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0'>" . $row['additional'] . "</h6></td>";

        $tableRows .= "<td class='border-bottom-0 text-center'>";
        $tableRows .= "<a class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#updating-modal" . $matrix_number. "'>Update</a>";
        $tableRows .= "<button class='btn btn-sm btn-danger me-2' onclick='confirmDelete(\"" . $matrix_number . "\")'>Delete</button>";
        $tableRows .= "</td>";
        $tableRows .= "</tr>";
        $i++;
    }
    $tableRows .=
    "</tbody>
    </table>";

    // Output the table rows
    echo $tableRows;

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
