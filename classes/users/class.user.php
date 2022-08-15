<?php

class USER
{
  public $pdo;

  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // ********************************************* Check if email exist Function ****************************************
  function check_email_exist($email)
  {
    try {
      $sql = "SELECT * FROM user WHERE email = :email";
      //Check if email exist
      if ($stmt = $this->pdo->prepare($sql)) {
        //bind parameters
        $stmt->bindParam(":email", $email);


        if ($stmt->execute()) {
          if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
              return $row;
            }
          } else {
            return false;
          }
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    //Close statement
    unset($stmt);
  }

  // ********************************************* Check if phone number exist Function ****************************************
  function check_phone_exist($phone)
  {
    try {
      $sql = "SELECT * FROM user WHERE phone = :phone";
      //Check if email exist
      if ($stmt = $this->pdo->prepare($sql)) {
        //bind parameters
        $stmt->bindParam(":phone", $phone);


        if ($stmt->execute()) {
          if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
              return $row;
            }
          } else {
            return false;
          }
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    //Close statement
    unset($stmt);
  }

  //   ********************************************* Register function **************************************************
  function register($email, $password, $last_seen): bool
  {

    $sql = "INSERT INTO user VALUES (NULL ,  NULL, NULL, NULL, NULL , NULL , :password , :email , NULL, :last_seen)";
    try {
      if ($stmt = $this->pdo->prepare($sql)) {
        //Set the parameters
        $param_email = $email;

        //Create a password hash
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        $param_last_seen = $last_seen;

        //Bind parameters
        $stmt->bindParam(":email", $param_email);
        $stmt->bindParam(":password", $param_password);
        $stmt->bindParam(":last_seen", $param_last_seen);



        if ($stmt->execute()) {
          $sql = "INSERT INTO user_role SELECT id , :role FROM user WHERE email = :email";

          //prepare another statement
          if ($stm = $this->pdo->prepare($sql)) {
            //Set the parameters
            $param_email = $email;
            $param_role = 3;

            //Bind parameters
            $stm->bindParam(":email", $param_email);
            $stm->bindParam(":role", $param_role);


            if ($stm->execute()) {
              return true;
            } else {
              return false;
            }
          }
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // ************************************************** Redirect function *********************************************
  public function redirect($url)
  {
    header("Location: $url");
  }

  // ************************************************** Login Function **************************************************
  function login($email, $password)
  {
    try {
      if ($row = $this->check_email_exist($email)) {

        // Check if email exists, if yes then verify password
        if ($row !== false) {

          $id = $row["id"];
          $email = $row["email"];
          $hashed_password = $row["password"];

          if (password_verify($password, $hashed_password)) {
            return $id;
          } else {
            return "password_err";
          }
        }
      } else {
        return "email_err";
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // *************************** Last seen Function **************************************
  function last_seen(): bool
  {

    $sql = "UPDATE user SET last_seen = :last_seen WHERE id = :user_id";

    try {
      //prepare a statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $_SESSION["id"];
        $param_date = date("Y-m-d H:i:s");
        //bind parameters
        $stmt->bindParam(":user_id", $param_id);
        $stmt->bindParam(":last_seen", $param_date);

        //execute statement
        if ($stmt->execute()) {
          return true;
        }
      } else {
        return false;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // ********************************************** is LoggedIn Function ************************************************
  public function is_loggedin(): bool
  {
    // Check if the user is already logged in, if yes then redirect him to home page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
      return true;
    } else {
      return false;
    }
  }

  // ************************************************ LogOut Function ****************************************************
  public function logout()
  {
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
    $this->redirect("/");
  }

  //********************************************** fetch Profile data Function *******************************************
  public function fetch_profile()
  {
    try {
      //Create sql statement
      $sql = "SELECT * FROM user WHERE id = :id";

      //prepare a statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $_SESSION["id"];
        //bind parameters
        $stmt->bindParam(":id", $param_id);

        //execute statement
        if ($stmt->execute()) {
          if ($row = $stmt->fetch()) {
            return $row;
          }
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //**************************************** Change personal informations Function ***************************************
  public function change_personalInfo($Fname, $Lname, $age, $function)
  {
    try {
      //prepare a statement
      $sql = "UPDATE user SET Fname= :Fname, Lname = :Lname, age = :age, function = :function WHERE id = :id";

      //prepare the statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_Fname = $Fname;
        $param_Lname = $Lname;
        $param_age = $age;
        $param_function = $function;
        $param_id = $_SESSION["id"];

        //bind the parameters
        $stmt->bindParam(":Fname", $param_Fname);
        $stmt->bindParam(":Lname", $param_Lname);
        $stmt->bindParam(":age", $param_age);
        $stmt->bindParam(":function", $param_function);
        $stmt->bindParam(":id", $param_id);


        //execute statement
        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //************************************************ Change Phone number Function *******************************************
  public function change_phone($phone)
  {
    try {
      //prepare a statement
      $sql = "UPDATE user SET phone= :newPhone WHERE id = :id";

      //prepare the statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters       
        $param_new_phone = $phone;
        $param_id = $_SESSION["id"];

        //bind the parameters
        $stmt->bindParam(":newPhone", $param_new_phone);
        $stmt->bindParam(":id", $param_id);

        //execute statement
        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //************************************************ Change phone Function ***********************************************
  public function change_email($email)
  {
    try {
      //prepare a statement
      $sql = "UPDATE user SET email= :newEmail WHERE id = :id";

      //prepare the statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters       
        $param_new_email = $email;
        $param_id = $_SESSION["id"];

        //bind the parameters
        $stmt->bindParam(":newEmail", $param_new_email);
        $stmt->bindParam(":id", $param_id);

        //execute statement
        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //******************************************** is correct password Function ********************************************
  public function isCorrect_password($password)
  {
    try {
      //check if current password is correct
      $sql = "SELECT * FROM user WHERE id = :id";
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $_SESSION["id"];
        //bind the parameters
        $stmt->bindParam(":id", $param_id);

        if ($stmt->execute()) {
          if ($row = $stmt->fetch()) {
            $hashed_password = $row["password"];
          }
          //close stmt
          unset($stmt);
          //verify if password is correct
          if (password_verify($password, $hashed_password)) {
            return true;
          } else {
            return false;
          }
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //********************************************* Change password Function **********************************************
  public function change_password($current_password, $new_password)
  {
    try {

      $sql = "UPDATE user SET `password` = :newPassword WHERE id = :id";
      //prepare the statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $param_id = $_SESSION["id"];
        //bind the parameters
        $stmt->bindParam(":newPassword", $param_new_password);
        $stmt->bindParam(":id", $param_id);

        //execute the statement
        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************* is active page Function **********************************************
  public function isActive_page($uri)
  {
    if ($_SERVER['SCRIPT_NAME'] == $uri) {
      return true;
    } else {
      return false;
    }
  }

  //********************************************* fetch user info Function **********************************************
  public function fetch_UserInfo($user_id)
  {
    try {

      $sql = "SELECT * FROM user WHERE id = :id ";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_id = $user_id;
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
  //********************************************* delete user Function **********************************************
  public function delete_user($user_id): bool
  {
    try {

      $sql = "DELETE FROM user WHERE user.id = :id";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_id = $user_id;
        //bind the parameters
        $stmt->bindParam(":id", $param_id);
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

  //***************************************** Evaluate POI function **************************************************
  function evaluate($poi_id, $user_id, $rate, $comment, $feedback_date, $poi_weather, $poi_temp, $feedback_long, $feedback_lat): bool
  {

    $sql = "INSERT INTO feedback VALUES (NULL, :rate , :comment , :feedback_date, :poi_weather , :poi_temp, :feedback_long, :feedback_lat, :user_id, :poi_id);";
    try {
      if ($stmt = $this->pdo->prepare($sql)) {
        //Set the parameters
        $param_rate = $rate;
        $param_comment = $comment;
        $param_feedback_date = $feedback_date;
        $param_poi_weather = $poi_weather;
        $param_poi_temp = $poi_temp;
        $param_feedback_long = $feedback_long;
        $param_feedback_lat = $feedback_lat;
        $param_poi_id = $poi_id;
        $param_user_id = $user_id;


        //Bind parameters
        $stmt->bindParam(":rate", $param_rate);
        $stmt->bindParam(":comment", $param_comment);
        $stmt->bindParam(":feedback_date", $param_feedback_date);
        $stmt->bindParam(":poi_weather", $param_poi_weather);
        $stmt->bindParam(":poi_temp", $param_poi_temp);
        $stmt->bindParam(":feedback_long", $param_feedback_long);
        $stmt->bindParam(":feedback_lat", $param_feedback_lat);
        $stmt->bindParam(":poi_id", $param_poi_id);
        $stmt->bindParam(":user_id", $param_user_id);



        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************* fetch poi feedbacks Function **********************************************
  public function fetch_poi_feedback($poi_id)
  {
    try {

      $sql = "SELECT user.Lname , user.Fname , feedback.rate ,feedback.comment , feedback.date_feedback FROM 
       user INNER JOIN feedback ON user.id = feedback.user_id WHERE poi_id =:poi_id  ";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //Set the parameters
        $param_poi_id = $poi_id;
        //Bind parameters
        $stmt->bindParam(":poi_id", $param_poi_id);
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

  //***************************************** Visit POI function **************************************************
  public function visit($user_id, $nb_rec, $visited_poi_id, $is_recommended, $visit_date): bool
  {

    $sql = "INSERT INTO evaluation VALUES (null, :user_id, :nb_rec, :visited_poi_id , :is_recommended, :visit_date );";
    try {


      if ($stmt = $this->pdo->prepare($sql)) {
        //Set the parameters
        $param_user_id = $user_id;
        $param_nb_rec = $nb_rec;
        $param_visited_poi_id = $visited_poi_id;
        $param_is_recommended = $is_recommended;
        $param_visit_date = $visit_date;

        //Bind parameters
        $stmt->bindParam(":user_id", $param_user_id);
        $stmt->bindParam(":nb_rec", $param_nb_rec);
        $stmt->bindParam(":visited_poi_id", $param_visited_poi_id);
        $stmt->bindParam(":is_recommended", $param_is_recommended);
        $stmt->bindParam(":visit_date", $param_visit_date);

        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }


      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************** Fetch Person Visit History ******************************************

  public function fetch_visit_history($user_id, $pageNo, $nRow_pPage)
  {
    try {
      $offset = ($pageNo - 1) * $nRow_pPage;

      $sql = "SELECT evaluation.chosen_poi_id, evaluation.date, poi.id, poi.designation, poi.type FROM evaluation INNER JOIN poi ON evaluation.chosen_poi_id = poi.id WHERE user_id = :user_id ORDER BY evaluation.date DESC LIMIT :offset , :nRow_pPage";

      if ($stmt = $this->pdo->prepare($sql)) {
        //Set the parameters
        $param_user_id = $user_id;
        $param_offset = $offset;
        $param_nRow_pPage = $nRow_pPage;
        //Bind parameters
        $stmt->bindParam(":user_id", $param_user_id);
        $stmt->bindParam(":offset", $param_offset, PDO::PARAM_INT);
        $stmt->bindParam(":nRow_pPage", $param_nRow_pPage, PDO::PARAM_INT);
        //prepare statement
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

  //*************************************** Get number of accounts per role Function **************************************
  public function count_visitedPoi_history($user_id)
  {
    try {

      $sql = "SELECT COUNT(*)
       FROM 
       evaluation WHERE user_id = :user_id";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_user_id = $user_id;
        //bind the parameters
        $stmt->bindParam(":user_id", $param_user_id);
        if ($stmt->execute()) {
          if ($total_rows = $stmt->fetch()[0]) {
            return $total_rows;
          }
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }


  //*************************************** Get number of accounts per role Function **************************************
  public function get_last_visited_poi_id($user_id): int
  {
    try {

      $sql = "SELECT *
        FROM 
        evaluation WHERE user_id = :user_id ORDER BY evaluation.date DESC LIMIT 1;";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_user_id = $user_id;
        //bind the parameters
        $stmt->bindParam(":user_id", $param_user_id);
        if ($stmt->execute()) {
          if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
              return $row['chosen_poi_id'];
            }
          } else {
            return 0;
          }
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }


  //***************************************** ADD transition function ********************************************
  public function addTransition($last_visited_poi_id, $visited_poi_id, $date): bool
  {
    $sql = "SELECT *
    FROM 
    transition WHERE poi_start_id = :last_visited_poi_id AND poi_end_id = :visited_poi_id;";

    try {
      if ($stmt = $this->pdo->prepare($sql)) {
        //Set the parameters 
        $param_last_visited_poi_id = $last_visited_poi_id;
        $param_visited_poi_id = $visited_poi_id;

        //Bind parameters
        $stmt->bindParam(":last_visited_poi_id", $param_last_visited_poi_id);
        $stmt->bindParam(":visited_poi_id", $param_visited_poi_id);

        if ($stmt->execute()) {
          if ($stmt->rowCount() == 1) {
            //Check if the course already exist, so increment its frequency.
            $sql2 = "UPDATE transition 
            SET frequency = frequency + 1 ,
            up_date = :date
             WHERE poi_start_id = :last_visited_poi_id AND poi_end_id = :visited_poi_id ;";
          } else {
            //if the course does not exist, then create it with frequency = 1.
            $sql2 = "INSERT INTO transition VALUES (NULL, :last_visited_poi_id , :visited_poi_id , 1 , :date);";
          }
          //prepare statement2 with sql query2.
          if ($stmt2 = $this->pdo->prepare($sql2)) {
            //Set the parameters 
            $param_last_visited_poi_id = $last_visited_poi_id;
            $param_visited_poi_id = $visited_poi_id;
            $param_date = $date;
            //Bind parameters
            $stmt2->bindParam(":last_visited_poi_id", $param_last_visited_poi_id);
            $stmt2->bindParam(":visited_poi_id", $param_visited_poi_id);
            $stmt2->bindParam(":date", $param_date);

            if ($stmt2->execute()) {
              return true;
            } else {
              return false;
            }
          }
        } else {
          return false;
        }
      }

      //Close statement
      unset($stmt);
      unset($stmt2);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
