<?php

class user_based
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //******************************* Get all users id from dataset **************************************

  public function get_all_users_id($dataset): array //return an array object
  {
    //Create empty array that save the users ID in ARRAY FORMAT.
    $users_id_list = array();
    try {
      if (is_array($dataset)) {
        //Get the users ID that atleast gave one rate to a POI.
        $users_id_list = array_keys($dataset);

        //Sort users ID in ascending order.
        sort($users_id_list);
      }
      //Return users ID array.
      return $users_id_list;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* get all POIs id **************************************

  public function get_all_pois_id($dataset): array //return an array object
  {

    //Create empty array that save the POIs ID in ARRAY FORMAT.
    $POIs_id_list = array();

    try {
      if (is_array($dataset)) {
        //Get the users ID that atleast gave one rate to a POI.
        $users_id = array_keys($dataset);
        if (is_array($users_id)) {

          foreach ($users_id as $user_id) {
            //Get the POIs ID that atleast have been rated by at least one user.
            $pois_id = array_keys($dataset[$user_id]);
            foreach ($pois_id as $poi_id) {
              //Eliminate redundancies.
              if (array_search($poi_id, $POIs_id_list) === false) {
                array_push($POIs_id_list, $poi_id);
              }
            }
          }
        }

        //Sort POIs ID in ascending order.
        sort($POIs_id_list);
      }
      //Return POIs ID array.
      return $POIs_id_list;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }



  //******************************* rating of user on poi **************************************

  public function ratingOf($user_id, $poi_id, $dataset)
  {
    try {
      //check if the user have rate the poi.
      if (isset($dataset[$user_id][$poi_id])) {
        //save the rating.
        $rate = $dataset[$user_id][$poi_id];
        //return the rating value.
        return $rate;
      } else {
        //if the user did not rate the POI then, return empty string.
        return "";
      }
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* Get User ratings **************************************

  public function get_user_ratings($user_id, $dataset): array //return an array object
  {
    //Create empty array that save the user ratings in ARRAY FORMAT.
    $user_ratings_list = array();

    try {
      //if the current user at least rated one POI, then:
      if (isset($dataset[$user_id])) {
        //save the array as $POI_id(Key) => $rate(Value)
        $user_ratings_list =  $dataset[$user_id];
      }

      //return the User ratings array.
      return $user_ratings_list;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //************ common POIs ratings average calculation for user similarity calculus ****************

  public function common_POIs_ratings_average($user1_id, $user2_id, $dataset)
  {
    //save both users ratings into arrays.
    $user1_ratings_list =  $this->get_user_ratings($user1_id, $dataset);
    $user2_ratings_list =  $this->get_user_ratings($user2_id, $dataset);

    //Get all POIs id from the dataset.
    $POIs_id = $this->get_all_POIs_id($dataset);

    //initialize total both ratings with 0.
    $total_user1_ratings = 0;
    $total_user2_ratings = 0;

    //initialize the number of similar POIs with 0, to calculate the average of both users.
    $similar_POIs = 0;

    //Create empty array that hold the average values of both users in ARRAY FORMAT.
    $averages = array();


    try {

      // for all POIs, that atleast have been rated by one user. DO:
      foreach ($POIs_id as $poi_id) {

        //Check if the user1 has rated the current POI, if yes then :
        if (array_key_exists($poi_id, $user1_ratings_list)) {

          //Check if the user2 has rated the current POI, if yes then :
          if (array_key_exists($poi_id, $user2_ratings_list)) {
            //both users have rated the same POI, then:

            //calculate the sum of each user ratings
            $total_user1_ratings += $user1_ratings_list[$poi_id];
            $total_user2_ratings += $user2_ratings_list[$poi_id];

            //increment the number of similar POIs.
            $similar_POIs++;
          }
        }
      }
      //The Denominator must not equal to 0.
      if ($similar_POIs == 0) {

        //return NAN, because its impossible to divide over it.    
        return NAN;
      } else {

        //Calculate the average for each user by dividing over the number of similar POIs.
        $average_user1 = $total_user1_ratings / $similar_POIs;
        $average_user2 = $total_user2_ratings / $similar_POIs;
      }

      //Save both users average.
      array_push($averages, $average_user1, $average_user2);

      //return the averages array.
      return $averages;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //*************** user ratings average calculation for predictions calculus *********************

  public function user_ratings_average($user_id, $dataset)
  {
    //save user ratings into an array.
    $user_ratings_list =  $this->get_user_ratings($user_id, $dataset);

    //Get all POIs id from the dataset.
    $POIs_id = $this->get_all_POIs_id($dataset);

    //initialize total ratings with 0.
    $total_user1_ratings = 0;

    try {
      // for all POIs, that atleast have been rated by one user. DO:
      foreach ($POIs_id as $poi_id) {

        //Check if the user has rated the current POI, if yes then :
        if (array_key_exists($poi_id, $user_ratings_list)) {

          //calculate the sum of user ratings
          $total_user1_ratings += $user_ratings_list[$poi_id];
        }
      }

      //The Denominator must not equal 0.
      if (count($user_ratings_list) != 0) {

        //Calculate the average by dividing over the number of rated POIs.
        $average = $total_user1_ratings / count($user_ratings_list);
      } else {

        //return NAN, because its impossible to divide over it.
        return NAN;
      }
      //return the average value.
      return $average;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* user similarity calculation **************************************

  public function sim($user1, $user2, $dataset)
  {
    //save both users ratings in two arrays.
    $user1_ratings_list =  $this->get_user_ratings($user1, $dataset);
    $user2_ratings_list =  $this->get_user_ratings($user2, $dataset);

    //Get all POIs id from the dataset.
    $POIs_id = $this->get_all_POIs_id($dataset);

    $N = 0; //Nominator

    $D_user1 = 0; //Denominator user1
    $D_user2 = 0; //Denominator user2

    //Averages of both users with the common POIs only.
    $averages = $this->common_POIs_ratings_average($user1, $user2, $dataset);



    try {
      //Check if both users have at least one POI in common, if yes then:
      if (is_array($averages)) {
        //save the ratings average of each user.
        $user1_average = $averages[0];
        $user2_average = $averages[1];
      } else if (is_nan($averages)) {

        //return NAN, because there is no common ratings between both of them.
        return NAN;
      }

      // for all POIs, that atleast have been rated by one user. DO:
      foreach ($POIs_id as $poi_id) {

        //Check if the user1 has rated the current POI, if yes then :
        if (array_key_exists($poi_id, $user1_ratings_list)) {

          //Check if the user2 has rated the current POI, if yes then :
          if (array_key_exists($poi_id, $user2_ratings_list)) {
            //both users have rated the same POI, then:

            //Apply the pearson's correlation 
            //Calculate the nominator
            $N += (($user1_ratings_list[$poi_id] - $user1_average) * ($user2_ratings_list[$poi_id] - $user2_average));

            //Calculate the denominator of each user
            $D_user1 += pow(($user1_ratings_list[$poi_id] - $user1_average), 2);
            $D_user2 += pow(($user2_ratings_list[$poi_id] - $user2_average), 2);
          }
        }
      }

      //Calculate the full denominator 
      $D = (sqrt($D_user1) * sqrt($D_user2));
      //if the denominator equal 0, then
      if ($D == 0) {

        //return NAN, because its impossible to divide over it.
        return NAN;
      } else {

        //return the similarity between both users.
        return ($N / $D);
      }
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* Get the Neighborhood of a user  *************************************
  public function Neighborhood_Of($min_sim, $user_id, $dataset)
  {
    //Create empty array that hold the IDs of the most similar users in ARRAY FORMAT.
    $Neighborhood = array();

    //Get all users ID from the dataset.
    $users_id = $this->get_all_users_id($dataset);

    try {
      //for each users, that at least rated one POI, do:
      foreach ($users_id as $another_user) {
        //skip the current user.
        if ($another_user != $user_id) {

          //Calculate the similarity between both users.
          $sim = $this->sim($user_id, $another_user, $dataset);

          //check if the similarity is not equal to NAN:
          if (!is_nan($sim)) {
            //save the users ID that have similarity above the (minimum similarity parameter):$min_sim.
            if ($sim >= $min_sim) {

              //Save the similarity with each user as:  user_id(Key) => similarity(Value).
              $Neighborhood[$another_user] =  $sim;
            }
          }
        }
      }

      //return the neighborhood array.
      return $Neighborhood;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }
  //******************************* prediction calculation *************************************
  public function predict($user_id, $dataset)
  {
    //save both users rating in two arrays.
    $user_ratings_list =  $this->get_user_ratings($user_id, $dataset);

    //Get all POIs id from the dataset.
    $POIs_id = $this->get_all_POIs_id($dataset);

    //Get the neighborhood of the current user.
    $Neighborhood = $this->Neighborhood_Of(0, $user_id, $dataset);

    //Create empty array that hold the predictions list of the user (not-rated) POIs ratings in ARRAY FORMAT.
    $predictions_list = array();

    try {
      // for all POIs, that atleast have been rated by one user. DO:
      foreach ($POIs_id as $poi_id) {

        //Check if the POi is not rated yet by the user, if yes then:
        if (!array_key_exists($poi_id, $user_ratings_list)) {

          //initialize the nominator and the denominator with 0 value.
          $N = 0;
          $D = 0;

          //for each neighbor do:
          foreach ($Neighborhood as $neighbor => $sim) {

            //convert neighbor ratings into Array format. 
            $neighbor_ratings_list = $dataset[$neighbor];

            //if the neighbor rated the same POI as the current user, then
            if (array_key_exists($poi_id, $neighbor_ratings_list)) {

              //check if the similarity is not equal to NAN:
              if (!is_nan($sim)) {

                //Apply prediction calculus 

                // calculate the nominator
                $N += $sim * $neighbor_ratings_list[$poi_id];
                // calculate the denominator
                $D += abs($sim);
              }
            }
          }

          //if the denominator equal 0, then
          if ($D == 0) {
            //save prediction of POI as NAN, because its impossible to divide over it.
            $predictions_list[$poi_id] = NAN;
          } else {
            //Save prediction of POI as:  POI_id(Key) => prediction(Value).
            $predictions_list[$poi_id] = $N / $D;
          }
        }
      }
      // sort prediction values in descending order.
      arsort($predictions_list);

      //return the predictions array.
      return $predictions_list;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }
  //******************************* user based_RS recommendation **************************************

  public function recommend($user_id, $dataset, $max_reco)
  {
    //Get the predictions of the current user (not-rated) POIs ratings.
    $predictions_list = $this->predict($user_id, $dataset);

    //Get the user ratings average.
    $user_average = $this->user_ratings_average($user_id, $dataset);

    //Create empty array that hold the recommended POIs ID based on the predictions that base on users similarity.
    $recommendations = array();

    //Initialize a recommendations counter. 
    $i = 0;

    try {
      //for each predicted rating, do:
      foreach ($predictions_list as $poi_id => $rating) {
        if ($i < $max_reco) {

          //check if the rating is above the user ratings average, if yes then:
          if ($rating >= $user_average) {

            //save the POI ID to the recommendations array
            array_push($recommendations, $poi_id);
            //increment the number of recommended POIs
            $i++;
          }
        }
      }

      //if the number of recommendations > 0, then:
      if (count($recommendations) > 0) {
        //return recommendation array.
        return $recommendations;
      } else {
        //There is no recommendations.
        return "";
      }
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* 1pt+ Reputation for RS **************************************

  public function rep(): bool
  {
    //Create query that increment the current RS points. 
    $sql = "UPDATE RS SET points = points + 1 WHERE id = :RS_id;";
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_RS_id = 4;
        //bind the parameters
        $stmt->bindParam(":RS_id", $param_RS_id);

        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }


  //******************** Increase number of total recommendation by RS ****************************

  public function increase_total_recommendations($returned_MVP_reco): bool
  {
    //Create query that update the total recommendations of an RS. 
    $sql = "UPDATE RS SET total_poi_recommended = total_poi_recommended + :returned_MVP_reco WHERE id = :RS_id;";
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_RS_id = 4;
        $param_returned_MVP_reco = $returned_MVP_reco;
        //bind the parameters
        $stmt->bindParam(":RS_id", $param_RS_id);
        $stmt->bindParam(":returned_MVP_reco", $param_returned_MVP_reco);

        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* 1pt+ Reputation for RS **************************************

  public function increase_nb_request(): bool
  {
    //Create query that increment the current RS requests. 
    $sql = "UPDATE RS SET request_nbr = request_nbr + 1 WHERE id = :RS_id;";
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_RS_id = 4;
        //bind the parameters
        $stmt->bindParam(":RS_id", $param_RS_id);

        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
