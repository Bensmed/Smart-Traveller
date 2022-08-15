<?php

class MFT_RS
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }


  //******************************* Most frequented transition recommendation **************************************

  public function recommend($last_visited_poi_id, $nb_reco)
  {
    //Select POIs from the database
    $sql = "SELECT poi.* FROM transition INNER JOIN poi 
    ON transition.poi_end_id = poi.id
    WHERE transition.poi_start_id = :last_visited_poi_id ORDER BY transition.frequency DESC LIMIT :nb_reco;";

    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {

        //set the parameters
        $param_last_visited_poi_id = $last_visited_poi_id;
        $param_nb_reco = $nb_reco;

        //bind the parameters
        $stmt->bindParam(":nb_reco", $param_nb_reco, PDO::PARAM_INT);
        $stmt->bindParam(":last_visited_poi_id", $param_last_visited_poi_id);

        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
            //return the result
            return $stmt;
          } else {
            return "";
          }
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //******************************* 1pt+ Reputation for RS **************************************

  public function rep(): bool
  {

    $sql = "UPDATE RS SET points = points + 1 WHERE id = :RS_id;";
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_RS_id = 2;
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

    $sql = "UPDATE RS SET total_poi_recommended = total_poi_recommended + :returned_MVP_reco WHERE id = :RS_id;";
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_RS_id = 2;
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

    $sql = "UPDATE RS SET request_nbr = request_nbr + 1 WHERE id = :RS_id;";
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_RS_id = 2;
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
