<?php
session_start();
include '../includes/conn.php';
if(isset($_SESSION["loggedinasadmin"])){

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Ratings</title>
    <link rel="icon" href="../images/icon.png"> 
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .main1 {
            margin-top: 2%;
            margin-left: 2%;
            margin-right: 2%;
            width: 100%;
            background: rgba(128, 128, 128, 0.2);
        }
        .text-center {
            justify-content: center;
            align-items: flex-end; /* Align items to the bottom */
        }
    </style>
</head>
<body>

<div class="wrapper">
    <aside id="sidebar1">
        <?php include 'components/sidebar.php'; ?>
    </aside>
    <div class="main1">
        <br>
        <center><h1>Customer Ratings</h1></center> 
    
    </div>   
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

<script src="../assets/script.js"></script>

</body>
</html>
<?php 
}else{
  header("location: ../index.php");
  exit;
}
?>