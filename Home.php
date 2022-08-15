<?php

// Include config file
require_once realpath("config.php");

include(INCLUDE_PATH . "/logic/logic-home.php");




?>
<!-- ********************************************** Front end ****************************************************** -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Smart Traveller | Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />

  <!-- logo icons -->
  <link href="https://smart-traveller.000webhostapp.com/assets/img/logo.png" rel="icon">
  <link href="https://smart-traveller.000webhostapp.com/assets/img/logo.png" rel="apple-touch-icon">

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



  <!-- body -->
  <div class="container-fluid">

    <!-- ======= Weather Section ======= -->
    <section id="cta" class="cta mt-3 py-2 border-bottom " style=" height: 100%;background: rgba(181, 223, 110, 0.856);">

      <div class="container" data-aos="fade-in">
        <div class="row text-center">
          <div class="col-md">
            <h2 style="
                          -webkit-text-fill-color: #fd5151d7; 
                          -webkit-text-stroke-width: 1px;
                          -webkit-text-stroke-color: black;">
              <b>Your current weather</b>
            </h2>
          </div>
        </div>

        <div class="row ">
          <div class="col-md-4 text-center">
            <h6><b>Location</b></h6>
            <br>
            <h5 id="location"></h5>
          </div>
          <div class="col-md-4 text-center">
            <h6><b>Condition</b></h6>

            <img src="" alt="" srcset="" id="weather-icon" style="width: 50px;">
            <h5 class="desc">No Information Available.</h5>

          </div>
          <div class="col-md-4 text-center ">
            <h6><b>Temperature</b></h6>
            <h4 class="weather mt-4 c">
            </h4>
          </div>
        </div>


      </div>
    </section><!-- End Weather Section -->

    <!-- ======= carousel start ======= -->
    <div id="slider" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
        <li data-target="#slider" data-slide-to="0" class="active"></li>
        <li data-target="#slider" data-slide-to="1"></li>
        <li data-target="#slider" data-slide-to="2"></li>
      </ul>

      <!-- The slideshow -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/slide/slide-1.jpg" width="100%" height="100%">
        </div>
        <div class="carousel-item">
          <img src="assets/img/slide/slide-3.jpg" width="100%" height="100%">
        </div>
        <div class="carousel-item">
          <img src="assets/img/slide/slide-2.jpg" width="100%" height="100%">
        </div>
      </div>

      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#slider" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#slider" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>
    <!-- =======  carousel end ======= -->


    <div class="row my-3">
      <div class="col-md-7" data-aos="fade-right">
        <div id="map">
          <!-- My map -->
        </div>
      </div>
      <div class="col-md-5">
        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
          <div class="container" data-aos="fade-in">

            <div class="text-center" data-aos="fade-left">
              <h3>Visit the best places on the town</h3>
              <p>Our system use new technologies to suggest for you the best places you have to visit, taking into consideration the situation you are in, and your budget.</p>
              <a class="cta-btn" href="Recommendation">Get recommendations</a>
            </div>

          </div>
        </section><!-- End Cta Section -->

      </div>

    </div>


  </div>
  <!-- ======= Services Section ======= -->
  <section id="services" class="services  section-bg ">
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


  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Weather API service -->
  <script src="assets/js/weather.js"></script>

  <!-- Javascript for map -->
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

  <script>
    //user is not logged in, he is not allowed to see POI's details
    var is_loggedIn = true;
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

  if (isset($_GET["evaluate"])) {
    echo '<script> $("#feedback_modal").modal("show"); </script>';
  }

  //script to show modal when submitting a feedback
  if ($success) {
    echo '<script> $("#feedback_success_modal").modal("show"); </script>';
  } else {
    echo '<script> $("#feedback_success_modal").modal("hide"); </script>';
  }
  ?>

</body>

</html>