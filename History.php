<?php

// Include config file
require_once realpath("config.php");

redirectIfNeeded();

// Check if the user is already logged in, if no then redirect him to index page
if (!$user->is_loggedin()) {
  $user->redirect("/");
  exit;
}

if (isset($_GET["logout"])) {
  $user->logout();
}

$nRow_pPage = 8;

if (isset($_GET['pageNo'])) {
  $pageNo = $_GET['pageNo'];
} else {
  $pageNo = 1;
}

$total_pages = ceil($user->count_visitedPoi_history($_SESSION["id"]) / $nRow_pPage);

if (isset($_GET["visited"])) {
  //get the details of the POI, to show the name of the POI in the success text.
  $poi_details = $map->fetch_poi_details($_GET["visited"]);
  //Output a success message, with the name of the visited POI.
  $visit_success = "<i class='fa fa-check' aria-hidden='true'></i> You have visited '" . $poi_details['designation'] . "'.";
}

?>
<!-- ********************************************** Front end ****************************************************** -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Smart Traveller | History</title>
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

  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>

  <div class="border-top"></div>

  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta mb-5 py-5 border-bottom" style=" height: 140px; background: #df9c01a2; ">
    <div class="container" data-aos="fade-in">

      <div class="text-center">
        <h3>History</h3>


      </div>

    </div>
  </section><!-- End Cta Section -->

  <!-- body -->
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col-md">
        <?php if (isset($_GET["visited"])) : ?>
          <h5 class="text-success"> <?php echo $visit_success; ?></h5>
        <?php endif; ?>
      </div>
    </div>
    <br>

    <div class="row mt-3">
      <div class="col-md-8 mx-auto">
        <table class="table table-hover mb-5" data-aos="fade-up">
          <thead class="table-warning">
            <tr>
              <th>Point of interest</th>
              <th>Type</th>
              <th>Date of visit</th>
              <th></th>
            <tr>
          </thead>
          <tbody>
            <?php
            $history = $user->fetch_visit_history($_SESSION["id"], $pageNo, $nRow_pPage);
            if ($history == "") { ?>
          </tbody>
        </table>
        <p class=" text-center " style="font-size: 19px">You did not visit any point of interest yet. </p>

      <?php
            } else {
              foreach ($history as $poi) {

                echo "<tr>";
                echo "<td>" . $poi["designation"] . "</td>";
                echo "<td>" . $poi["type"] . "</td>";
                echo "<td>" . date("H:ia : d-m-Y", strtotime($poi["date"]))  . "</td>";
                echo '<td><a class="btn btn-evaluate" name="feedback_redirect"  href="Recommendation?poi_details_id=' . $poi['id'] . '&evaluate#poi_details" >Evaluate</a></td>';
              }
              echo "</tbody>";
              echo "</table>";
            }
      ?>
      <?php if ($total_pages != 1) : ?>
        <ul class="pagination pagination-history justify-content-center my-5">
          <li class="page-item <?php if ($pageNo <= 1) {
                                  echo "disabled";
                                } ?>"><a class="page-link" href="<?php if ($pageNo <= 1) {
                                                                    echo '#';
                                                                  } else {
                                                                    echo "?pageNo=" . ($pageNo - 1);
                                                                  }
                                                                  ?>">Previous</a></li>
          <?php
          for ($page = 1; $page <= $total_pages; $page++) : ?>
            <li class="page-item <?php if ($page == $pageNo) {
                                    echo "active";
                                  } ?>"><a class="page-link" href="<?php echo '?pageNo=' . $page . '">' . $page ?></a></li>
        <?php endfor; ?>
        <li class=" page-item <?php if ($pageNo >= $total_pages) {
                                echo "disabled";
                              } ?>"><a class="page-link" href="<?php if ($pageNo == $total_pages) {
                                                                  echo '#';
                                                                } else {
                                                                  echo "?pageNo=" . ($pageNo + 1);
                                                                }
                                                                ?>">Next</a></li>

        </ul>
      <?php endif; ?>
      </div>


    </div>
  </div>
  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

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

</body>