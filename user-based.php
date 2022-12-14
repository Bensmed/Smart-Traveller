<?php

// Include config file
require_once "config.php";

// $dataset = $datasetClass->get_dataset_example();

// $dataset = $datasetClass->get_FullDataset();

$dataset = $datasetClass->get_Dataset_filteredBy_time();

// $dataset = $datasetClass->get_Dataset_filteredBy_weather($_COOKIE["weather"]);

//Get all users ID
$users_id = $user_based_RS->get_all_users_id($dataset);

//Get all POIs ID 
$POIs_id = $user_based_RS->get_all_POIs_id($dataset);

$current_user = 1;

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>User based example</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>
<h6><b>Resource : Maimoun Elaaeieida Thesis</b></h6>
<section class="container">
  <h1 class="text-center text-danger"> <b> DATASET</b></h1>
  <table class="table table-hover table-striped table-bordered" style="font-size:26px;">
    <thead class=" table-danger">
      <tr>
        <th></th>
        <?php
        foreach ($POIs_id as $POI_id) {
          echo "<th> Item " . $POI_id . "</th>";
        }
        ?>
      </tr>
    </thead>
    <tbody class=" table-primary">


      <?php

      foreach ($users_id as $user_id) {
        echo "<tr>";
        echo "<th> User " . $user_id . "</th>";
        foreach ($POIs_id as $POI_id) {
          echo "<td>";
          if ($user_based_RS->ratingOf($user_id, $POI_id, $dataset) == "") {
            echo '<b class="text-danger" ">?</b>';
          } else {
            echo $user_based_RS->ratingOf($user_id, $POI_id, $dataset);
          }
          echo "</td>";
        }
        echo " </tr>";
      }
      ?>

    </tbody>
  </table>


</section>
<section class="container-fluid">
  <h1 class="text-center text-danger"> <b> User based simlarity</b></h1>
  <table class="table table-hover table-striped table-bordered" style="font-size:26px;">
    <thead class=" table-danger">
      <tr>
        <th></th>
        <?php
        foreach ($users_id as $user_id) {
          echo "<th> User " . $user_id . "</th>";
        }
        ?>
      </tr>
    </thead>
    <tbody class=" table-primary">


      <?php

      foreach ($users_id as $user_id) {
        echo "<tr>";
        echo "<th> User " . $user_id . "</th>";
        foreach ($users_id as $another_user) {
          echo "<td>";
          $sim = $user_based_RS->sim($user_id, $another_user, $dataset);
          if ($sim == NAN) {

            echo '<b class="text-danger" ">NAN</b>';
          } else {
            echo round($sim, 2);
          }
          echo "</td>";
        }
        echo " </tr>";
      }
      ?>

    </tbody>
  </table>
</section>


<section class="container-fluid">
  <h1 class="text-center text-danger"> <b> Predictions (user-based similarity)</b></h1>
  <table class="table table-hover table-striped table-bordered" style="font-size:26px;">
    <thead class=" table-danger">
      <tr>
        <th></th>
        <?php
        foreach ($POIs_id as $POI_id) {
          echo "<th> Item " . $POI_id . "</th>";
        }
        ?>
      </tr>
    </thead>
    <tbody class=" table-primary">


      <?php

      foreach ($users_id as $user_id) {
        echo "<tr>";
        echo "<th> User " . $user_id . "</th>";
        foreach ($POIs_id as $POI_id) {
          echo "<td>";
          $rate = $user_based_RS->ratingOf($user_id, $POI_id, $dataset);
          if ($rate == "") {

            echo '<b class="text-danger" ">' . round($user_based_RS->predict($user_id, $dataset)[$POI_id], 2) . '</b>';
          } else {
            echo $rate;
          }
          echo "</td>";
        }
        echo " </tr>";
      }
      ?>

    </tbody>
  </table>
</section>



<section class="container">
  <h1 class="text-center text-danger"> <b> Recommendations</b></h1>
  <br>
  <h3 class="ml-3">??? The system will recommend the items that have predictions above the average of the user.</h3>
  <br>
  <h4 class="ml-5"> For example, for <b>User<?php echo $current_user ?></b> we have:</h4>
  <br>
  <h4 class="ml-5"><b> User<?php echo $current_user ?></b> Average :<b class="text-danger"> <?php echo $user_based_RS->user_ratings_average($current_user, $dataset); ?></b>
  </h4>
  <br>
  <h4 class="ml-5">??? Neighborhood of <b>User<?php echo $current_user ?></b>, which have a similarity <b>greater than or equal to 0 </b>with User<?php echo $current_user ?> : </h4>
  <br>
  <?php
  $neighborhood = $user_based_RS->Neighborhood_Of(0, $current_user, $dataset);

  foreach ($neighborhood as $neighbor => $sim) {
    echo '<h2 class="text-danger text-center"><b>??? User ' . $neighbor . '</b></h2>';
    echo "<br>";
  }
  ?>
  <h4 class="ml-5">??? <b>User <?php echo $current_user ?></b> will get the following recommendations:</h4>
  <br>
  <?php
  $recommendations = $user_based_RS->recommend($current_user, $dataset, 5);
  if (is_array($recommendations)) {
    foreach ($recommendations as $item) {
      echo '<h2 class="text-danger text-center"><b>??? Item ' . $item . '</b></h2>';
      echo "<br>";
    }
  } else {
    echo '<h2 class="text-danger text-center"><b>None.</b></h2>';
  }


  ?>
</section>