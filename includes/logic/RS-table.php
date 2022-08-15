     <?php

      //Get the last visited poi id
      $last_visited_poi_id = $user->get_last_visited_poi_id($_SESSION["id"]);



      //create an array that will hold the (POI_ID, RS_ID)
      $recommended_pois_list = array();


      // if it's not the first visit of the user, then:
      if ($last_visited_poi_id != 0) {
        // ========================== Most frequented transition RS2 ==========================
        $MFT =  $MFT_RS->recommend($last_visited_poi_id, $max_rec_MFT);

        if ($MFT != "") {
          //Count the number of recommendations returned by MFT
          $returned_MFT_reco = $MFT->rowCount();

          foreach ($MFT as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi['id'], $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (MFT RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi["id"]] = 2;
            } else {
              // if it's already recommended by the previous RS, then add the ID of the current RS (MFT) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi["id"]])) {
                $recommended_pois_list[$poi["id"]] = array($recommended_pois_list[$poi["id"]], 2);
              } else {
                array_push($recommended_pois_list[$poi["id"]], 2);
              }
            }
          }
        }

        if (isset($_POST["visit_submit"])) {
          //increase number of requests by MFT RS
          $MFT_RS->increase_nb_request();
          //increase the total number of recommendations by MFT
          $MFT_RS->increase_total_recommendations($returned_MFT_reco);
        }
        // ========================== Most recent transition RS3 ========================== 
        $MRT = $MRT_RS->recommend($last_visited_poi_id, $max_rec_MRT);

        if ($MRT != "") {
          //Count the number of recommendations returned by MRT
          $returned_MRT_reco = $MRT->rowCount();

          foreach ($MRT as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi['id'], $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (MFT RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi["id"]] = 3;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (MRT) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi["id"]])) {
                $recommended_pois_list[$poi["id"]] = array($recommended_pois_list[$poi["id"]], 3);
              } else {
                array_push($recommended_pois_list[$poi["id"]], 3);
              }
            }
          }
        }

        if (isset($_POST["visit_submit"])) {
          //increase number of requests by MRT RS
          $MRT_RS->increase_nb_request();
          //increase the total number of recommendations by MRT
          $MRT_RS->increase_total_recommendations($returned_MRT_reco);
        }
        // ========================== User based RS4 ========================== 
        $user_based = $user_based_RS->recommend($user_id, $fullDataset, $max_rec_user_based);

        if (is_array($user_based)) {
          //Count the number of recommendations returned by MRT
          $returned_user_based_reco = count($user_based);


          if (isset($_POST["visit_submit"])) {
            //increase number of requests by User based RS
            $user_based_RS->increase_nb_request();
            //increase the total number of recommendations by User based RS
            $user_based_RS->increase_total_recommendations($returned_user_based_reco);
          }

          foreach ($user_based as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi, $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (User based RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi] = 4;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (User based) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi])) {
                $recommended_pois_list[$poi] = array($recommended_pois_list[$poi], 4);
              } else {
                array_push($recommended_pois_list[$poi], 4);
              }
            }
          }
        }

        // ========================== Item based RS5 ========================== 
        $item_based = $item_based_RS->recommend($user_id, $fullDataset, $max_rec_item_based);

        if (is_array($item_based)) {
          //Count the number of recommendations returned by MRT
          $returned_item_based_reco = count($item_based);


          if (isset($_POST["visit_submit"])) {
            //increase number of requests by User based RS
            $item_based_RS->increase_nb_request();
            //increase the total number of recommendations by User based RS
            $item_based_RS->increase_total_recommendations($returned_item_based_reco);
          }

          foreach ($item_based as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi, $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (Item based RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi] = 5;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (Item based) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi])) {
                $recommended_pois_list[$poi] = array($recommended_pois_list[$poi], 5);
              } else {
                array_push($recommended_pois_list[$poi], 5);
              }
            }
          }
        }

        // ========================== User based filtered by time RS6 ========================== 
        $userB_time = $userB_time_RS->recommend($user_id, $max_rec_userB_time);

        if (is_array($userB_time)) {
          //Count the number of recommendations returned by MRT
          $returned_userB_time_reco = count($userB_time);


          if (isset($_POST["visit_submit"])) {
            //increase number of requests by User based RS
            $userB_time_RS->increase_nb_request();
            //increase the total number of recommendations by User based RS
            $userB_time_RS->increase_total_recommendations($returned_userB_time_reco);
          }

          foreach ($userB_time as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi, $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (User based RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi] = 6;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (User based) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi])) {
                $recommended_pois_list[$poi] = array($recommended_pois_list[$poi], 6);
              } else {
                array_push($recommended_pois_list[$poi], 6);
              }
            }
          }
        }

        // ========================== Item based filtered by time RS7 ========================== 
        $itemB_time = $itemB_time_RS->recommend($user_id, $max_rec_itemB_time);

        if (is_array($itemB_time)) {
          //Count the number of recommendations returned by MRT
          $returned_itemB_time_reco = count($itemB_time);


          if (isset($_POST["visit_submit"])) {
            //increase number of requests by User based RS
            $itemB_time_RS->increase_nb_request();
            //increase the total number of recommendations by User based RS
            $itemB_time_RS->increase_total_recommendations($returned_itemB_time_reco);
          }

          foreach ($itemB_time as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi, $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (User based RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi] = 7;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (User based) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi])) {
                $recommended_pois_list[$poi] = array($recommended_pois_list[$poi], 7);
              } else {
                array_push($recommended_pois_list[$poi], 7);
              }
            }
          }
        }

        // ========================== User based filtered by weather RS8 ========================== 
        $userB_weather = $userB_weather_RS->recommend($user_id, $weather, $max_rec_userB_weather);

        if (is_array($userB_weather)) {
          //Count the number of recommendations returned by MRT
          $returned_userB_weather_reco = count($userB_weather);


          if (isset($_POST["visit_submit"])) {
            //increase number of requests by User based RS
            $userB_weather_RS->increase_nb_request();
            //increase the total number of recommendations by User based RS
            $userB_weather_RS->increase_total_recommendations($returned_userB_weather_reco);
          }

          foreach ($userB_weather as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi, $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (User based RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi] = 8;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (User based) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi])) {
                $recommended_pois_list[$poi] = array($recommended_pois_list[$poi], 8);
              } else {
                array_push($recommended_pois_list[$poi], 8);
              }
            }
          }
        }

        // ========================== Item based filtered by weather RS9 ========================== 
        $itemB_weather = $itemB_weather_RS->recommend($user_id, $weather, $max_rec_itemB_weather);

        if (is_array($itemB_weather)) {
          //Count the number of recommendations returned by MRT
          $returned_itemB_weather_reco = count($itemB_weather);


          if (isset($_POST["visit_submit"])) {
            //increase number of requests by User based RS
            $itemB_weather_RS->increase_nb_request();
            //increase the total number of recommendations by User based RS
            $itemB_weather_RS->increase_total_recommendations($returned_itemB_weather_reco);
          }

          foreach ($itemB_weather as $poi) {

            // check if the poi is already recommended by the previous RS
            if (array_key_exists($poi, $recommended_pois_list) === false) {
              // if not, then add the recommended poi by (User based RS) to the list of recommended POI(s)).
              $recommended_pois_list[$poi] = 9;
            } else {
              // if it's already recommended by the previous RS(s), then add the ID of the current RS (User based) to the ID of the previous RS(s)
              if (!is_array($recommended_pois_list[$poi])) {
                $recommended_pois_list[$poi] = array($recommended_pois_list[$poi], 9);
              } else {
                array_push($recommended_pois_list[$poi], 9);
              }
            }
          }
        }
      }
      // ========================== Most viewed POIS ==========================
      if (($returned_MFT_reco + $returned_MRT_reco + $returned_user_based_reco + $returned_item_based_reco) == 0) {
        $max_rec_MVP = 3;
      }
      $MVP = $MVP_RS->recommend($last_visited_poi_id, $max_rec_MVP);

      if ($MVP != "") {
        //Count the number of recommendations returned by MVP
        $returned_MVP_reco = $MVP->rowCount();
        foreach ($MVP as $poi) {
          // check if the poi is already recommended by the previous RS
          if (array_key_exists($poi['id'], $recommended_pois_list) === false) {
            // if not, then add the recommended poi by (MVP RS) to the list of recommended POI(s)).
            $recommended_pois_list[$poi["id"]] = 1;
          } else {
            // if it's already recommended by the previous RS, then add the ID of the current RS (MVP) to the ID of the previous RS(s)
            if (!is_array($recommended_pois_list[$poi["id"]])) {
              $recommended_pois_list[$poi["id"]] = array($recommended_pois_list[$poi["id"]], 1);
            } else {
              array_push($recommended_pois_list[$poi["id"]], 1);
            }
          }
        }
      }

      if (isset($_POST["visit_submit"])) {
        //increase number of requests by MVP RS
        $MVP_RS->increase_nb_request();
        //increase the total number of recommendations by MVP
        $MVP_RS->increase_total_recommendations($returned_MVP_reco);
      }
      // ========================== OUTPUT RECOMMENDATIONS ===========================

      // randomize the output of recommendations
      $random_rec_list = array_keys($recommended_pois_list);
      shuffle($random_rec_list);
      //sort RS IDs 
      foreach ($recommended_pois_list as $poi_id => $RS_id) {
        if (is_array($recommended_pois_list[$poi_id])) {
          sort($recommended_pois_list[$poi_id]);
        }
      }

      // output the recommendations of all RSs
      foreach ($random_rec_list as $poi_id) {

        $poi = $map->fetch_poi_details($poi_id);
        echo "<tr class='bg-orange'>";
        echo "<td class='font-weight-bold'>" . $poi["designation"] . "</td>";
        echo "<td >" . $poi["type"] . "</td>";
        echo "<td>" . $poi["views"] . "</td>";
        echo '<td><a class="btn btn-green " href="?';
        //keep the same 'GET' parameter
        if (isset($_GET["show_all_places"])) {
          echo 'show_all_places';
        }
        echo '&poi_details_id=' . $poi['id'];
        if (isset($_GET["pageNo"])) {
          echo '&pageNo=' . $_GET["pageNo"];
        }

        //Save the RS(s) ID as GET parameter
        if (!is_array($recommended_pois_list[$poi_id])) {
          echo '&RS' . $recommended_pois_list[$poi_id];
        } else {
          foreach ($recommended_pois_list[$poi_id] as $RS_id) {
            echo "&RS" . $RS_id;
          }
        }

        echo '#poi_details" style="border-radius: 50%;" >...</a></td>';
        echo "</tr>";
      }


      // ======== if show all places is clicked, then output the rest of the POI ========


      if (isset($_GET["show_all_places"])) {
        //create array to save and randomize the output of the rest of POI(s).
        $randomize_POIs = array();
        // get the rest of POI(s)
        $all_POIS = $map->fetch_pois();
        foreach ($all_POIS as $poi) {
          if (array_key_exists($poi['id'], $recommended_pois_list) === false) {
            array_push($randomize_POIs, $poi['id']);
          }
        }
        $nRow_pPage = 10 - count($recommended_pois_list);
        $total_pages = ceil(($map->fetch_pois()->rowCount() - count($recommended_pois_list))  / $nRow_pPage);

        if (!isset($_GET["pageNo"]) && !isset($_GET["poi_details_id"])) {
          shuffle($randomize_POIs);
          $_SESSION["restOf_POIs"] = $randomize_POIs;
          $restOf_POIs = array_slice($_SESSION["restOf_POIs"], 0, $nRow_pPage);
        } else {
          $restOf_POIs = array_slice($_SESSION["restOf_POIs"], $nRow_pPage * ($pageNo - 1), $nRow_pPage);
        }
        foreach ($restOf_POIs as $poi_id) {

          $poi = $map->fetch_poi_details($poi_id);

          echo "<tr>";
          echo "<td >" . $poi["designation"] . "</td>";
          echo "<td >" . $poi["type"] . "</td>";
          echo "<td>" . $poi["views"] . "</td>";
          echo '<td><a class="btn btn-green " href="?show_all_places&poi_details_id=' . $poi['id'];
          if (isset($_GET["pageNo"])) {
            echo '&pageNo=' . $_GET["pageNo"];
          }
          echo '#poi_details" style="border-radius: 50%;" >...</a></td>';
          echo "</tr>";
        }
      }
      ?>
  