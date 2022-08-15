<?php

class MAP
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //********************************************** Export number of markers ******************************************
  public function NoMarkers()
  {
    try {
      //Create sql statement
      $sql = "SELECT count(*) FROM coordination";

      //prepare a statement
      if ($stmt = $this->pdo->prepare($sql)) {

        //execute statement
        if ($stmt->execute()) {
          if ($result = $stmt->fetchColumn()) {
            return $result;
          }
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //********************************************** Fetch ALL POIS ******************************************

  public function fetch_pois()
  {
    try {

      $sql = "SELECT * FROM poi ORDER BY views DESC";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
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

  //********************************************** Fetch POI Details ******************************************

  public function fetch_poi_details($id)
  {
    try {

      $sql = "SELECT * FROM poi where id = :id";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $id;
        //bind the parameters
        $stmt->bindParam(":id", $param_id);
        if ($stmt->execute()) {
          if ($row = $stmt->fetch()) {
            return $row;
          }
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //********************************************** Increase views of POI ******************************************

  public function increase_views($id): bool
  {
    try {

      $sql = "UPDATE poi SET views = views + 1 WHERE id = :id";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $id;
        //bind the parameters
        $stmt->bindParam(":id", $param_id);
        if ($stmt->execute()) {
          return true;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
