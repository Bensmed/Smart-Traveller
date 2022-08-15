<?php

// Include config file
require_once realpath("config.php");

include(INCLUDE_PATH . "/logic/user-profile.php");


?>
<!-- ********************************************** Front end ****************************************************** -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Smart Traveller | Profile</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


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
<style>
  #body {
    margin-bottom: 150px;
  }
</style>

<body>

  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>
  <!-- ======= Cta Section ======= -->

  <div class="border-top"></div>
  <section id="cta" class="cta mb-5 py-5 border-bottom" style=" height: 140px; background: #85b03cd0;">
    <div class="container" data-aos="fade-in">

      <div class="text-center">
        <h3>Profile</h3>


      </div>

    </div>
  </section><!-- End Cta Section -->
  <!-- body -->
  <div class="container mt-4" id="body">

    <div class=" text-center">

      <h4 class="text-success">
        <?php echo $change_success; ?>
      </h4>
      <h4 class="text-danger">
        <?php echo $change_err . " <br> "; ?>
      </h4>
    </div>
    <div class="form-group" data-aos="fade-right">

      <div class="form-group">
        <label for="Fname">First name:</label>
        <div class="input-group">
          <input type="text" class="form-control <?php if ($Fname == NULL) {
                                                    echo "text-secondary font-italic";
                                                  } ?>" name="Fname" value="<?php if ($Fname == NULL) {
                                                                              echo "No information";
                                                                            } else {
                                                                              echo $Fname;
                                                                            } ?>" readonly>

          <div class="input-group-append">
            <button class="btn btn-green" data-toggle="modal" data-target="#new_info_modal">Edit</button>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="Lname">Last name:</label>
        <div class="input-group">
          <input type="text" class="form-control <?php if ($Lname == NULL) {
                                                    echo "text-secondary font-italic";
                                                  } ?>" name="Lname" value="<?php if ($Lname == NULL) {
                                                                              echo "No information";
                                                                            } else {
                                                                              echo $Lname;
                                                                            } ?>" readonly>
          <div class="input-group-append">
            <button class="btn btn-green" data-toggle="modal" data-target="#new_info_modal">Edit</button>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="age">Birthday:</label>
        <div class="input-group">
          <input type="date" class="form-control <?php if ($age == NULL) {
                                                    echo "text-secondary font-italic";
                                                  } ?>" name="age" value="<?php echo $age ?>" readonly>
          <div class="input-group-append">
            <button class="btn btn-green" data-toggle="modal" data-target="#new_info_modal">Edit</button>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="niv">Function:</label>
        <div class="input-group">
          <input type="text" class="form-control <?php if ($function == NULL) {
                                                    echo "text-secondary font-italic";
                                                  } ?>" name="function" value="<?php if ($function == NULL) {
                                                                                  echo "No information";
                                                                                } else {
                                                                                  echo $function;
                                                                                } ?>" readonly>
          <div class="input-group-append">
            <button class="btn btn-green" data-toggle="modal" data-target="#new_info_modal">Edit</button>
          </div>
        </div>
      </div>

      <div class="form-group ">
        <label for="email">Email:</label>
        <div class="input-group">
          <input type="email" class="form-control" name="email" value="<?php echo $email ?>" readonly>
        </div>
      </div>

      <div id="accordion">
        <div class="form-group ">
          <label for="phone">Phone number:</label>
          <div class="card">

            <div class="input-group">
              <input type="text" class="form-control <?php if ($phone == NULL) {
                                                        echo "text-secondary font-italic";
                                                      } ?>" name="phone" value="<?php if ($phone == NULL) {
                                                                                  echo "No information";
                                                                                } else {
                                                                                  echo $phone;
                                                                                } ?>" readonly>
              <div class="input-group-append">
                <button class="btn btn-green" data-toggle="collapse" data-target="#new_phone_form">Change</button>
              </div>
            </div>

            <!--collapse phone form-->
            <div id="new_phone_form" class="collapse" data-parent="#accordion">
              <div class="card-body">
                <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="POST">
                  <div class="form-group">
                    <div class="form-group">
                      <label for="new_phone">New phone:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <select class="form-control" name="new_phone_operator" required>
                            <option value="05" <?php if ($new_phone_operator == "05") {
                                                  echo "Selected";
                                                } ?>>05</option>
                            <option value="06" <?php if ($new_phone_operator == "06") {
                                                  echo "Selected";
                                                } ?>>06</option>
                            <option value="07" <?php if ($new_phone_operator == "07") {
                                                  echo "Selected";
                                                } ?>>07</option>
                          </select>
                        </div>
                        <input type="text" class="form-control w-50" name="new_phone" placeholder="Phone number" value="<?php echo $new_phone ?>" required />
                      </div>
                      <small class="text-danger"><?php echo $new_phone_err ?></small>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-submit" name="change_phone_submit">Change phone</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group ">
          <label for="password">Password:</label>
          <div class="card">
            <div class="card-header">
              <div class="input-group">
                <input type="password" class="form-control" name="password" value="<?php echo $password ?>" readonly>
                <div class="input-group-append">
                  <button class="btn btn-green" data-toggle="collapse" href="#new_password_form">Change</button>
                </div>
              </div>
            </div>
            <!--collapse password form-->
            <div id="new_password_form" class="collapse" data-parent="#accordion">
              <div class="card-body">
                <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="POST">
                  <div class="form-group">
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Current password" name="current_password" required>
                      <small class="text-danger"><?php echo $current_password_err ?></small>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="New password" name="new_password" required>
                      <small class="text-danger"><?php echo $new_password_err ?></small>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Confirm new password" name="confirm_new_password" required>
                      <small class="text-danger"><?php echo $confirm_new_password_err ?></small>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-submit" name="new_password_submit">Change password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!---->
          </div>
        </div>
      </div>
    </div>

  </div>


  <!--footer-->
  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <!-- Change personal informations Modal -->
  <div class="modal fade" id="new_info_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit personal informations</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="POST">
            <div class="form-group">
              <div class="form-group">
                <label for="new_Fname">First name:</label>
                <input type="text" class="form-control" placeholder="Enter first name" name="new_Fname" value="<?php echo $new_Fname ?>" required>
                <small class=" text-danger"><?php echo $new_Fname_err ?></small>
              </div>
              <div class="form-group">
                <label for="new_Lname">Last name:</label>
                <input type="text" class="form-control" placeholder="Enter last name" name="new_Lname" value="<?php echo $new_Lname ?>" required>
                <small class="text-danger"><?php echo $new_Lname_err ?></small>
              </div>
              <div class="form-group">
                <label for="new_age">Birthday:</label>
                <input type="date" class="form-control" name="new_age" value="<?php echo $new_age ?>" required>
                <small class="text-danger"><?php echo $new_age_err ?></small>
              </div>
              <div class="form-group">

                <label for="new_function">Function: </label>

                <select class="form-control" name="new_function" id="new_function">
                  <option <?php if (empty($function)) {
                            echo "Selected";
                          } ?> value="">Select a function..</option>
                  <option <?php if ($function == "Student") {
                            echo "Selected";
                          } ?> value="Student">Student</option>
                  <option <?php if ($function == "Employee") {
                            echo "Selected";
                          } ?> value="Employee">Employee</option>
                  <option <?php if ($function == "Unemployed") {
                            echo "Selected";
                          } ?> value="Unemployed">Unemployed</option>

                </select>
                <small class="text-danger"><?php echo $new_function_err ?></small>
              </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-submit" name="changePersonal_info_submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

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
    if ($new_Fname_err || $new_Lname_err || $new_age_err || $new_function_err) {
      echo '<script> $("#new_info_modal").modal("show"); </script>';
    } else {
      echo '<script> $("#new_info_modal").modal("hide"); </script>';
    }
    if ($new_phone_err) {
      echo '<script> $("#new_phone_form").collapse("show"); </script>';
    } else {
      echo '<script> $("#new_phone_form").collapse("hide"); </script>';
    }
    if ($new_email_err) {
      echo '<script> $("#new_email_form").collapse("show"); </script>';
    } else {
      echo '<script> $("#new_email_form").collapse("hide"); </script>';
    }
    if ($current_password_err || $new_password_err || $confirm_new_password_err) {
      echo '<script> $("#new_password_form").collapse("show"); </script>';
    } else {
      echo '<script> $("#new_password_form").collapse("hide"); </script>';
    }

    ?>


</body>

</html>