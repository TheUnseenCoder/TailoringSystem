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
    <link rel="icon" href="images/icon.png"> 
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet"> 

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <link href="public/lib/animate/animate.min.css" rel="stylesheet">
        <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <link href="public/css/bootstrap.min.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet">
          <!-- Main Template CSS Files -->
        <link href="public/assets/css/aos.css" rel="stylesheet">
        <link href="public/assets/css/glightbox.min.css" rel="stylesheet">
        <link href="public/assets/css/swiper-bundle.min.css" rel="stylesheet">
        <link href="public/assets/css/website.css" rel="stylesheet">
        <style>
        .bg-opacity-gray {
            background-color: rgba(128, 128, 128, 0.3); /* Gray background with opacity */
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
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-xl navbar-light">
        <div class="container-fluid">
            <a href="index.php" class="logo" style="margin-left: 1%">
                <img src="images/logo.png" alt="logo">
                <h2>Tailoring System</h2>
            </a>    
            
                    

            <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link" style="color: white;">Home</a>
                <a href="#Features" class="nav-item nav-link">Features</a>
                <a href="#team" class="nav-item nav-link">Team</a>
                <a href="#footer" class="nav-item nav-link">Contact Us</a>
            </div>
            <a href="#inquire" class="btn rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0" style="background: #A45EE9;">Inquire</a>
        </div>

        </div>
    </nav>

    <!-- Carousel Start -->
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="public/img/carousel-1.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Tailoring System.</h5>
                    <h1 class="display-1 text-capitalize text-white mb-4">One of the best Tailoring Shop System</h1>
                    <p class="mb-5 fs-5"> Online Ordering of created products, Online Payment, Payment Tracking and Customization Scheduling.
                    </p>
                    <a class="btn rounded-pill text-white py-3 px-5" href="#inquire" style="background: #410093;">Inquire</a>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="public/img/carousel-2.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Tailoring System.</h5>
                    <h1 class="display-1 text-capitalize text-white mb-4">One of the best Tailoring Shop System</h1>
                    <p class="mb-5 fs-5 animated slideInDown"> Online Ordering of created products, Online Payment, Payment Tracking and Customization Scheduling.
                    </p>
                    <a class="btn rounded-pill text-white py-3 px-5" href="#inquire" style="background: #410093;">Inquire</a>
                </div>
            </div>
        </div>
    </div>
   <!-- Carousel End -->
</div>
<!-- Navbar & Hero End -->

<section id="Features" style="">
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">What Do We Have?</h4>
                </div>
                <h1 class="display-3 mb-4">Tailoring System Features </h1>
                <p class="mb-0">Ensures comprehensive monitoring of orders and payments for administrative purposes while prioritizing utmost attention to customer preferences.
                </p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h1 class="mb-4">Modules</h1>
                                <p class="mb-4" style="font-size:24px;">Tailoring System. offers a variety of functions such as Order History, Payment History, Current Product Listing, and Customization Schedule.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h1 class="mb-4">Order History</h1>
                                <p class="mb-4" style="font-size:24px;">The Tailoring System offers a comprehensive overview of past/present orders, including details such as order dates, 
                                                                        items purchased, quantities, and statuses, enabling users to track their purchasing activity 
                                                                        and review previous transactions</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h1 class="mb-4">Payment History</h1>
                                <p class="mb-4" style="font-size:24px;">The Tailoring System provides a detailed record of all transactions, including dates, amounts, and payment methods, for comprehensive tracking and analysis.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h1 class="mb-4">Customization Schedule</h1>
                                <p class="mb-4" style="font-size:24px;">The Tailoring System prioritizes customer preferences by scheduling customization appointments, 
                                                                        allowing customers to meet with a tailor and specify their desired outfit modifications.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<section id="team">
    <div class="container">
        <div class="section-title wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Our Team</h4>
            </div>
            <h1 class="display-3">The Team</h1>
            <p class="mb-0">The team of talented developers behind this tailoring system has ingeniously crafted a platform that revolutionizes the way tailoring Features are accessed and managed.</p>
        </div>
    </div>
    <div class="slide-container swiper" data-swiper-autoplay="2000" data-aos="fade-up" data-aos-delay="800">
      <div class="slide-content my-5 overflow-hidden">
        <div class="card-wrapper swiper-wrapper">
          <div class="card swiper-slide small-card rounded">
            <div class="image-container">
              <img src="public/assets/img/dejesus.jpg" class="card-img-top rounded" alt="">
              <div class="mask"></div>
              <div class="card-body text-center text-white position-absolute w-100" style="bottom: 0;">
                  <label class="fw-bold fs-6">Darwin Eulin De Jesus</label>
                  <p class="" style="font-size: 13px;">Leader</p>
              </div>
            </div>
          </div>

          <div class="card swiper-slide small-card rounded">
            <div class="image-container">
              <img src="public/assets/img/buhay.jpg" class="card-img-top rounded" alt="">
              <div class="mask"></div>
              <div class="card-body text-center text-white position-absolute w-100" style="bottom: 0;">
                  <label class="fw-bold fs-6">Vincent Buhay</label>
                  <p class="" style="font-size: 13px;">Member</p>
              </div>
            </div>
          </div>

          <div class="card swiper-slide small-card rounded">
            <div class="image-container">
              <img src="public/assets/img/gonzales.jpg" class="card-img-top rounded" alt="">
              <div class="mask"></div>
              <div class="card-body text-center text-white position-absolute w-100" style="bottom: 0;">
                  <label class="fw-bold fs-6">Joshua Gonzales</label>
                  <p class="" style="font-size: 13px;">Member</p>
              </div>
            </div>
          </div>

          <div class="card swiper-slide small-card rounded">
            <div class="image-container">
              <img src="public/assets/img/maravilles.jpg" class="card-img-top rounded" alt="">
              <div class="mask"></div>
              <div class="card-body text-center text-white position-absolute w-100" style="bottom: 0;">
                  <label class="fw-bold fs-6">Nicole Maravilles</label>
                  <p class="" style="font-size: 13px;">Membber</p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="swiper-button-next swiper-navBtn"></div>
      <div class="swiper-button-prev swiper-navBtn"></div>
      <div class="swiper-pagination"></div>
    </div>
</section>

<section id="inquire">
    <div class="container-fluid appointment py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2">
                    <div class="section-title text-start">
                        <h4 class="sub-title pe-3 mb-0">Tailoring System</h4>
                        <h1 class="display-4 mb-4">One of the best Tailoring System</h1>
                        <p class="mb-4">Online Ordering of created products, Online Payment, Payment Tracking and Customization Scheduling.</p>
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-6">
                                        <h5 class="mb-0"><i class="fa fa-check me-2" style="color: #A45EE9"></i> Best Features</h5>
                                        <p class="mb-3">Ensures comprehensive monitoring of orders and payments for administrative purposes while prioritizing utmost attention to customer preferences.</p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0"><i class="fa fa-check me-2" style="color: #A45EE9"></i> Best Features</h5>
                                        <p class="mb-3">Prioritizes customer preferences by scheduling customization appointments, 
                                                                        allowing customers to meet with a tailor and specify their desired outfit modifications.</p>
                                    </div>
                                    <div class="text-center mb-6">
                                        <a href="#" class="btn rounded-pill text-white py-3 px-5" style="background: #A45EE9;">Download App Now!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-secondary" style="color: #A45EE9;">Get In Touch</p>
                        <h1 class="display-5 mb-4" style="color: white;">Inquire Now</h1>
                        <form id="inquiryForm">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <input type="text" name="first_name" class="form-control py-3 bg-transparent" placeholder="First Name" style="border-color: #A45EE9;color: white;">
                                </div>
                                <div class="col-xl-6">
                                    <input type="email" name="email" class="form-control py-3 bg-transparent" placeholder="Email" style="border-color: #A45EE9;color: white;">
                                </div>
                                <div class="col-xl-6">
                                    <input type="phone" name="phone" class="form-control py-3 bg-transparent" placeholder="Phone" style="border-color: #A45EE9;color: white;">
                                </div>
                                <div class="col-xl-6">
                                    <select class="form-select py-3 bg-transparent"  name="gender" aria-label="Default select example" style="border-color: #A45EE9;color: white;">
                                        <option selected style="color: black;">Your Gender</option>
                                        <option value="1" style="color: black;">Male</option>
                                        <option value="2" style="color: black;">Female</option>
                                        <option value="3" style="color: black;">Others</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control bg-transparent" name="text" id="area-text" cols="30" rows="5" placeholder="Write Inquiry" style="border-color: #A45EE9; color: white;"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="submitBtn" class="btn text-white w-100 py-3 px-5" style="background: #A45EE9;color: white;">SUBMIT INQUIRY</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Modal Video -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Teaser</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="footer">
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4"></i>Tailoring System</h4>
                        <p>Online Ordering of created products, Online Payment, Payment Tracking and Customization Scheduling.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Quick Links</h4>
                        <a href="index.php"><i class="fas fa-angle-right me-2"></i> Home</a>
                        <a href="#footer"><i class="fas fa-angle-right me-2"></i> Contact Us</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Privacy Policy</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Tailoring System Features</h4>
                        <a href="#Features"><i class="fas fa-angle-right me-2"></i> All Features</a>
                        <a href="#Features"><i class="fas fa-angle-right me-2"></i> Order History</a>
                        <a href="#Features"><i class="fas fa-angle-right me-2"></i> Payment History</a>
                        <a href="#Features"><i class="fas fa-angle-right me-2"></i> Customization Schedule</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Contact Info</h4>
                        <a href="https://maps.app.goo.gl/xSV6BunhHQoCwUiR7" onclick="window.open(this.href, '_blank'); return false;"><i class="fa fa-map-marker-alt me-2"></i> Check Our Location</a>
                        <a href="mailto:tailoringsystem@gmail.ph" onclick="window.open(this.href, '_blank'); return false;"><i class="fas fa-envelope me-2"></i>tailoringsystem@gmail.com</a>
                        <a href="" class="mb-3"><i class="fas fa-phone me-2"></i> +63 9150535787</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-white"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Tailoring System.</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed by Darwin Eulin A. De Jesus
                </div>
            </div>
        </div>
    </div>
</section>


</div>
<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>   

        

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

        <script src="public/lib/wow/wow.min.js"></script>
        <script src="public/lib/easing/easing.min.js"></script>
        <script src="public/lib/waypoints/waypoints.min.js"></script>
        <script src="public/lib/owlcarousel/owl.carousel.min.js"></script>

        <script src="public/js/main.js"></script>
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
        <script src="home.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

        <!-- Vendor JS Files -->
        <script src="public/assets/js/aos.js"></script>
        <script src="public/assets/js/bootstrap.bundle.js"></script>
        <script src="public/assets/js/glightbox.min.js"></script>
        <script src="public/assets/js/swiper-bundle.min.js"></script>
        <script src="public/assets/js/noframework.waypoints.js"></script>

        <!-- Template Main JS File -->
        <script src="public/assets/js/script.js"></script>
        <script src="public/assets/js/main.js"></script>

</body>
</html>
