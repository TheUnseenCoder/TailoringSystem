<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../includes/conn.php';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["loginEmail"];
    $password = md5($_POST["loginPassword"]); // Encrypt password using md5

    // Perform validation
    if (empty($email) || empty($password)) {
        // Return error response if any field is empty
        echo json_encode(["success" => false, "message" => "All fields are required."]);
    } else {
        // Check if the email and password match
        $sql = "SELECT * FROM ts_users WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['user_type'] = $row['usertype']; // Store user type in session
            echo json_encode(["success" => true, "message" => "Login successful!", "user_type" => $row['usertype']]);
        } else {
            // Login failed
            echo json_encode(["success" => false, "message" => "Invalid email or password."]);
        }
    }
} else {
    // Return error response for invalid request method
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
