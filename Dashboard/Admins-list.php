<?php

// Include config file
require_once(dirname(dirname(__FILE__)) . "/config.php");

redirectIfNeeded();

// Check if the user is already logged in, if no then redirect him to index page
if (!$user->is_loggedin()) {
  $user->redirect("/SmartTravel/");
  exit;
}

if (isset($_GET["logout"])) {
  $user->logout();
}

if (!$role->isAdmin($_SESSION["id"]) && $role->getRoleID($_SESSION["id"]) != 2) {
  echo '<h1 style="color : red;text-align: center;">THIS PAGE IS RESTRICTED FOR THIS ACCOUNT</h1>';
  exit;
}

$searchInput = $searchBy = "";

//pagination
$roleID = 1;
$nRow_pPage = 5;


if (isset($_GET["searchInput"]) && isset($_GET["searchBy"]) && $_GET["searchInput"] != "") {
  $searchInput = $_GET["searchInput"];
  if ($_GET["searchBy"] == "id") {
    $searchBy = "id";
    $total_pages = ceil($role->count_search_Accounts_byID($_GET["searchInput"]) / $nRow_pPage);
  } else if ($_GET["searchBy"] == "email") {
    $searchBy = "email";
    $total_pages = ceil($role->count_search_Accounts_byemail($_GET["searchInput"]) / $nRow_pPage);
  } else if ($_GET["searchBy"] == "firstName") {
    $searchBy = "firstName";
    $total_pages = ceil($role->count_search_Accounts_byFname($_GET["searchInput"]) / $nRow_pPage);
  } else if ($_GET["searchBy"] == "lastName") {
    $searchBy = "lastName";
    $total_pages = ceil($role->count_search_Accounts_byLname($_GET["searchInput"]) / $nRow_pPage);
  }
} else {
  $total_pages = ceil($role->count_Accounts_Of($roleID) / $nRow_pPage);
}

