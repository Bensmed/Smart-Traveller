<?php
session_start();

$server = "localhost";
$dbname = "id16844388_smarttraveller_db";
$username = "id16844388_smarttravellerdb";
$password = "0tOWCwME#EnU%/PP";
$dsn = "mysql:host={$server};dbname={$dbname}";

try {
  //Make the connection
  $pdo = new PDO($dsn, $username, $password);

  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

  echo "Could not connect : " . $e->getMessage();
}
//set the timezone
date_default_timezone_set("Africa/Algiers");

define('ROOT_PATH', realpath(dirname(__FILE__))); // path to the root folder
define('INCLUDE_PATH', realpath(dirname(__FILE__) . '/includes')); // Path to includes folder
define('BASE_URL', 'http://localhost/user-accounts/'); // the home url of the website

include_once("classes/users/class.user.php");
$user = new USER($pdo);

include_once("classes/roles/class.role.php");
$role = new role($pdo);

include_once("classes/users/class.map.php");
$map = new map($pdo);

include_once("classes/RS/class.MVP.RS.php");
$MVP_RS = new MVP_RS($pdo);

include_once("classes/RS/class.MFT.RS.php");
$MFT_RS = new MFT_RS($pdo);

include_once("classes/RS/class.MRT.RS.php");
$MRT_RS = new MRT_RS($pdo);

include_once("classes/dataset/class.dataset.php");
$datasetClass = new dataset($pdo);

include_once("classes/RS/class.user_based.RS.php");
$user_based_RS = new user_based($pdo);

include_once("classes/RS/class.item_based.RS.php");
$item_based_RS = new item_based($pdo);

include_once("classes/RS/class.userB_time.RS.php");
$userB_time_RS = new user_based_filteredBy_time($pdo);

include_once("classes/RS/class.itemB_time.RS.php");
$itemB_time_RS = new item_based_filteredBy_time($pdo);

include_once("classes/RS/class.userB_weather.RS.php");
$userB_weather_RS = new user_based_filteredBy_weather($pdo);

include_once("classes/RS/class.itemB_weather.RS.php");
$itemB_weather_RS = new item_based_filteredBy_weather($pdo);


function redirectIfNeeded()
{
  $url = $_SERVER["REQUEST_URI"];
  if (preg_match("/\.php/i", $url))
    header("Location: " . preg_replace("/\.php/", "", $url));
}
