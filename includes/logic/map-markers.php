<?php
// Include config file
require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");

// Define variables and initialize with empty values
$id = $name = $adress = $lat = $lon = $type = "";
$id_err = $name_err = $adress_err = $lat_err = $lon_err = $type_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $stmt = $map->fetch_pois();
  $poiTbl = [];
  $poiTbl['pois'] = [];

  // On parcourt les agences
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $poi = [
      "id" => $id,
      "designation" => $designation,
      "type" => $type,
      "description" => $description,
      "latitude" => $latitude,
      "longitude" => $longitude,
      "views" => $views,
      "open_time" => $open_time,
      "close_time" => $close_time,
    ];
    $poiTbl['pois'][] = $poi;
  }


  http_response_code(200);

  echo json_encode($poiTbl);
} else {

  http_response_code(405);
  echo json_encode(["message" => "There was an error !"]);
}
