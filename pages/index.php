<?php
session_start();
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailoring System | Home</title>
    <link rel="icon" href="../images/icon.png"> 
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet"> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="../public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/style.css" rel="stylesheet">
        <!-- Main Template CSS Files -->
    <link href="../public/assets/css/aos.css" rel="stylesheet">
    <link href="../public/assets/css/glightbox.min.css" rel="stylesheet">
    <link href="../public/assets/css/swiper-bundle.min.css" rel="stylesheet">
    <style>
        /* Custom styling */
        .login-container {
            max-width: 50%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #410093;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        .login-form label {
            color: white;
        }
        .login-form input[type="email"],
        .login-form input[type="password"] {
            border-color: #ffffff;
            color: w;
        }
        .login-form button {
            background-color: #A45EE9;
            border-color: #6c63ff;
            color: white;
            width: 20%;
        }
        .login-form button:hover {
            background-color: #A45EE9;
            border-color: #563bff;
        }
        .logo1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo1 img {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }
        .logo1 h2 {
            color: white;
            font-size: 24px;
            margin: 0;
            display: inline-block;
            vertical-align: middle;
        }
        .logo1 .logo-text {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
    </style>

</head>
<body>
   <!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
   <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
       <span class="sr-only">Loading...</span>
   </div>
</div>
<!-- Spinner End -->

<!-- Navbar & Hero Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-xl navbar-light">
        <div class="container-fluid">
            <a href="index.php" class="logo" style="margin-left: 1%">
                <img src="../images/logo.png" alt="logo">
                <h2>Tailoring System</h2>
            </a>    
            
                    

            <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="../index.php" class="nav-item nav-link" style="color: white;">Home</a>
                <a href="../index.php#services" class="nav-item nav-link">Services</a>
                <a href="../index.php#team" class="nav-item nav-link">Team</a>
                <a href="../index.php#footer" class="nav-item nav-link">Contact Us</a>
            </div>
            <a href="../index.php#inquire" class="btn rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0" style="background: #A45EE9;">Inquire</a>
        </div>

        </div>
    </nav>

<!-- Login Modal -->
<br><br><br><br><br><br><br><br>
<div class="login-container">
        <!-- Logo and Text -->
        <div class="logo1">
            <img src="../images/logo.png" alt="logo">
            <div class="logo-text">
                <h2>Tailoring System Administrator</h2>
            </div>
        </div>
        
        <!-- Login Form -->
        <form class="login-form" id="loginForm">
            <div class="mb-3">
                <label for="loginEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="loginEmail" name="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Password">
            </div>
            <div class="text-center">
                <button type="button" id="loginManual" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
<div>
<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

        <!-- Include home.js -->
        <script src="../home.js"></script>
        <!-- JavaScript Libraries -->
        <script src="../public/lib/wow/wow.min.js"></script>
        <script src="../public/lib/easing/easing.min.js"></script>
        <script src="../public/lib/waypoints/waypoints.min.js"></script>
        <script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>

        <script src="../public/js/main.js"></script>
        <script>
            $(document).ready(function(){
                // Smooth scrolling when clicking on navbar links
                $('.nav-item.nav-link').on('click', function() {
                    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                        if (target.length) {
                            $('html, body').animate({
                                scrollTop: target.offset().top
                            }, 1000);
                            return false;
                        }
                    }
                });
            });
        </script>
        <script>
    $(document).ready(function() {
        $('#timeline-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000, // Transition to next item every 5 seconds
            autoplayHoverPause: true,
            nav: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        });
        new WOW().init(); // Initialize WOW.js
    });
</script>
        <!-- Include home.js -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

        <!-- Vendor JS Files -->
        <script src="../public/assets/js/aos.js"></script>
        <script src="../public/assets/js/bootstrap.bundle.js"></script>
        <script src="../public/assets/js/glightbox.min.js"></script>
        <script src="../public/assets/js/swiper-bundle.min.js"></script>
        <script src="../public/assets/js/noframework.waypoints.js"></script>

        <!-- Template Main JS File -->
        <script src="../public/assets/js/script.js"></script>
        <script src="../public/assets/js/main.js"></script>

</body>
</html>
