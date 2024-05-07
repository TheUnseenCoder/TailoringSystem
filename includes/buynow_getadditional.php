<?php 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
session_start();
include 'conn.php';

$product_id = $_GET['product_id'];
$quantity = $_GET['quantity'];
$size_name = $_GET['size'];

$sql = "SELECT SUM(ts_matrices.additional) AS total_additional
        FROM ts_matrices_associate 
        LEFT JOIN ts_matrices ON ts_matrices_associate.matrix_name = ts_matrices.matrix_name 
        WHERE ts_matrices_associate.product_id = '$product_id' 
        AND ts_matrices.size_name = '$size_name'
        GROUP BY ts_matrices.size_name";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rows = array();
    while($row = $result->fetch_assoc()) {
        $additional = $row['total_additional'];
        $total_additional = $row['total_additional'] * $quantity;
        $row['total_additional'] = $total_additional;
        $row['additional'] = $additional;
        $rows[] = $row;
    }
    // Return JSON response with data
    echo json_encode($rows);
} else {
    // Return JSON response with empty array if no results
    echo json_encode(array());
}

$conn->close();
?>
