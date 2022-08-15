<?php
redirectIfNeeded();

// Check if the user is already logged in, if no then redirect him to index page
if (!$user->is_loggedin()) {
  $user->redirect("/");
  exit;
}

if (isset($_GET["logout"])) {
  $user->logout();
}

// Define variables and initialize with empty values
$id = $designation = $type = $description = $open_time = $close_time = $views = $longitude = $latitude = "";
$success = $err =  $visit_success = "";

$returned_MVP_reco = $returned_MFT_reco = $returned_MRT_reco = $returned_user_based_reco =  $returned_item_based_reco = $returned_userB_time_reco = $returned_itemB_time_reco = $returned_userB_weather_reco = $returned_itemB_weather_reco = 0;

//get the User ID
$user_id = $_SESSION["id"];

if (isset($_COOKIE["weather"])) {
  //get the current weather from coockies.
  $weather = $_COOKIE["weather"];
} else {
  $weather = null;
}

if ($user->get_last_visited_poi_id($user_id) == 0) {
  //number of recommendations returned by MVP RS1
  $nb_rec_MVP = 3;
} else {
  //Get the full dataset
  $fullDataset = $datasetClass->get_FullDataset();

  //number of recommendations returned by MVP RS1
  $max_rec_MVP = 0;
  //number of recommendations returned by MFT RS2
  $max_rec_MFT = 1;
  //number of recommendations returned by MRT RS3
  $max_rec_MRT = 1;
  //number of recommendations returned by User based RS4
  $max_rec_user_based = 1;
  //number of recommendations returned by Item based RS5
  $max_rec_item_based = 1;
  //number of recommendations returned by User based filtered By time RS6
  $max_rec_userB_time = 1;
  //number of recommendations returned by Item based filtered By time RS7
  $max_rec_itemB_time = 1;
  //number of recommendations returned by User based filtered By weather RS8
  $max_rec_userB_weather = 1;
  //number of recommendations returned by Item based filtered By weather RS9
  $max_rec_itemB_weather = 1;
}

// Get the current Page number
if (isset($_GET['pageNo'])) {
  $pageNo = $_GET['pageNo'];
} else {
  $pageNo = 1;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_GET["poi_details_id"])) {
    $id = $_GET["poi_details_id"];
    if ($poi_details = $map->fetch_poi_details($id)) {
      if (!isset($_GET["visited"])) {
        $map->increase_views($id);
      }
      $designation = $poi_details['designation'];
      $type = $poi_details['type'];
      $description = $poi_details['description'];
      $open_time = $poi_details['open_time'];
      $close_time = $poi_details['close_time'];
      $views = $poi_details['views'];
      $longitude = $poi_details['longitude'];
      $latitude = $poi_details['latitude'];
    }
    //passing longitude and latitude of the showed POI to our Weather API
    echo '<script> var poi_lat = ' . $latitude . ';
       var poi_long = ' . $longitude . ';
</script>';
    echo '<script type="text/javascript" src="assets/js/poi_weather.js"></script>';
  }
}
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST["feedback_submit"])) {

    $rate = $_POST["rate"];
    $comment = $_POST["comment"];
    $poi_id = $_POST["poi_id"];
    $feedback_date = date("Y-m-d H:i:s");

    // current position of the user
    $feedback_long = $_POST["feedback_long"];
    $feedback_lat = $_POST["feedback_lat"];

    //Current weather of POI
    $poi_weather = $_POST["poi_weather"];
    $poi_temp = $_POST["poi_temp"];

    if ($user->evaluate($poi_id, $user_id, $rate, $comment, $feedback_date, $poi_weather, $poi_temp, $feedback_long, $feedback_lat)) {

      $success = "Thank you for your feedback.";
    } else {
      $err = "We are sorry! we can't save your feedback.";
    }
  }

  if (isset($_POST["visit_submit"])) {

    //Get the visited POI ID.
    $visited_poi_id = $_POST["visited_poi_id"];

    //Get the current date of the visit.
    $visit_date = date("Y-m-d H:i:s");

    //Get the last visited POI by the user.
    $last_visited_poi_id = $user->get_last_visited_poi_id($user_id);

    //get the number of recommendations 
    $nb_rec = $_POST["nb_rec"];

    if ($_POST["RS1"] || $_POST["RS2"] || $_POST["RS3"] || $_POST["RS4"] || $_POST["RS5"] || $_POST["RS6"] || $_POST["RS7"] || $_POST["RS8"] || $_POST["RS9"]) {
      $is_recommended = 1;
      //if POI is recommended by MVP RS1, then 1pt+
      if ($_POST["RS1"]) {
        //1pt+
        $MVP_RS->rep();
      }

      //if POI is recommended by MFT RS2, then 1pt+
      if ($_POST["RS2"]) {
        //1pt+
        $MFT_RS->rep();
      }

      //if POI is recommended by MRT RS3, then 1pt+
      if ($_POST["RS3"]) {
        //1pt+
        $MRT_RS->rep();
      }

      //if POI is recommended by User based RS4, then 1pt+
      if ($_POST["RS4"]) {
        //1pt+
        $user_based_RS->rep();
      }

      //if POI is recommended by Item based RS5, then 1pt+
      if ($_POST["RS5"]) {
        //1pt+
        $item_based_RS->rep();
      }

      //if POI is recommended by User based filtered by time RS6, then 1pt+
      if ($_POST["RS6"]) {
        //1pt+
        $userB_time_RS->rep();
      }


      //if POI is recommended by Item based filtered by time RS7, then 1pt+
      if ($_POST["RS7"]) {
        //1pt+
        $itemB_time_RS->rep();
      }


      //if POI is recommended by User based filtered by weather RS8, then 1pt+
      if ($_POST["RS8"]) {
        //1pt+
        $userB_weather_RS->rep();
      }


      //if POI is recommended by Item based filtered by weather RS9, then 1pt+
      if ($_POST["RS9"]) {
        //1pt+
        $itemB_weather_RS->rep();
      }
    } else {
      $is_recommended = 0;
    }

    //save the visited POI.


    if ($user->visit($user_id, $nb_rec, $visited_poi_id, $is_recommended, $visit_date)) {

      //Check if the user have already visited at least one POI.
      if ($last_visited_poi_id !== 0 && $last_visited_poi_id != $visited_poi_id) {
        //Save the course if its new, or increment its frequency.
        if ($user->addTransition($last_visited_poi_id, $visited_poi_id, $visit_date) === false) {
          $err = "Can't add transition!";
        }
      }
      $user->redirect("History?visited=" . $visited_poi_id);
    }
  }
}
