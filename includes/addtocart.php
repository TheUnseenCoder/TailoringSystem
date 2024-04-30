<?php
// Include your database connection code here
session_start();
include 'conn.php';

    $email = $_GET['email'];
    $product_id = $_GET['product_id'];
    $size = $_GET['size'];
    $variant = $_GET['variant'];
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
                echo json_encode(array('error' => 'The product can not be reach the qty you need!'));
            }else{
                $sizes = "SELECT SUM(m.additional) AS total_additional 
                    FROM ts_matrices AS m 
                    JOIN ts_matrices_associate AS ma
                    ON m.matrix_name = ma.matrix_name AND ma.product_id = '$product_id'
                    WHERE m.size_name = '$size'";
                $size_result = $conn->query($sizes);
                if($size_result){
                    $size_row = $size_result->fetch_assoc();
                    $total_additional = $size_row['total_additional'];
                    // Output the result
                    $inserting = "INSERT ts_addtocart SET email='$email', product_id='$product_id', size='$size', variant='$variant', quantity='$quantity'";
                    $insert_result = $conn->query($inserting);
                    if($insert_result){
                        echo json_encode('success');
                    }else{
                        echo json_encode(array('error' => 'Something went wrong in inserting in add to cart'));
                    }   
                }else{
                    echo json_encode(array('error' => 'Something went wrong in computing the additional for sizes!'));
                }  
            }
        }else{
            echo json_encode(array('error' => 'The Product ID is invalid!'));
        }
    } else {
        echo json_encode(array('error' => 'Please Login First'));
    }

?>
