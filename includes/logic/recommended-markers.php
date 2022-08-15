<?php
// Include config file
require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");


//get the user ID
$user_id = $_SESSION["id"];

if (isset($_COOKIE["weather"])) {
  //get the current weather from coockies.
  $weather = $_COOKIE["weather"];
} else {
  $weather = null;
}

//get the last visited POI id
$last_visited_poi_id = $user->get_last_visited_poi_id($user_id);

if ($last_visited_poi_id == 0) {
  //number of recommendations returned by MVP RS1
  $max_rec_MVP = 3;
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

$returned_MVP_reco = $returned_MFT_reco = $returned_MRT_reco = $returned_user_based_reco = $returned_item_based_reco = $returned_userB_time_reco = $returned_itemB_time_reco = $returned_userB_weather_reco = $returned_itemB_weather_reco = 0;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  //create an array that will hold the (POI_ID, RS_ID)
  $recommended_pois_list = array();

  $poiTbl = [];
  $poiTbl['pois'] = [];


  if ($last_visited_poi_id != 0) {
    // =========================== Most frequented transition RS2 =====================================
    $MFT =  $MFT_RS->recommend($last_visited_poi_id, $max_rec_MFT);
    if ($MFT != "") {
      //Count the number of recommendations returned by MRT
      $returned_MFT_reco = $MFT->rowCount();
      while ($row = $MFT->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by (MFT RS) to the list of recommended POI(s)).
          $recommended_pois_list[$id] = 2;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS (MFT) to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$id])) {
            $recommended_pois_list[$id] = array($recommended_pois_list[$id], 2);
          } else {
            array_push($recommended_pois_list[$id], 2);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }
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
          "RS" =>  $recommended_pois_list[$id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }

    // ============================= Most recent transition RS3 ==================================
    $MRT =  $MRT_RS->recommend($last_visited_poi_id, $max_rec_MRT);

    if ($MRT != "") {
      //Count the number of recommendations returned by MRT
      $returned_MRT_reco = $MRT->rowCount();
      while ($row = $MRT->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by (MFT RS) to the list of recommended POI(s)).
          $recommended_pois_list[$id] = 3;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS (MRT) to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$id])) {
            $recommended_pois_list[$id] = array($recommended_pois_list[$id], 3);
          } else {
            array_push($recommended_pois_list[$id], 3);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }
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
          "RS" =>  $recommended_pois_list[$id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }

    // ===================================== User based RS4 ==================================
    $user_based =  $user_based_RS->recommend($user_id, $fullDataset, $max_rec_user_based);

    if ($user_based != "") {
      //Count the number of recommendations returned by MRT
      $returned_user_based_reco = count($user_based);
      foreach ($user_based as $poi_id) {
        $row = $map->fetch_poi_details($poi_id);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($poi_id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by (user based RS) to the list of recommended POI(s)).
          $recommended_pois_list[$poi_id] = 4;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$poi_id])) {
            $recommended_pois_list[$poi_id] = array($recommended_pois_list[$poi_id], 4);
          } else {
            array_push($recommended_pois_list[$poi_id], 4);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }

        $poi = [
          "id" => $poi_id,
          "designation" => $row["designation"],
          "type" => $row["type"],
          "description" => $row["description"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "views" => $row["views"],
          "open_time" => $row["open_time"],
          "close_time" => $row["close_time"],
          "RS" =>  $recommended_pois_list[$poi_id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }

    // ===================================== Item based RS4 ==================================
    $item_based =  $item_based_RS->recommend($user_id, $fullDataset, $max_rec_item_based);

    if ($item_based != "") {
      //Count the number of recommendations returned by MRT
      $returned_item_based_reco = count($item_based);
      foreach ($item_based as $poi_id) {
        $row = $map->fetch_poi_details($poi_id);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($poi_id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by (item based RS) to the list of recommended POI(s)).
          $recommended_pois_list[$poi_id] = 5;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$poi_id])) {
            $recommended_pois_list[$poi_id] = array($recommended_pois_list[$poi_id], 5);
          } else {
            array_push($recommended_pois_list[$poi_id], 5);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }

        $poi = [
          "id" => $poi_id,
          "designation" => $row["designation"],
          "type" => $row["type"],
          "description" => $row["description"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "views" => $row["views"],
          "open_time" => $row["open_time"],
          "close_time" => $row["close_time"],
          "RS" =>  $recommended_pois_list[$poi_id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }


    // ===================================== User based filtered By time RS6 ==================================
    $userB_time =  $userB_time_RS->recommend($user_id, $max_rec_userB_time);

    if ($userB_time != "") {
      //Count the number of recommendations returned by MRT
      $returned_userB_time_reco = count($userB_time);
      foreach ($userB_time as $poi_id) {
        $row = $map->fetch_poi_details($poi_id);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($poi_id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by current RS to the list of recommended POI(s)).
          $recommended_pois_list[$poi_id] = 6;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$poi_id])) {
            $recommended_pois_list[$poi_id] = array($recommended_pois_list[$poi_id], 6);
          } else {
            array_push($recommended_pois_list[$poi_id], 6);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }

        $poi = [
          "id" => $poi_id,
          "designation" => $row["designation"],
          "type" => $row["type"],
          "description" => $row["description"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "views" => $row["views"],
          "open_time" => $row["open_time"],
          "close_time" => $row["close_time"],
          "RS" =>  $recommended_pois_list[$poi_id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }

    // ===================================== Item based filtered By time RS7 ==================================
    $itemB_time =  $itemB_time_RS->recommend($user_id, $max_rec_itemB_time);

    if ($itemB_time != "") {
      //Count the number of recommendations returned by current RS
      $returned_itemB_time_reco = count($itemB_time);
      foreach ($itemB_time as $poi_id) {
        $row = $map->fetch_poi_details($poi_id);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($poi_id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by current RS to the list of recommended POI(s)).
          $recommended_pois_list[$poi_id] = 7;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$poi_id])) {
            $recommended_pois_list[$poi_id] = array($recommended_pois_list[$poi_id], 7);
          } else {
            array_push($recommended_pois_list[$poi_id], 7);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }

        $poi = [
          "id" => $poi_id,
          "designation" => $row["designation"],
          "type" => $row["type"],
          "description" => $row["description"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "views" => $row["views"],
          "open_time" => $row["open_time"],
          "close_time" => $row["close_time"],
          "RS" =>  $recommended_pois_list[$poi_id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }

    // ===================================== User based filtered By weather RS8 ==================================
    $userB_weather =  $userB_weather_RS->recommend($user_id, $weather, $max_rec_userB_weather);

    if ($userB_weather  != "") {
      //Count the number of recommendations returned by MRT
      $returned_userB_weather_reco = count($userB_weather);
      foreach ($userB_weather as $poi_id) {
        $row = $map->fetch_poi_details($poi_id);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($poi_id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by current RS to the list of recommended POI(s)).
          $recommended_pois_list[$poi_id] = 8;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$poi_id])) {
            $recommended_pois_list[$poi_id] = array($recommended_pois_list[$poi_id], 8);
          } else {
            array_push($recommended_pois_list[$poi_id], 8);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }

        $poi = [
          "id" => $poi_id,
          "designation" => $row["designation"],
          "type" => $row["type"],
          "description" => $row["description"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "views" => $row["views"],
          "open_time" => $row["open_time"],
          "close_time" => $row["close_time"],
          "RS" =>  $recommended_pois_list[$poi_id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }

    //================================== Item based filtered By weather RS9 ====================================
    $itemB_weather =  $itemB_weather_RS->recommend($user_id, $weather, $max_rec_itemB_weather);

    if ($itemB_weather  != "") {
      //Count the number of recommendations returned by MRT
      $returned_itemB_weather_reco = count($itemB_weather);
      foreach ($itemB_weather as $poi_id) {
        $row = $map->fetch_poi_details($poi_id);
        // check if the poi is already recommended by the previous RS
        if (array_key_exists($poi_id, $recommended_pois_list) === false) {
          // if not, then add the recommended poi by current RS to the list of recommended POI(s)).
          $recommended_pois_list[$poi_id] = 9;
        } else {
          // if it's already recommended by the previous RS(s), then add the ID of the current RS to the ID of the previous RS(s)
          if (!is_array($recommended_pois_list[$poi_id])) {
            $recommended_pois_list[$poi_id] = array($recommended_pois_list[$poi_id], 9);
          } else {
            array_push($recommended_pois_list[$poi_id], 9);
            //sort RS IDs 
            sort($recommended_pois_list[$poi_id]);
          }
        }

        $poi = [
          "id" => $poi_id,
          "designation" => $row["designation"],
          "type" => $row["type"],
          "description" => $row["description"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "views" => $row["views"],
          "open_time" => $row["open_time"],
          "close_time" => $row["close_time"],
          "RS" =>  $recommended_pois_list[$poi_id]
        ];
        $poiTbl['pois'][] = $poi;
      }
    }
  }

  // ============================== Most viewed POI ====================================

  if (($returned_MFT_reco + $returned_MRT_reco + $returned_user_based_reco + $returned_item_based_reco + $returned_userB_time_reco + $returned_itemB_time_reco + $returned_userB_weather_reco + $returned_itemB_weather_reco) == 0) {
    $max_rec_MVP = 3;
  }
  $MVP = $MVP_RS->recommend($last_visited_poi_id, $max_rec_MVP);
  if ($MVP != "") {
    while ($row = $MVP->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      // check if the poi is already recommended by the previous RS
      if (array_key_exists($id, $recommended_pois_list) === false) {
        // if not, then add the recommended poi by (MVP RS) to the list of recommended POI(s)).
        $recommended_pois_list[$id] = 1;
      } else {
        // if it's already recommended by the previous RS(s), then add the ID of the current RS (MVP) to the ID of the previous RS(s)
        if (!is_array($recommended_pois_list[$id])) {
          $recommended_pois_list[$id] = array($recommended_pois_list[$id], 1);
        } else {
          array_push($recommended_pois_list[$id], 1);
          //sort RS IDs 
          sort($recommended_pois_list[$poi_id]);
        }
      }
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
        "RS" => $recommended_pois_list[$id]
      ];
      $poiTbl['pois'][] = $poi;
    }
  }


  http_response_code(200);

  echo json_encode($poiTbl);
} else {

  http_response_code(405);
  echo json_encode(["message" => "There was an error in recommended markers file!"]);
}
