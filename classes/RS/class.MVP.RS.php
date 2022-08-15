<?php

class MVP_RS
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //******************************* Most viewed POIs recommendation **************************************
  public function recommend($last_visited_poi_id, $nb_reco)
  {
    if ($last_visited_poi_id != 0) {
      $sql = "SELECT * FROM poi WHERE poi.id != :last_visited_poi_id ORDER BY views DESC LIMIT :nb_reco";
    } else {
      $sql = "SELECT * FROM poi ORDER BY views DESC LIMIT :nb_reco";
    }
    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set and bind the parameters
        if ($last_visited_poi_id != 0) {
          $param_last_visited_poi_id = $last_visited_poi_id;
          $stmt->bindParam(":last_visited_poi_id", $param_last_visited_poi_id);
        }

        $param_nb_reco = $nb_reco;
        $stmt->bindParam(":nb_reco", $param_nb_reco, PDO::PARAM_INT);

        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
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
        $param_RS_id = 1;
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
        $param_RS_id = 1;
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
        $param_RS_id = 1;
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
