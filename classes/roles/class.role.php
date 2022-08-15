<?php

class role
{

  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }


  //********************************************* isAdmin Function **********************************************
  public function isAdmin($id): bool
  {
    try {
      /**SELECT `role_id` FROM `user_role` WHERE `user_id`=1 */
      $sql = "SELECT role_id FROM user_role WHERE user_id = :id";

      //preapre statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $id;
        //bind the parameters
        $stmt->bindParam(":id", $param_id);

        //execute the statement
        if ($stmt->execute()) {
          if ($row = $stmt->fetch()) {
            $role = $row["role_id"];
            if ($role == 1) {
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
  //********************************************* fetch all Admins Function **********************************************
  public function fetchAll_Admins()
  {
    try {

      $sql = "SELECT user.id  , user.Lname , user.Fname , user.age , user.email
          FROM 
          user INNER JOIN user_role ON user.id = user_role.user_id 
                   
                       WHERE user_role.role_id = 1 ";
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
  //*************************************** Get number of accounts per role Function **************************************
  public function count_Accounts_Of($roleID)
  {
    try {

      $sql = "SELECT COUNT(*)
      FROM 
      user INNER JOIN user_role ON user.id = user_role.user_id 
               
                   WHERE user_role.role_id = :roleID";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_roleID = $roleID;
        //bind the parameters
        $stmt->bindParam(":roleID", $param_roleID);
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

  //*************************************** Get number of accounts per ID Function **************************************
  public function count_search_Accounts_ByID($ID)
  {
    try {

      $sql = "SELECT COUNT(*)
      FROM 
      user INNER JOIN user_role ON user.id = user_role.user_id 
               
                   WHERE user_role.user_id = :ID";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_ID = $ID;
        //bind the parameters
        $stmt->bindParam(":ID", $param_ID);
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

  //*************************************** Get number of accounts per ID Function **************************************
  public function count_search_Accounts_Byemail($email)
  {
    try {

      $sql = "SELECT COUNT(*)
       FROM 
       user INNER JOIN user_role ON user.id = user_role.user_id 
                
                    WHERE user.email = :email";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_email = $email;
        //bind the parameters
        $stmt->bindParam(":email", $param_email);
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

  //*************************************** Get number of accounts per ID Function **************************************
  public function count_search_Accounts_ByLname($Lname)
  {
    try {

      $sql = "SELECT COUNT(*)
      FROM 
      user INNER JOIN user_role ON user.id = user_role.user_id 
               
                   WHERE user.Lname = :Lname";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_Lname = $Lname;
        //bind the parameters
        $stmt->bindParam(":Lname", $param_Lname);
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

  //*************************************** Get number of accounts per ID Function **************************************
  public function count_search_Accounts_ByFname($Fname)
  {
    try {

      $sql = "SELECT COUNT(*)
       FROM 
       user INNER JOIN user_role ON user.id = user_role.user_id 
                
                    WHERE user.Fname = :Fname";
      //prepare statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_Fname = $Fname;
        //bind the parameters
        $stmt->bindParam(":Fname", $param_Fname);
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
  //********************************************** fetch accounts Function **********************************************

  public function fetch_accounts(int $roleID, int $pageNo, int $nRow_pPage)
  {
    $offset = ($pageNo - 1) * $nRow_pPage;
    try {
      $sql = "SELECT *
    FROM 
    user INNER JOIN user_role ON user.id = user_role.user_id 
             
                 WHERE user_role.role_id = :roleID ORDER BY user.last_seen DESC
                 LIMIT :offset , :nRow_pPage ";
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_roleID = $roleID;
        $param_offset = $offset;
        $param_nRow_pPage = $nRow_pPage;
        //bind the parameters
        $stmt->bindParam(":roleID", $param_roleID, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $param_offset, PDO::PARAM_INT);
        $stmt->bindParam(":nRow_pPage", $param_nRow_pPage, PDO::PARAM_INT);
        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
            return $stmt;
          } else {
            return "";
          }
        }
      }
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************** search accounts by ID Function **********************************************

  public function search_accounts_ByID(int $ID, int $roleID, int $pageNo, int $nRow_pPage)
  {
    $offset = ($pageNo - 1) * $nRow_pPage;
    try {
      $sql = "SELECT user.id  , user.Lname , user.Fname , user.age , user.email ,user.function, user.phone
     FROM 
     user INNER JOIN user_role ON user.id = user_role.user_id 
              
                  WHERE user_role.user_id = :ID AND user_role.role_id = :roleID ORDER BY user.id DESC
                  LIMIT :offset , :nRow_pPage";
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_ID = $ID;
        $param_roleID = $roleID;
        $param_offset = $offset;
        $param_nRow_pPage = $nRow_pPage;
        //bind the parameters
        $stmt->bindParam(":ID", $param_ID, PDO::PARAM_INT);
        $stmt->bindParam(":roleID", $param_roleID, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $param_offset, PDO::PARAM_INT);
        $stmt->bindParam(":nRow_pPage", $param_nRow_pPage, PDO::PARAM_INT);
        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
            return $stmt;
          } else {
            return "";
          }
        }
      }
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************** search accounts by Email Function **********************************************

  public function search_accounts_ByEmail(String $email, int $roleID, int $pageNo, int $nRow_pPage)
  {
    $offset = ($pageNo - 1) * $nRow_pPage;
    try {
      $sql = "SELECT user.id  , user.Lname , user.Fname , user.age , user.email ,user.function, user.phone
      FROM 
      user INNER JOIN user_role ON user.id = user_role.user_id 
               
                   WHERE user.email = :email AND user_role.role_id = :roleID ORDER BY user.id DESC
                   LIMIT :offset , :nRow_pPage";
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_email = $email;
        $param_roleID = $roleID;
        $param_offset = $offset;
        $param_nRow_pPage = $nRow_pPage;
        //bind the parameters
        $stmt->bindParam(":email", $param_email);
        $stmt->bindParam(":roleID", $param_roleID, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $param_offset, PDO::PARAM_INT);
        $stmt->bindParam(":nRow_pPage", $param_nRow_pPage, PDO::PARAM_INT);
        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
            return $stmt;
          } else {
            return "";
          }
        }
      }
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************** search accounts by First name Function **********************************************

  public function search_accounts_ByFname(String $Fname, int $roleID, int $pageNo, int $nRow_pPage)
  {
    $offset = ($pageNo - 1) * $nRow_pPage;
    try {
      $sql = "SELECT user.id  , user.Lname , user.Fname , user.age , user.email ,user.function, user.phone
        FROM 
        user INNER JOIN user_role ON user.id = user_role.user_id 
                 
                     WHERE user.Fname = :Fname AND user_role.role_id = :roleID ORDER BY user.id DESC
                     LIMIT :offset , :nRow_pPage";
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_Fname = $Fname;
        $param_roleID = $roleID;
        $param_offset = $offset;
        $param_nRow_pPage = $nRow_pPage;
        //bind the parameters
        $stmt->bindParam(":Fname", $param_Fname);
        $stmt->bindParam(":roleID", $param_roleID, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $param_offset, PDO::PARAM_INT);
        $stmt->bindParam(":nRow_pPage", $param_nRow_pPage, PDO::PARAM_INT);
        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
            return $stmt;
          } else {
            return "";
          }
        }
      }
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************** search accounts by Last name Function **********************************************

  public function search_accounts_ByLname(String $Lname, int $roleID, int $pageNo, int $nRow_pPage)
  {
    $offset = ($pageNo - 1) * $nRow_pPage;
    try {
      $sql = "SELECT user.id  , user.Lname , user.Fname , user.age , user.email ,user.function, user.phone
        FROM 
        user INNER JOIN user_role ON user.id = user_role.user_id 
                 
                     WHERE user.Lname = :Lname AND user_role.role_id = :roleID ORDER BY user.id DESC
                     LIMIT :offset , :nRow_pPage";
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters    
        $param_Lname = $Lname;
        $param_roleID = $roleID;
        $param_offset = $offset;
        $param_nRow_pPage = $nRow_pPage;
        //bind the parameters
        $stmt->bindParam(":Lname", $param_Lname);
        $stmt->bindParam(":roleID", $param_roleID, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $param_offset, PDO::PARAM_INT);
        $stmt->bindParam(":nRow_pPage", $param_nRow_pPage, PDO::PARAM_INT);
        if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
            return $stmt;
          } else {
            return "";
          }
        }
      }
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  //********************************************* Get role name Function **********************************************
  public function getRole($id)
  {
    try {

      $sql = "SELECT role.name
                FROM 
                user_role INNER JOIN role ON role.id = user_role.role_id
                             WHERE user_role.user_id = :id";
      //preapre statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $id;
        //bind the parameters
        $stmt->bindParam(":id", $param_id);

        //execute the statement
        if ($stmt->execute()) {

          if ($row = $stmt->fetch()) {
            return $row["name"];
          }
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //********************************************* Get role ID Function **********************************************
  public function getRoleID($id)
  {
    try {

      $sql = "SELECT role.id
                FROM 
                user_role INNER JOIN role ON role.id = user_role.role_id
                             WHERE user_role.user_id = :id";
      //preapre statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_id = $id;
        //bind the parameters
        $stmt->bindParam(":id", $param_id);

        //execute the statement
        if ($stmt->execute()) {

          if ($row = $stmt->fetch()) {
            return $row["id"];
          }
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  //********************************************* Change role Function **********************************************
  public function changeRole($userID, $roleID): bool
  {
    try {

      $sql = "UPDATE `user_role` SET `role_id` = :roleID
                     WHERE `user_role`.`user_id` = :userID";
      //preapre statement
      if ($stmt = $this->pdo->prepare($sql)) {
        //set the parameters
        $param_userID = $userID;
        $param_roleID = $roleID;
        //bind the parameters
        $stmt->bindParam(":userID", $param_userID);
        $stmt->bindParam(":roleID", $param_roleID);

        //execute the statement
        if ($stmt->execute()) {

          return true;
        }
      }
      //Close statement
      unset($stmt);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
