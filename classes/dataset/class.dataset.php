<?php

class dataset
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //************************** convert Dataset example from database to a list ******************************

  public function get_dataset_example(): array //return an array object
  {
    //select the ratings of the user from the database.
    $sql = "SELECT user_id, poi_id, rate FROM user_item";

    //Create empty array that save the user ratings in ARRAY FORMAT.
    $dataset = array();

    try {
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {

        if ($stmt->execute()) {
          foreach ($stmt as $row) {
            //Save the ratings of each poi as:  POI_id(Key) => rating(Value).
            $dataset[$row["user_id"]][$row["poi_id"]] = $row["rate"];
          }
          //return the user ratings array.
          return $dataset;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* convert Full Dataset from database to a list **************************************

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

  //******************************* Get dataset filtered By time **************************************

  public function get_Dataset_filteredBy_time(): array //return an array object
  {

    //Get the current time of the user.
    $current_time = date_format(date_create("01:00"), "H:i");

    //Create empty array that save the dataset in ARRAY FORMAT.
    $dataset = array();

    try {
      //Check if it is the morning.
      if (strtotime($current_time) >= strtotime("06:00") && strtotime($current_time) <= strtotime("11:59")) {
        //create a query to select the filtered dataset from the database with feedback date between 06:00 and 11:59.
        $sql = ' SELECT user_id, poi_id, rate FROM `feedback` WHERE DATE_FORMAT(`date_feedback`, "%H:%i")  >= \'06:00\' AND DATE_FORMAT(`date_feedback`, "%H:%i")  <= \'11:59\' ';

        //Check if it is the afternoon.
      } else if (strtotime($current_time) >= strtotime("12:00") && strtotime($current_time) <= strtotime("17:59")) {
        //create a query to select the filtered dataset from the database with feedback date between 12:00 and 17:59.
        $sql = ' SELECT user_id, poi_id, rate FROM `feedback` WHERE DATE_FORMAT(`date_feedback`, "%H:%i")  >= \'12:00\' AND DATE_FORMAT(`date_feedback`, "%H:%i")  <= \'17:59\' ';

        //Check if it is the night.
      } else if (strtotime($current_time) >= strtotime("18:00") && strtotime($current_time) <= strtotime("23:59")) {
        //create a query to select the filtered dataset from the database with feedback date between 18:00 and 23:59.
        $sql = ' SELECT user_id, poi_id, rate FROM `feedback` WHERE DATE_FORMAT(`date_feedback`, "%H:%i")  >= \'18:00\' AND DATE_FORMAT(`date_feedback`, "%H:%i")  <= \'23:59\' ';

        //Check if it is after midnight.
      } else if (strtotime($current_time) >= strtotime("00:00") && strtotime($current_time) <= strtotime("05:59")) {
        //create a query to select the filtered dataset from the database with feedback date between 00:00 and 05:59.
        $sql = ' SELECT user_id, poi_id, rate FROM `feedback` WHERE DATE_FORMAT(`date_feedback`, "%H:%i")  >= \'00:00\' AND DATE_FORMAT(`date_feedback`, "%H:%i")  <= \'05:59\' ';
      }

      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {

        if ($stmt->execute()) {
          foreach ($stmt as $row) {
            //Save the ratings of each user as: user_id"Key" => array( POI_id(Key) => rating(Value), ..  )"Value".
            $dataset[$row["user_id"]][$row["poi_id"]] = $row["rate"];
          }
          //return the filtered dataset array.
          return $dataset;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //******************************* Get dataset filtered By weather **************************************

  public function get_Dataset_filteredBy_weather($weather): array //return an array object
  {
    //create a query to select the filtered dataset from the database with the current weather of the user.
    $sql = ' SELECT user_id, poi_id, rate FROM `feedback` WHERE weather = :weather';

    //Create empty array that save the dataset in ARRAY FORMAT.
    $dataset = array();

    try {

      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_weather = $weather;
        //bind the parameters
        $stmt->bindParam(":weather", $param_weather);
        if ($stmt->execute()) {
          foreach ($stmt as $row) {
            //Save the ratings of each user as: user_id"Key" => array( POI_id(Key) => rating(Value), ..  )"Value".
            $dataset[$row["user_id"]][$row["poi_id"]] = $row["rate"];
          }
          //return the filtered dataset array.
          return $dataset;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
