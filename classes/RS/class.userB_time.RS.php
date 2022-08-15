<?php

class user_based_filteredBy_time
{
  public $pdo;
  public $user_based;
  public $datasetClass;
  function __construct($pdo)
  {
    $this->pdo = $pdo;
    $this->user_based = new user_based($pdo);
    $this->datasetClass = new dataset($pdo);
  }



  //******************************* user based_RS time filtered recommendation **************************************

  public function recommend($user_id, $max_reco)
  {
    //Get the dataset filtered by time.
    $dataset = $this->datasetClass->get_Dataset_filteredBy_time();

    //Get the predictions of the current user (not-rated) POIs ratings.
    $predictions_list = $this->user_based->predict($user_id, $dataset);

    //Get the user ratings average.
    $user_average = $this->user_based->user_ratings_average($user_id, $dataset);

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
        $param_RS_id = 6;
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
        $param_RS_id = 6;
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
        $param_RS_id = 6;
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
