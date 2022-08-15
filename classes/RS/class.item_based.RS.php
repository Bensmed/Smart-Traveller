<?php
class item_based
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //******************************* convert Dataset from database to a list **************************************

  public function get_FullDataset(): array //return an array object
  {
    //create a query to select the full dataset from the database.
    $sql = "SELECT user_id, poi_id, rate FROM feedback";

    //Create empty array that save the dataset in ARRAY FORMAT.
    $dataset = array();

    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {

        if ($stmt->execute()) {
          foreach ($stmt as $row) {
            //Save the ratings of each user as: user_id"Key" => array( POI_id(Key) => rating(Value), ..  )"Value".
            $dataset[$row["user_id"]][$row["poi_id"]] = $row["rate"];
          }
          //return the full dataset array.
          return $dataset;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
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

  //******************************* Get POI ratings **************************************

  public function get_POI_ratings($poi_id, $dataset): array //return an array object
  {
    //Get all users id from the dataset.
    $users_id = $this->get_all_users_id($dataset);

    //Create empty array that save the POI ratings in ARRAY FORMAT.
    $POIs_ratings_list = array();

    try {
      //for each users, that at least rated one POI, do:
      foreach ($users_id as $user_id) {
        //check if the current user have rate this POI, if yes then:
        if (isset($dataset[$user_id][$poi_id])) {
          //save the rating.
          $rate = $dataset[$user_id][$poi_id];
          //save the current user POI rating, as $user_id(Key) => $rate(Value).
          $POIs_ratings_list[$user_id] = $rate;
        }
      }

      //return POIs ratings array.
      return $POIs_ratings_list;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //************ common POIs ratings average calculation for user similarity calculus ****************

  public function common_users_ratings_average($POI1_id, $POI2_id, $dataset)
  {
    //save both POIs ratings into arrays.
    $POI1_ratings_list =  $this->get_POI_ratings($POI1_id, $dataset);
    $POI2_ratings_list = $this->get_POI_ratings($POI2_id, $dataset);

    //Get all users id from the dataset.
    $users_id = $this->get_all_users_id($dataset);

    //initialize total both ratings with 0.
    $total_POI1_ratings = 0;
    $total_POI2_ratings = 0;

    //initialize the number of similar users with 0, to calculate the average of both POIs.
    $similar_users = 0;

    //Create empty array that hold the average values of both users in ARRAY FORMAT.
    $averages = array();

    try {

      //for each users, that at least rated one POI, do:
      foreach ($users_id as $user_id) {

        //Check if the current user has rated the POI1, if yes then :
        if (array_key_exists($user_id, $POI1_ratings_list)) {

          //Check if the current user has rated the POI2, if yes then :
          if (array_key_exists($user_id, $POI2_ratings_list)) {
            //both POIs have been rated by the same user, then:

            //calculate the sum of each POI ratings
            $total_POI1_ratings += $POI1_ratings_list[$user_id];
            $total_POI2_ratings += $POI2_ratings_list[$user_id];

            //increment the number of similar users.
            $similar_users++;
          }
        }
      }
      //The Denominator must not equal 0.
      if ($similar_users == 0) {

        //return NAN, because its impossible to divide over it.    
        return NAN;
      } else {

        //Calculate the average for each user by dividing over the number of similar POIs.
        $average_POI1 = $total_POI1_ratings / $similar_users;
        $average_POI2 = $total_POI2_ratings / $similar_users;
      }

      //Save both users average.
      array_push($averages, $average_POI1, $average_POI2);

      //return the averages array.
      return $averages;
    } catch (ErrorException $e) {
      echo $e->getMessage();
    }
  }

  //*************** user ratings average calculation for calculus *********************

  public function item_ratings_average($POI_id, $dataset)
  {
    //save POI ratings into an array.
    $POI_ratings_list =  $this->get_POI_ratings($POI_id, $dataset);

    //Get all users id from the dataset.
    $users_id = $this->get_all_users_id($dataset);

    //initialize total ratings with 0.
    $total_POI_ratings = 0;

    try {
      //for each users, that at least rated one POI, do:
      foreach ($users_id as $user_id) {

        //Check if the current user has rated this POI, if yes then :
        if (array_key_exists($user_id, $POI_ratings_list)) {

          //calculate the sum of user ratings
          $total_POI_ratings += $POI_ratings_list[$user_id];
        }
      }

      //The Denominator must not equal 0.
      if (count($POI_ratings_list) != 0) {

        //Calculate the average by dividing over the number of the users that rated this current POI .
        $average = $total_POI_ratings / count($POI_ratings_list);
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
      // for all POIs, that at least have been rated by one user. DO:
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

  public function sim($POI1, $POI2, $dataset)
  {
    //save both POIs ratings in two arrays.
    $POI1_ratings_list =  $this->get_POI_ratings($POI1, $dataset);
    $POI2_ratings_list =  $this->get_POI_ratings($POI2, $dataset);

    //Get all users id from the dataset.
    $users_id = $this->get_all_users_id($dataset);

    $N = 0; //Nominator

    $D_POI1 = 0; //Denominator user1
    $D_POI2 = 0; //Denominator user2

    //Averages of both POIs with the common users only.
    $averages = $this->common_users_ratings_average($POI1, $POI2, $dataset);

    try {
      //Check if both POIs have at least one user in common, if yes then:
      if (is_array($averages)) {
        //save the ratings average of each POI.
        $POI1_average = $averages[0];
        $POI2_average = $averages[1];
      } else if (is_nan($averages)) {

        //return NAN, because there is no common ratings between both of them.
        return NAN;
      }
      //for each users, that at least rated one POI, do:
      foreach ($users_id as $user_id) {

        //Check if the current user has rated the POI1, if yes then :
        if (array_key_exists($user_id, $POI1_ratings_list)) {

          //Check if the current user has rated the POI2, if yes then :
          if (array_key_exists($user_id, $POI2_ratings_list)) {
            //both POIs have been rated by the same user, then:

            //Apply the pearson's correlation 
            //Calculate the nominator
            $N += (($POI1_ratings_list[$user_id] - $POI1_average) * ($POI2_ratings_list[$user_id] - $POI2_average));

            //Calculate the denominator of each user
            $D_POI1 += pow(($POI1_ratings_list[$user_id] - $POI1_average), 2);
            $D_POI2 += pow(($POI2_ratings_list[$user_id] - $POI2_average), 2);
          }
        }
      }

      //Calculate the full denominator 
      $D = (sqrt($D_POI1) * sqrt($D_POI2));
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

  //******************************* prediction calculation *************************************
  public function predict($user_id, $dataset): array
  {
    //save user ratings into an arrays.
    $user_ratings_list = $this->get_user_ratings($user_id, $dataset);

    //Get all POIs id from the dataset.
    $POIs_id = $this->get_all_POIs_id($dataset);

    //Create empty array that hold the predictions list of the user (not-rated) POIs ratings in ARRAY FORMAT.
    $predictions_list = array();

    try {
      // for all POIs, that atleast have been rated by one user. DO:
      foreach ($POIs_id as $POI_id) {
        //Check if the POI is not rated yet by the user, if yes then:
        if (!array_key_exists($POI_id, $user_ratings_list)) {

          //initialize the nominator and the denominator with 0 value.
          $N = 0;
          $D = 0;

          // for all POIs, that atleast have been rated by one user. DO:
          foreach ($POIs_id as $another_POI) {
            //Check if the POi is already rated by the user, so we can calculate the similarity between them:
            if (array_key_exists($another_POI, $user_ratings_list)) {
              //Calculate the similarity between both POIs.
              $sim = $this->sim($POI_id, $another_POI, $dataset);

              //check if the similarity is not equal to NAN:
              if (!is_nan($sim)) {
                //Apply prediction calculus 

                // calculate the nominator
                $N += $sim * $user_ratings_list[$another_POI];
                // calculate the denominator
                $D += $sim;
              }
            }
          }

          //if the denominator equal 0, then
          if ($D == 0) {
            //save prediction of POI as NAN, because its impossible to divide over it.
            $predictions_list[$POI_id] = NAN;
          } else {
            if (($N / $D) <= 1) {
              //if the prediction is lower than 1, then affect it's value to 1.
              $predictions_list[$POI_id] = 1;
            } else if (($N / $D) >= 5) {
              //if the prediction is greater than 5, then affect it's value to 5.
              $predictions_list[$POI_id] = 5;
            } else {
              //Save prediction of POI as:  POI_id(Key) => prediction(Value).
              $predictions_list[$POI_id] = $N / $D;
            }
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
  //******************************* item based_RS calculation **************************************

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

  //******************************* Get the similar items to  *************************************
  public function similarItems_to($min_sim, $POI_id, $dataset): array
  {
    //Get all POIs id from the dataset.
    $POIs_id = $this->get_all_POIs_id($dataset);

    //Create empty array that hold the IDs of the most similar POIs in ARRAY FORMAT.
    $similar_items = array();

    try {
      // for all POIs, that atleast have been rated by one user. DO:
      foreach ($POIs_id as $another_POI) {
        if ($another_POI != $POI_id) {

          //Calculate the similarity between both POIs.
          $sim = $this->sim($POI_id, $another_POI, $dataset);

          //check if the similarity is not equal to NAN:
          if (!is_nan($sim)) {

            //save the POIs ID that have similarity above the (minimum similarity parameter):$min_sim.
            if ($sim >= $min_sim) {

              //Save the similarity with each POI as:  POI_id(Key) => similarity(Value).
              $similar_items[$another_POI] =  $sim;
            }
          }
        }
      }

      //return the similar items array.
      return $similar_items;
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
        $param_RS_id = 5;
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
        $param_RS_id = 5;
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
        $param_RS_id = 5;
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