if (isset($_GET['pageNo'])) {
  $pageNo = $_GET['pageNo'];
} else {
  $pageNo = 1;
}
/** */

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
  <style>
    #body {
      margin-bottom: 150px;
    }
  </style>
  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>

  <div class="border-top"></div>
  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta mb-5 py-5 border-bottom" style=" height: 140px; background: rgba(218, 90, 90, 0.918); ">
    <div class="container" data-aos="fade-in">

      <div class="text-center">
        <h3> <b id="text-dashboard"> Dashboard </b>/ Admins list</h3>
      </div>
    </div>
  </section><!-- End Cta Section -->


  <!-- body -->
  <div class="container-fluid mt-4" id="body">
    <div class="row">
      <div class="col-sm-2 ">
        <div class="col-sm-12 mt-4 mx-auto">
          <?php include(INCLUDE_PATH . "/layouts/list-settings.php") ?>
        </div>
      </div>
      <div class="col-sm-9 ml-5">


        <br>
        <nav class="navbar navbar-expand-sm bg-red navbar-dark justify-content-end" data-aos="fade-up">
          <div class="mr-5">
            <form class="form-inline" method="GET">
              <input class="form-control mr-sm-2" name="searchInput" id="searchInput" type="text" placeholder="Search" value="<?php echo $searchInput; ?>">

              <select class="form-control mr-sm-2" id="searchBy" name="searchBy" style="cursor: pointer">
                <option value="" disabled selected>Search by...</option>
                <option <?php if ($searchBy == "id") echo "selected"; ?> value="id">ID</option>
                <option <?php if ($searchBy == "firstName") echo "selected"; ?> value="firstName">First name</option>
                <option <?php if ($searchBy == "lastName") echo "selected"; ?> value="lastName">Last name</option>
                <option <?php if ($searchBy == "email") echo "selected"; ?> value="email">Email</option>
              </select>


              <button class="btn btn-manage" type="submit">
                <i class="fa fa-search"></i>
              </button>
            </form>
          </div>
        </nav>
        <div data-aos="fade-up">
          <table class="table table-hover " style="cursor: pointer">
            <thead class="table-warning">
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Birthday</th>
                <th>Function</th>
                <th>Phone number</th>
                <th>Last seen</th>
              </tr>
            </thead>
            <tbody id="myTable">
              <?php
              if (isset($_GET["searchInput"]) && isset($_GET["searchBy"]) && $_GET["searchInput"] != "") {

                if ($_GET["searchBy"] == "id") {
                  if (!preg_match("/^[0-9]*$/", ($_GET["searchInput"]))) {
                    $userTable = "";
                  } else {
                    $userTable  = $role->search_accounts_ByID($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                  }
                } else if ($_GET["searchBy"] == "email") {
                  $userTable  = $role->search_accounts_ByEmail($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                } else if ($_GET["searchBy"] == "firstName") {
                  $userTable  = $role->search_accounts_ByFname($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                } else if ($_GET["searchBy"] == "lastName") {
                  $userTable  = $role->search_accounts_ByLname($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                }
              } else {
                $userTable = $role->fetch_accounts($roleID, $pageNo, $nRow_pPage);
              }
              if ($userTable == "") : ?>
            </tbody>
          </table>

          <p class=" text-center " style="font-size: 19px">There is no admins ! </p>
        <?php else :
                foreach ($userTable as $row) {
                  echo " <tr>";
                  echo "<td>" . $row['id'] . "</td> ";
                  echo "<td>" . $row['email'] . "</td> ";
                  echo "<td>" . $row['Fname'] . "</td> ";
                  echo "<td>" . $row['Lname'] . "</td> ";
                  echo "<td>" . date_format(date_create($row['age']), "d-m-Y") . "</td> ";
                  echo "<td>" . $row['function'] . "</td> ";
                  echo "<td>" . $row['phone'] . "</td> ";
                  echo "<td>" . $row['last_seen'] . "</td>";
                  echo "</tr>";
                }
        ?>
          </tbody>
          </table>
        <?php endif;
              if ($total_pages != 1) :
        ?>
          <ul class="pagination pagination-dashboard justify-content-center mt-4">
            <li class="page-item <?php if ($pageNo <= 1) {
                                    echo "disabled";
                                  } ?>"><a class="page-link" href="<?php if ($pageNo <= 1) {
                                                                      echo '#';
                                                                    } else {
                                                                      if (isset($_GET["searchInput"]) && isset($_GET["searchBy"])) {
                                                                        echo "?searchInput=" . $_GET["searchInput"] . "&searchBy=" . $_GET["searchBy"] . "&pageNo=" . ($pageNo - 1);
                                                                      } else {
                                                                        echo "?pageNo=" . ($pageNo - 1);
                                                                      }
                                                                    } ?>">Previous</a></li>
            <?php
                for ($page = 1; $page <= $total_pages; $page++) : ?>
              <li class="page-item <?php if ($page == $pageNo) {
                                      echo "active";
                                    } ?>"><a class="page-link" href="<?php if (isset($_GET["searchInput"]) && isset($_GET["searchBy"])) {
                                                                        echo "?searchInput=" . $_GET["searchInput"] . "&searchBy=" . $_GET["searchBy"] . "&pageNo=" . $page;
                                                                      } else {
                                                                        echo "?pageNo=" . $page;
                                                                      } ?>"><?php echo $page ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?php if ($pageNo >= $total_pages) {
                                    echo "disabled";
                                  } ?>"><a class="page-link" href="<?php if ($pageNo == $total_pages) {
                                                                      echo '#';
                                                                    } else {
                                                                      if (isset($_GET["searchInput"]) && isset($_GET["searchBy"])) {
                                                                        echo "?searchInput=" . $_GET["searchInput"] . "&searchBy=" . $_GET["searchBy"] . "&pageNo=" . ($pageNo + 1);
                                                                      } else {
                                                                        echo "?pageNo=" . ($pageNo + 1);
                                                                      }
                                                                    } ?>">Next</a></li>

          </ul>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <!--footer-->
  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>

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