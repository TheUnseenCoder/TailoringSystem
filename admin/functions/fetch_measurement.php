<?php
// Include your database connection code here
session_start();
include '../../includes/conn.php';

// Check if the matrix name is provided in the query string
if (isset($_GET['matrix_name'])) {
    // Get the matrix name from the query string
    $matrix_name = $_GET['matrix_name'];
    
    // Prepare the SQL statement with a placeholder for the matrix name
    $measurement_query = "SELECT DISTINCT size_name, measurement_name, measurement_size, additional FROM ts_matrices WHERE matrix_name = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($measurement_query);

    // Bind the parameter
    $stmt->bind_param("s", $matrix_name);

    // Execute the query
    $stmt->execute();

    // Get the result
    $measurement_result = $stmt->get_result();

    // Check if there are measurements available
    if ($measurement_result->num_rows > 0) {
        // Initialize an array to store measurements for each size
        $measurements_by_size = array();

        // Fetch and organize measurements by size
        while ($measurement_row = $measurement_result->fetch_assoc()) {
            $size_name = $measurement_row['size_name'];
            $measurement_name = $measurement_row['measurement_name'];
            $measurement_size = $measurement_row['measurement_size'];
            $additional = $measurement_row['additional'];
            $measurements_by_size[$size_name][$measurement_name] = array('measurement_size' => $measurement_size, 'additional' => $additional);
        }

        // Start building the measurements table
        $measurements_table = "<center><div class='measurements-container'><br>";
        $measurements_table .= "<h1>MEASUREMENTS</h1>";
        $measurements_table .=
        "<div class='text-end mx-5'>
                    <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#addMeasurement-". base64_encode($matrix_name) ."'>Add Measurement</button>
                    <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#addSize-". base64_encode($matrix_name) ."'>Add Size</button>
        </div>";
        $measurements_table .= "<table id='myTable' class='table text-nowrap mb-0 align-middle' style='justify-content: center;'>";

        // Add measurement headers
        $measurement_names = array();
        foreach ($measurements_by_size as $size_measurements) {
            foreach ($size_measurements as $measurement_name => $measurement_data) {
                if (!in_array($measurement_name, $measurement_names)) {
                    $measurement_names[] = $measurement_name;
                }
            }
        }
        $measurements_table .= "<tr><td class='border-bottom-0 text-center'></td>";
        foreach ($measurement_names as $measurement_name) {
            $measurements_table .= "<th class='border-bottom-0'><h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>$measurement_name</h6></th>";
        }
        $measurements_table .= "<th class='border-bottom-0'><h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>Additional Amount</h6></th>";
        $measurements_table .= "</tr>";

        // Add measurement values and calculate total additional
        foreach ($measurements_by_size as $size_name => $size_measurements) {
            $total_additional = 0;
            $measurements_table .= "<tr><td class='border-bottom-0 text-center'><h6 class='fw-semibold mb-0 text-center' style='background-color: black; color: white;'>$size_name</h6></td>";
            foreach ($measurement_names as $measurement_name) {
                if (isset($size_measurements[$measurement_name])) {
                    $measurement_size = $size_measurements[$measurement_name]['measurement_size'];
                    $additional = $size_measurements[$measurement_name]['additional'];
                    $measurements_table .= "<td class='border-bottom-0 text-center'>$measurement_size</td>";
                    $total_additional += $additional;
                } else {
                    $measurements_table .= "<td class='border-bottom-0 text-center'></td>";
                }
            }
            $measurements_table .= "<td class='border-bottom-0 text-center'>$total_additional</td>";
            $measurements_table .= "</tr>";
        }

        // Close the table and container
        $measurements_table .= "</tbody></table></div></center>";

        // Return the measurements table
        echo $measurements_table;
    } else {
        // If no measurements found, return empty content
        echo "";
    }

    // Close the statement
    $stmt->close();
} else {
    // If matrix name is not provided in the query string, return empty content
    echo "";
}
?>
