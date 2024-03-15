<?php
include '../includes/conn.php';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = $_POST["fullname"];
    $mobileNum = $_POST["mobileNum"];
    $email = $_POST["signupEmail"];
    $password = md5($_POST["signupPassword"]); // Encrypt password using md5
    $confirmPassword = md5($_POST["confirmPassword"]); // Encrypt confirmPassword using md5

    // Perform validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
        // Return error response if any field is empty
        echo json_encode(["success" => false, "message" => "All fields are required."]);
    } elseif ($password != $confirmPassword) {
        // Return error response if passwords do not match
        echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    } else {
        // Check if the email already exists
        $sql = "SELECT * FROM ts_users WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Return error response if email already exists
            echo json_encode(["success" => false, "message" => "Email already exists."]);
        } else {
            // Insert user into the database
            $sql = "INSERT INTO ts_users (fullname, email, password, usertype, mobile_number) VALUES ('$fullname', '$email', '$password', '0', '$mobileNum')";
            if ($conn->query($sql) === TRUE) {
                // Return success response
                echo json_encode(["success" => true, "message" => "Signup successful!"]);
            } else {
                // Return error response if insertion fails
                echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
            }
        }
    }
} else {
    // Return error response for invalid request method
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>