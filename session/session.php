<?php 
session_start();

if(isset($_SESSION['email']) !== ""){
    echo '<script>window.location.href = "../index.php";</script>';
    exit;
}else{
    echo '<script>window.location.href = "../index.php";</script>';
    exit;
}
?>