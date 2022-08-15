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
$success = $err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_GET["poi_details_id"])) {
    $id = $_GET["poi_details_id"];
    if ($poi_details = $map->fetch_poi_details($id)) {
      $map->increase_views($id);
      $designation = $poi_details['designation'];
      $type = $poi_details['type'];
      $description = $poi_details['description'];
      $open_time = $poi_details['open_time'];
      $close_time = $poi_details['close_time'];
      $views = $poi_details['views'];
      $longitude = $poi_details['longitude'];
      $latitude = $poi_details['latitude'];
    }
  }
}
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST["feedback_submit"])) {

    $rate = $_POST["rate"];
    $comment = $_POST["comment"];
    $recommend = $_POST["recommendation"];
    $poi_id = $_POST["poi_id"];
    $user_id = $_SESSION["id"];
    $feedback_date = date("Y-m-d H:i:s");

    if ($user->evaluate($poi_id, $user_id, $rate, $comment, $recommend, $feedback_date)) {

      $success = "Thank you for your feedback.";
    } else {
      $err = "Oops! something went wrong, Please try again later..";
    }
  }
}
