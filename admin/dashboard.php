<?php

session_start();

include '../includes/conn.php';if(isset($_SESSION["loggedinasadmin"])){
  
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>TRBS | Dashboard</title>
  <link rel="icon" href="../images/icon.png"> 
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            flex: 1;
            display: flex;
            margin: 2%;
            width: 50%;
            justify-content: center;
            align-items: top;
            background:rgba(128,128,128, 0.2);
        }
        .content {
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <aside id="sidebar1">
        <?php include 'components/sidebar.php'; ?>
        </aside>
        <!-- Page Content -->       
    <div id="content">
        <div class="navbar navbar-expand-lg navbar-light bg-light">
            <button id="toggleBtn" class="navbar-toggler d-lg-none" type="button" onclick="toggleSidebar()" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        
        <div class="container-fluid">
            <h1 class="fw-bold mt-5">
                Dashboard
            </h1>
            <div class="row mt-3 justify-content-center">
                <div class="col col-lg-4 col-md-4 col-sm-12" >
                    <div class="card text-bg-light mb-3 shadow" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Users</h5>
                            <div class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="50"  height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                            <h1 class="ms-3">
                                <?php 
                                    $sql = "SELECT COUNT(id) AS total_user FROM ts_users WHERE usertype = 1 AND account_status = 1";
                                    $userresult = $conn->query($sql);
                                    if ($userresult) {
                                        $userrow = $userresult->fetch_assoc();
                                        echo $userrow['total_user'] . " Current Users";
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }                                
                                ?>
                            </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-4 col-md-4 col-sm-12">
                    <div class="card text-bg-light mb-3 shadow" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Products</h5>
                            <div class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="50"  height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cake"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 20h18v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8z" /><path d="M3 14.803c.312 .135 .654 .204 1 .197a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1c.35 .007 .692 -.062 1 -.197" /><path d="M12 4l1.465 1.638a2 2 0 1 1 -3.015 .099l1.55 -1.737z" /></svg>
                            <h1 class="ms-3">
                            <?php 
                                    $sql = "SELECT COUNT(product_id) AS total_products FROM ts_products";
                                    $userresult = $conn->query($sql);
                                    if ($userresult) {
                                        $userrow = $userresult->fetch_assoc();
                                        echo $userrow['total_products'] . " Registered Product";
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }                                
                                ?>
                            </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-4 col-md-4 col-sm-12">
                    <div class="card text-bg-light mb-3 shadow" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Matrices</h5>
                            <div class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-ruler-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 8c.621 0 1.125 .512 1.125 1.143v5.714c0 .631 -.504 1.143 -1.125 1.143h-15.875a1 1 0 0 1 -1 -1v-5.857c0 -.631 .504 -1.143 1.125 -1.143h15.75z" /><path d="M9 8v2" /><path d="M6 8v3" /><path d="M12 8v3" /><path d="M18 8v3" /><path d="M15 8v2" /></svg>                            <h1 class="ms-3">
                            <?php 
                                    $sql = "SELECT COUNT(DISTINCT matrix_name) AS total_products FROM ts_matrices";
                                    $userresult = $conn->query($sql);
                                    if ($userresult) {
                                        $userrow = $userresult->fetch_assoc();
                                        echo $userrow['total_products'] . " Registered Matrices";
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }                                
                                ?>
                            </h1>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
            <div class="row mt-3">
                <div class="col col-lg-4 col-md-4 col-sm-12">
                    <div class="card text-bg-light mb-3 shadow" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: green;">Customization Schedules Today</h5>
                            <div class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="50"  height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-due"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            <h1 class="ms-3">
                            <?php 
                                    date_default_timezone_set('Asia/Manila');

                                    // Get the current date and time
                                    $current_date = date('Y-m-d');
                                    $sql = "SELECT COUNT(customize_id) AS total_customization FROM ts_customization WHERE date = '$current_date' AND status = 'approved'";
                                    $userresult = $conn->query($sql);
                                    if ($userresult) {
                                        $userrow = $userresult->fetch_assoc();
                                        echo $userrow['total_customization'] . " Approved Schedule";
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }                                
                                ?>
                            </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-4 col-md-4 col-sm-12">
                    <div class="card text-bg-light mb-3 shadow" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: orange;">Customization Schedules Today</h5>
                            <div class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="50"  height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-due"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            <h1 class="ms-3">
                            <?php 
                                    date_default_timezone_set('Asia/Manila');

                                    // Get the current date and time
                                    $current_date = date('Y-m-d');
                                    $sql = "SELECT COUNT(customize_id) AS total_customization FROM ts_customization WHERE date = '$current_date' AND status = 'pending'";
                                    $userresult = $conn->query($sql);
                                    if ($userresult) {
                                        $userrow = $userresult->fetch_assoc();
                                        echo $userrow['total_customization'] . " Pending Schedule";
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }                                
                                ?>
                            </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-4 col-md-4 col-sm-12">
                    <div class="card text-bg-light mb-3 shadow" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: red;">Customization Schedules Today</h5>
                            <div class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="50"  height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-due"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            <h1 class="ms-3">
                            <?php 
                                    date_default_timezone_set('Asia/Manila');

                                    // Get the current date and time
                                    $current_date = date('Y-m-d');
                                    $sql = "SELECT COUNT(customize_id) AS total_customization FROM ts_customization WHERE date = '$current_date' AND status = 'cancelled'";
                                    $userresult = $conn->query($sql);
                                    if ($userresult) {
                                        $userrow = $userresult->fetch_assoc();
                                        echo $userrow['total_customization'] . " Cancelled Schedule";
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }                                
                                ?>
                            </h1>
                            </div>
                        </div>
                    </div>
                </div>
                   
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