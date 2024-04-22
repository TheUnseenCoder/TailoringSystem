<?php
session_start();
include 'includes/conn.php';
if(!isset($_SESSION['email'])){
  $_SESSION['email'] = "";
}
  // Query to retrieve products from the database
  $view = "SELECT * FROM ts_products";
  $view_rs = $conn->query($view);
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailoring System | Home</title>
    <link rel="icon" href="images/icon.png"> 
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
      .product-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
          gap: 20px;
      }

      .product-item {
          border: 1px solid #ddd;
          border-radius: 5px;
          padding: 10px;
          text-align: center;
      }

      .product-item a {
          text-decoration: none;
          color: inherit;
      }

      .product-item img {
          max-width: 100%;
          height: auto;
          border-radius: 5px;
      }

      .product-item h3 {
          margin-top: 10px;
          margin-bottom: 5px;
          font-size: 18px;
      }

      .product-item p {
          margin: 0;
          font-size: 16px;
          color: #888;
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-xl navbar-light" style="background-color: #410093;">
        <div class="container-fluid">
            <a href="index.php" class="logo" style="margin-left: 1%">
                <img src="images/logo.png" alt="logo">
                <h2>Tailoring System</h2>
            </a>    
            
            <div style="width: 50%; display: flex; align-items: center;">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" style="margin-right: 5px;">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </div>
                    

            <ul class="navbar-nav navbar-right">
                <li><a href="index.php">Home</a></li>
                <li>
                  <?php 
                    if (isset($_SESSION['email']) && $_SESSION['email'] !== "") {
                        $email = $_SESSION['email'];
                        $sql = "SELECT profile FROM ts_users WHERE email = '$email'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $profileBlob = $row['profile'];

                            if($profileBlob !== null || !empty($profileBlob)){
                              $profilePicture = 'data:image/png;base64,' . base64_encode($profileBlob);
                              echo "<img src='$profilePicture' alt='Profile Picture' id='profilePicture' style='width: 30px; height:30px; border-radius: 50%; margin-left:20px;'>";
                            }
                            else{
                              echo "<img src='images/default_profile.png' alt='Default Profile Picture' style='width: 30px; height:30px; margin-left:20px; border-radius: 50%;' id='profilePicture'>";
                            }
                        } 
                      ?>
                      <ul id="profileMenu" class="navbar-nav" style="display: none;">
                          <li><a href="pages/profile.php">Profile</a></li>
                          <li><a href="pages/logout.php">Logout</a></li>  
                      </ul>
                      <?php
                  } else {
                      echo "<button type='button' data-bs-toggle='modal' data-bs-target='#loginModal'>Log In</button>";
                  }
                  ?>
              </li>
            </ul>

        </div>
    </nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Login Form -->
        <form id="loginForm">
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="loginEmail" name="loginEmail" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="loginPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginPassword" name="loginPassword">
          </div>
          <center>
            <button type="button" id="loginManual" class="btn btn-primary">Login</button>
            <br><label>or</label><br>
            <button type="button" id="loginGmail"> <i class="fab fa-google"></i> Login with Google</button>
          </center>
          <br><hr><br>
          <center>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal" style="background-color: transparent; color:black; border:none;" onmouseover="this.style.color='blue'" onmouseout="this.style.color='black'">
              Don't have an account?<br>Sign Up
            </button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Sign Up Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="SignUpForm">
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="signupEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
          </div>
          <div class="mb-3">
            <label for="signupPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="signupPassword" required>
          </div>
          <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
              <div class="row">
                <div class="col-8">
                <input type="number" class="form-control" id="otp" name="otp" placeholder="000000" pattern="[0-9]*" maxlength="6" required>
              </div>
              <div class="col-4">
                <button type="button" id="submitOTP" class="btn btn-success">Send OTP</button>
              </div>
            </div>
          </div>
          <center>
            <button type="button" id="signupManual" class="btn btn-primary">Sign Up</button>
            <br><label>or</label><br>
            <button type="button" id="signupGmail"> <i class="fab fa-google"></i> Sign in with Google</button>
          </center>
          <br><hr><br>
          <center>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" style="background-color: transparent; color:black; border:none;" onmouseover="this.style.color='blue'" onmouseout="this.style.color='black'">
              Already have an account?<br>Log In
            </button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="marquee-container">
    <!-- Marquee Content -->
        <div class="marquee">

            <h1>Buhay Shop</h1>
        </div>
    </div>
    <br>
    <div class="product-grid m-5">
        <?php 
        // Loop through your products and display each one
        while ($row1 = $view_rs->fetch_assoc()) {
            
        ?>
        <div class="product-item">
            <a href="product_details.php?product_id=<?php echo $row1['product_id']; ?>">
            <?php
              if($row1['images'] !== "a:0:{}"){
                $image_array = unserialize($row1['images']);
                $first_image_path = $image_array[0];  
            ?>
              <img src="<?php echo "admin/". $first_image_path; ?>" alt="Images">
            <?php
              }else{
                $first_image_path = "images/default-image-product.png";
            ?>
            <img src="<?php echo $first_image_path; ?>" alt="Images">
            <?php    
              }
            ?>
                <h3><?php echo $row1['name']; ?></h3>
                <p>₱<?php echo $row1['base_price']; ?></p>
            </a>
        </div>
        <?php 
        }
        ?>
    </div>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

        <!-- Include home.js -->
        <script src="home.js"></script>

</body>
</html>
