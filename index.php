<?php


// Include config file
require_once realpath("config.php");

include(INCLUDE_PATH . "/logic/user-login.php");
include(INCLUDE_PATH . "/logic/user-signup.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Smart Traveller</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- logo icons -->
  <link href="https://smart-traveller.000webhostapp.com/assets/img/logo.png" rel="icon">
  <link href="https://smart-traveller.000webhostapp.com/assets/img/logo.png" rel="apple-touch-icon">

  <!-- leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/line-awesome/css/line-awesome.min.css" rel="stylesheet">
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="https://smart-traveller.000webhostapp.com/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="https://smart-traveller.000webhostapp.com/assets/css/style.css" rel="stylesheet">

</head>

<body>

  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container" data-aos="fade-up">
      <h1>Welcome to Smart Traveller</h1>
      <h2>We recommend the best places that correspond to your preferences according to the situation you are in.</h2>
      <a class="btn-get-started" data-toggle="modal" data-target="#signupModal" data-dismiss="modal" href="#">Sign up Now!</a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about" data-aos="fade-up" style="margin-top: -200px;">
      <div class="row " id="row_map_weather">

        <div id="map" class="col-md-8 border border-secondary mx-auto" style="box-shadow: 5px 15px 10px rgba(0, 0, 0, 0.1);border-radius: 8px;width: 1200px;">
          <!-- My map -->
        </div>
        <div class="col-md-3 container text-center border border-secondary" style="background-color: #aacd6b;border-radius: 8px;height:  680px;box-shadow: 5px 15px 10px rgba(0, 0, 0, 0.1);">

          <h1 class="mt-5" style="
                                     -webkit-text-fill-color: #fd5151d7; 
                                     -webkit-text-stroke-width: 1px;
                                     -webkit-text-stroke-color: black;">
            <b>Your current weather</b>
          </h1>
          <br>
          <h2><b>Location : </b></h2>
          <br>
          <h2 id="location"></h2>
          <img src="" alt="" srcset="" id="weather-icon" style="width: 200px;">

          <h5 class="desc">No Information Available.</h5>
          <h1 class="weather mt-5">
            <b>
              <div class="c"></div>
            </b>
          </h1>


        </div>

      </div>

    </section><!-- End About Section -->


    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg ">
      <div class="container">

        <div class="section-title pt-5" data-aos="fade-up">
          <h2>Our Services</h2>
        </div>

        <div class="row">
          <div class="col-md-6" data-aos="fade-up">
            <div class="icon-box" style="cursor: pointer;">
              <div class="icon"><i class="las la-globe-americas" style="color: #d6ff22;"></i></div>
              <h4 class="title"><a>Visit interesting places</a></h4>
              <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
            </div>
          </div>

          <div class="col-md-6" data-aos="fade-up">
            <div class="icon-box" style="cursor: pointer;">
              <div class="icon"><i class="las la-book" style="color: #e9bf06;"></i></div>
              <h4 class="title"><a>Get exclusive recommendations</a></h4>
              <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
            </div>
          </div>

          <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box" style="cursor: pointer;">
              <div class="icon"><i class="las la-file-alt" style="color: #3fcdc7;"></i></div>
              <h4 class="title"><a>Read all the details</a></h4>
              <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
            </div>
          </div>



          <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box" style="cursor: pointer;">
              <div class="icon"><i class="las la-clock" style="color: #4680ff;"></i></div>
              <h4 class="title"><a>Save time</a></h4>
              <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
            </div>
          </div>
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="las la-tachometer-alt" style="color:#41cf2e;"></i></div>
              <h4 class="title"><a href="">Give us your feedback</a></h4>
              <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
            </div>
          </div>
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box" style="cursor: pointer;">
              <div class="icon"><i class="las la-basketball-ball" style="color: #ff689b;"></i></div>
              <h4 class="title"><a>Have fun</a></h4>
              <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

  </main><!-- End #main -->


  <!-- ======= Footer ======= -->
  <?php
  include(INCLUDE_PATH . "/layouts/footer.php") ?>

  <!-- Login Modal -->
  <?php include(INCLUDE_PATH . "/layouts/signupModal.php") ?>
  <!-- Login Modal -->
  <?php include(INCLUDE_PATH . "/layouts/loginModal.php") ?>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>



  <!-- Weather API service -->
  <script src="assets/js/weather.js"></script>


  <!-- Javascript for map -->
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

  <script>
    //user is not logged in, he is not allowed to see POI's details
    var is_loggedIn = false;
  </script>

  <!-- map-->
  <script type="text/javascript" src="assets/js/default_map.js"></script>

  <!-- Vendor JS Files -->
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/jquery/jquery.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/php-email-form/validate.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/counterup/counterup.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/venobox/venobox.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="https://smart-traveller.000webhostapp.com/assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="https://smart-traveller.000webhostapp.com/assets/js/main.js"></script>
  <?php
  //script to show modal in case of errors
  if ($email_err || $password_err) {
    echo '<script> $("#loginModal").modal("show"); </script>';
  } else {
    echo '<script> $("#loginModal").modal("hide"); </script>';
  }
  //script to show modal in case of errors
  if ($email_signup_err || $password_signup_err) {
    echo '<script> $("#signupModal").modal("show"); </script>';
  } else {
    echo '<script> $("#signupModal").modal("hide"); </script>';
  }
  ?>


</body>

</html>