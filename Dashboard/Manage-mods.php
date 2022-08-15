<?php

// Include config file
require_once(dirname(dirname(__FILE__)) . "/config.php");

include(INCLUDE_PATH . "/logic/logic-manage-accs.php");



if (!$role->isAdmin($_SESSION["id"]) && $role->getRoleID($_SESSION["id"]) != 2) {
  echo '<h1 style="color : red;text-align: center;">FORBIDDEN PAGE 404</h1>';
  exit;
}

if (isset($_GET["logout"])) {
  $user->logout();
}

?>
<!-- ********************************************** Front end ****************************************************** -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Smart Traveller | Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- logo icons -->
  <link href="https://smart-traveller.000webhostapp.com/assets/img/logo.png" rel="icon">
  <link href="https://smart-traveller.000webhostapp.com/assets/img/logo.png" rel="apple-touch-icon">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

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
  <?php
  //navbar
  include(INCLUDE_PATH . "/layouts/navbar.php");
  ?>
  <div class="border-top"></div>
  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta mb-5 py-5 border-bottom" style=" height: 140px; background: rgba(218, 90, 90, 0.918); ">
    <div class="container" data-aos="fade-in">

      <div class="text-center">
        <h3>
          <?php if (!isset($_GET["account_id"])) : ?>
            <b id="text-dashboard"> Dashboard </b> /
            <?php if ($role->isAdmin($_SESSION["id"])) {
              echo "Manage moderators";
            } else {
              echo "Moderators list";
            }
          else :  ?>
            <a href="Manage-mods" id="manage-href"> Manage moderators </a>
            / Account profile
          <?php endif; ?>

          <?php


          ?>
        </h3>
      </div>
    </div>
  </section><!-- End Cta Section -->
  <?php
  // body
  include(INCLUDE_PATH . "/layouts/Manage-accs.php");
  //footer
  include(INCLUDE_PATH . "/layouts/footer.php");
  //modals
  include(INCLUDE_PATH . "/layouts/manageAccount-modals.php");
  ?>


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

  <script>
    $(document).ready(function() {
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>

</body>

</html>