<?php
session_start();
include '../includes/conn.php';
if(isset($_SESSION["loggedinasadmin"])){

// Query to fetch the admin's profile information
$sql = "SELECT * FROM ts_users WHERE usertype = 0"; // Assuming usertype 0 represents the admin
$result = $conn->query($sql);

// Check if the query was successful and if there is exactly one admin record
if ($result && $result->num_rows == 1) {
    $admin = $result->fetch_assoc();

    // Extract admin's profile information
    $adminFullname = $admin['fullname'];
    $adminEmail = $admin['email'];
    $adminProfileImage = $admin['profile'] ? 'data:image/jpeg;base64,' . base64_encode($admin['profile']) : '../images/default_profile.png';
} else {
    echo "Error: Unable to fetch admin's profile information.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="icon" href="../images/icon.png"> 
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="functions/otpsending.js"></script>
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
        .profile-picture {
            width: 250px;
            height: 250px;
            border-radius: 50%;
        }
        .profile-form {
            display: none; /* Hidden by default */
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
        <center><h1>Admin Profile</h1></center> 
        <!-- Profile display section -->
        <div id="viewProfile">
            <center><img src="<?php echo $adminProfileImage; ?>" alt="Admin Profile" class="profile-picture"></center>
            <div class="text-center">
                <h2><?php echo $adminFullname; ?></h2>
                <p>Email: <?php echo $adminEmail; ?></p>
                <button type="button" class="btn btn-success" onclick="toggleEditMode()">Edit Profile</button>
            </div>
        </div>

        <!-- Editable profile form (hidden by default) -->
        <div id="editProfile" class="profile-form">
            <form id="editProfileForm" method="post" enctype="multipart/form-data">
                <center><img src="<?php echo $adminProfileImage; ?>" alt="Admin Profile" class="profile-picture"></center>
                <div class="text-center">
                    <input type="file" name="profile" accept="image/*">
                </div>
                <br>
                    <div class="m-4">
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control" id="id" name="id" value="<?php echo $admin['id']; ?>" hidden>

                                <label for="fullname" class="form-label">Full Name:</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $adminFullname; ?>" require>
                            </div>
                            <div class="col-6">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $adminEmail; ?>" require>
                            </div>
                        </div>
                    </div>
                    <div class="m-4">
                        <div class="row">
                            <div class="col-6">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="col-6">
                                <label for="confirmPassword" class="form-label">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                            </div>
                        </div>
                        
                    </div>
                    <div class="m-4">
                        <label for="otp" class="form-label">OTP:</label>
                        <div class="row">
                            
                            <div class="col-6">   
                                <input type="number" class="form-control" id="otp" name="otp" placeholder="000000" pattern="[0-9]*" maxlength="6" required>
                            </div>
                            <div class="col-6">
                                <button type="button" id="submitOTP" class="btn btn-success">Send OTP</button>
                            </div>
                        </div>
                        <br>
                </div>
                    <div class="text-center">
                    <button type="button" class="btn btn-primary" id="updateProfile">Update Profile</button>
                    <button type="button" class="btn btn-danger" onclick="toggleEditMode()">Cancel</button>
                </div>
            </form>
        </div>

    </div>   
</div>

<script>
    function toggleEditMode() {
        var viewProfile = document.getElementById('viewProfile');
        var editProfile = document.getElementById('editProfile');

        if (viewProfile.style.display === 'block') {
            viewProfile.style.display = 'none';
            editProfile.style.display = 'block';
        } else {
            viewProfile.style.display = 'block';
            editProfile.style.display = 'none';
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="../assets/script.js"></script>

</body>
</html>
<?php 
}else{
  header("location: ../index.php");
  exit;
}
?>