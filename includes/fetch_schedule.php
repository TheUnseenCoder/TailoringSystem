<?php
include 'conn.php';

if(isset($_GET['email'])){
    $email = $_GET['email']; // Retrieve the email parameter

    // SQL query to fetch data
    $sql = "SELECT customize_id, description, date, time, status FROM ts_customization WHERE email = '$email' ORDER BY date DESC";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Output data of each row
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        // Return JSON response
        echo json_encode($rows);
    } else {
        echo "0 results";
    }
    $conn->close();
} else {
    echo "There is no stored email!";
}
?>
