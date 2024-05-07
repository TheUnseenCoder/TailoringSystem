<?php
// Include your database connection code here
session_start();
include 'conn.php';

    $email = $_GET['email'];
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    
    // Fetch the matrix name associated with the product ID
    $select = "SELECT * FROM ts_users WHERE email = '$email'";
    $result = $conn->query($select);
    
    if($result->num_rows > 0){
        $product = "SELECT * FROM ts_products WHERE product_id = '$product_id'";
        $product_res = $conn->query($product);
        if($product_res->num_rows > 0){
            $prod_row = $product_res->fetch_assoc();
            if($quantity > $prod_row['quantity']){
                echo 'The product can not be reach the qty you need!';
            }else{
                echo 'success';
            }
        }else{
            echo 'The Product ID is invalid!';
        }
    } else {
        echo 'The Please Login First!';
    }

?>
