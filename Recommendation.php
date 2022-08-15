<?php

// Include config file
require_once realpath("config.php");

include(INCLUDE_PATH . "/logic/logic-recommendation.php");




?>
<!-- ********************************************** Front end ****************************************************** -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Smart Traveller | Recommendation</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- logo icons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/line-awesome/css/line-awesome.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="https://smart-traveller.000webhostapp.com/assets/css/style.css" rel="stylesheet">

</head>

<body>

  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>
  <div class="border-top"></div>
  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta mb-5 py-5 border-bottom" style=" height: 140px;">
    <div class="container" data-aos="fade-in">

      <div class="text-center">
        <h3>Recommendation</h3>


      </div>

    </div>
  </section><!-- End Cta Section -->
  <!-- body -->
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col-md">

        <?php if ($visit_success) : ?>
          <h5 class="text-success"> <?php echo $visit_success; ?></h5>
        <?php endif;
        if ($err) : ?>
          <h5 class="text-danger"> <?php echo $err; ?></h5>
        <?php endif; ?>

      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-7">
        <h3 class="mb-3 ml-3" data-aos="fade-in">Places that are recommended for you to visit:</h3>
        <table class="table " data-aos="fade-up">
          <thead class="bg-green">
            <tr>
              <th>Designation</th>
              <th>Type</th>
              <th>Views</th>
              <th></th>
            <tr>
          </thead>
          <tbody>
            <?php include(INCLUDE_PATH . "/logic/RS-table.php"); ?>
          </tbody>
        </table>

        <?php if (!isset($_GET["show_all_places"])) : ?>
          <div class="d-flex justify-content-center" data-aos="fade-up">

            <a class="btn btn-green " name="show_all_places" href="?show_all_places" style="border-radius: 20px; padding: 10px 20px 10px 20px;">Show all places...</a>

          </div>
        <?php else :  ?>
          <?php if ($total_pages != 1) : ?>
            <ul class="pagination pagination-POIs justify-content-center my-5">
              <li class="page-item <?php if ($pageNo <= 1) {
                                      echo "disabled";
                                    } ?>"><a class="page-link" href="<?php if ($pageNo <= 1) {
                                                                        echo '#';
                                                                      } else {
                                                                        echo "?show_all_places&pageNo=" . ($pageNo - 1) . "#POIs_list";
                                                                      }
                                                                      ?>">Previous</a></li>
              <?php
              for ($page = 1; $page <= $total_pages; $page++) { ?>
                <li class="page-item <?php if ($page == $pageNo) {
                                        echo "active";
                                      } ?>"><a class="page-link" href="<?php echo '?show_all_places&pageNo=' . $page . "#POIs_list" ?> "> <?php echo $page ?> </a></li>
              <?php } ?>
              <li class="page-item <?php if ($pageNo >= $total_pages) {
                                      echo "disabled";
                                    } ?>"><a class="page-link" href="<?php if ($pageNo == $total_pages) {
                                                                        echo '#';
                                                                      } else {
                                                                        echo "?show_all_places&pageNo=" . ($pageNo + 1) . "#POIs_list";
                                                                      }
                                                                      ?>">Next</a></li>

            </ul>
          <?php endif; ?>
        <?php endif; ?>


      </div>
      <div class="col-md-5" data-aos="fade-left">
        <div id="map" class="mt-5 ">
          <!-- My map -->
        </div>
      </div>

    </div>
    <?php if (isset($_GET["poi_details_id"])) : ?>
      <div class="row">

        <div class="col-md" id="poi_details">

          <div class="card ">
            <div class="card-header bg-green text-center text-light">
              <div class="row">
                <div class="col-md">
                  <?php echo "<h4>" . $designation . "</h4>";    ?>
                </div>

              </div>
            </div>
            <!-- ======= Cta Section ======= -->
            <div id="cta" class="cta-visited ">

              <div class="row " data-aos="fade-right" style="margin-top: 20px;">
                <div class="col-md d-flex justify-content-center">
                  <p>Have you been there ? Click </p>
                  <form method="POST" action=<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"]))  ?>>
                    <input type="hidden" name="visited_poi_id" value=<?php echo $_GET["poi_details_id"]; ?>>
                    <input type="hidden" name="RS1" value=<?php if (isset($_GET["RS1"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS2" value=<?php if (isset($_GET["RS2"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS3" value=<?php if (isset($_GET["RS3"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS4" value=<?php if (isset($_GET["RS4"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS5" value=<?php if (isset($_GET["RS5"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS6" value=<?php if (isset($_GET["RS6"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS7" value=<?php if (isset($_GET["RS7"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS8" value=<?php if (isset($_GET["RS8"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>
                    <input type="hidden" name="RS9" value=<?php if (isset($_GET["RS9"])) {
                                                            echo True;
                                                          } else {
                                                            echo false;
                                                          } ?>>

                    <input type="hidden" name="nb_rec" value=<?php echo count($recommended_pois_list); ?>>
                    <button type="submit" class="btn cta-visited-btn" name="visit_submit">Visited <i class="fa fa-check" aria-hidden="true"></i></button>
                  </form>
                </div>
              </div>

            </div><!-- End Cta Section -->
            <div class="card-body text-center my-2 border-top">

              <div class="row">
                <div class="col-md my-2">
                  <?php
                  if (isset($_GET["poi_details_id"])) {
                    echo "<h5 class='text-danger'> Description :</h5>";
                    echo "<p>";
                    if ($description == null) {
                      echo $type;
                    } else {
                      echo $description;
                    }
                    echo "</p> <br>";
                    echo "<h5 class='text-danger'> Opening time :</h5>";
                    if ($open_time == $close_time) {
                      echo "24h/7d";
                    } else {
                      echo "From " . $open_time . " to " . $close_time;
                    }
                  ?>
                    <br>
                    <!-- Weather -->
                    <h1 class="mt-5">
                      <h5 class='text-danger'> Current weather :</h5>
                    </h1><br>
                    <div class="col-md-2 container border" style="border-radius: 120px;box-shadow: 5px 15px 10px rgba(0, 0, 0, 0.1);">
                      <h5 class="weather mt-5">
                        Temperatue:
                        <b>
                          <div class="c"></div>
                        </b>
                      </h5>

                      <img src="" alt="" srcset="" id="weather-icon">
                      <h5 class="desc">No Information Available.</h5>
                      <br>
                    </div>
                    <div class="row my-5">
                      <div class="col-md">
                        <h5 class='text-danger'> Feedbacks :</h5>
                        <div class="my-3">
                          <label class="bg-green"><i>* Your feedback improve our recommendation system</i></label>
                        </div>
                        <label class="mr-5">Please, give us your feedback : </label>
                        <button class="btn btn-evaluate ml-5" data-toggle="modal" data-target="#feedback_modal" name="feedback_btn">Evaluate</button>

                      </div>
                    </div>
                    <?php
                    if (isset($_GET["poi_details_id"])) {
                      if ($feedbacks = $user->fetch_poi_feedback($id)) {
                        foreach ($feedbacks as $feedback) { ?>
                          <div class="row mb-5">
                            <div class="col-md-9 mx-auto">
                              <div class="card">
                                <div class="card-header " style="background-color: #ffdf96;">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <label class="d-flex justify-content-start ml-2 font-italic"><?php echo $feedback["Fname"] . " " . $feedback["Lname"] . " :"; ?></label>
                                    </div>
                                    <div class="col-md-6">
                                      <span class="d-flex justify-content-end mr-3 font-weight-bold font-italic 
                                    <?php
                                    if ($feedback["rate"] < 3) {
                                      echo "text-danger";
                                    } else if ($feedback["rate"] == 3) {
                                      echo "text-warning";
                                    } else {
                                      echo "text-success";
                                    }




                                    ?>
                                    
                                    "><?php echo $feedback["rate"] . " Star(s)"; ?></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <?php if ($feedback["comment"] == "") : ?>
                                    <p class="text-center text-secondary">No comment.</p>
                                  <?php else : ?>
                                    <p class="text-center"><?php echo $feedback["comment"]; ?></p>
                                  <?php endif; ?>
                                </div>
                                <div class="card-footer font-italic text-secondary"><span class="d-flex justify-content-end"><?php echo date("H:ia : d-m-Y", strtotime($feedback["date_feedback"])); ?></span></div>
                              </div>
                            </div>
                          </div>
                    <?php
                        }
                      }
                    }
                    ?>



                  <?php
                  } else {
                    echo "<h5> There is no details </h5>";
                  }
                  ?>
                </div>
              </div>

            </div>


          </div>
        </div>
      </div>
    <?php endif; ?>


  </div>


  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <!-- Feedback Modal -->
  <div class="modal fade" id="feedback_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Feedback</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="POST">
            <div class="form-group">
              <div class="form-group">
                <label for="rate" class="mr-5">Star(s) : </label>
                <div class=" form-check-inline">
                  <label class="form-check-label" for="Star1">
                    <input type="radio" class="form-check-input" id="Star1" name="rate" value=1 required>1
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="Star2">
                    <input type="radio" class="form-check-input" id="Star2" name="rate" value=2 required>2
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="Star3">
                    <input type="radio" class="form-check-input" id="Star3" name="rate" value=3 required>3
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="Star4">
                    <input type="radio" class="form-check-input" id="Star4" name="rate" value=4 required>4
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="Star5">
                    <input type="radio" class="form-check-input" id="Star5" name="rate" value=5 required>5
                  </label>
                </div>

              </div>
              <div class="form-group">
                <label for="comment">Comment : <small class="text-danger">(Optional) </small></label>
                <textarea class="form-control" placeholder="Write a comment ..." name="comment"></textarea>
              </div>

              <input type="hidden" value="<?php echo $id ?>" name="poi_id" />
              <!-- only if available -->
              <input type="hidden" id="feedback_long" value="" name="feedback_long" />
              <input type="hidden" id="feedback_lat" value="" name="feedback_lat" />
              <input type="hidden" id="poi_weather" value="" name="poi_weather" />
              <input type="hidden" id="poi_temp" value="" name="poi_temp" />

            </div>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-submit" name="feedback_submit">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- feedback success modal -->
  <div class="modal fade" id="feedback_success_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Feedback</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <?php if ($success) {
            echo "<h5 class='text-center text-success'>" . $success . "</h5>";
          } else {
            echo "<h5 class='text-center text-danger'>" . $err . "</h5>";
          }
          ?>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Javascript for map -->
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>


  <!-- Pass variable to recommendations_map.js -->
  <script type="text/javascript">
    var sap_bool = <?php echo intval(isset($_GET['show_all_places'])) ?>;
  </script>

  <!-- map-->
  <script type="text/javascript" src="assets/js/recommendations_map.js"></script>


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

  //Pass weather and position data to feedback form
  if (isset($_GET["poi_details_id"])) {
    echo '<script type="text/javascript" src="assets/js/feedback_data.js"></script>';
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