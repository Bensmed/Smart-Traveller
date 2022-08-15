<?php

require_once 'config.php';
//************************************************* Table USER ***************************************************
try {
  $sql = "CREATE TABLE User(
    id INT AUTO_INCREMENT NOT NULL ,
    email VARCHAR(50) NOT NULL ,
    Fname VARCHAR(30) NOT NULL,
    Lname VARCHAR(30) NOT NULL,
    age date NOT NULL,
    password VARCHAR(255) NOT NULL,
    
     PRIMARY KEY (`id`),
      UNIQUE (`email`)
  )";
  $pdo->exec($sql);
  echo  "*** Table 'User' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'User' already exist <br>";
}
//************************************************* Table ROLE ***************************************************
try {
  $sql = "CREATE TABLE Role(
    id INT AUTO_INCREMENT NOT NULL ,
    name VARCHAR(30) NOT NULL,
    desp VARCHAR(255) ,
    PRIMARY KEY (`id`)
  )";
  $pdo->exec($sql);
  echo  "*** Table 'Role' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'Role' already exist <br>";
}
//*********************************************** Table USER_ROLE ***************************************************
try {
  $sql = "CREATE TABLE User_role(
    user_id INT NOT NULL ,
    role_id INT NOT NULL,
    PRIMARY KEY (`user_id`),
    CONSTRAINT fk_userId
          FOREIGN KEY (user_id) 
          REFERENCES user(id)
            ON UPDATE RESTRICT
            ON DELETE CASCADE,
    CONSTRAINT fk_roleId
          FOREIGN KEY (role_id) 
          REFERENCES role(id)
           ON UPDATE CASCADE
           ON DELETE RESTRICT
  )";
  $pdo->exec($sql);
  echo  "*** Table 'User_role' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'User_role' already exist <br>";
}
//************************************************* Table PERMISSION ***************************************************
try {
  $sql = "CREATE TABLE Permission(
    id INT AUTO_INCREMENT NOT NULL ,
    name VARCHAR(30) NOT NULL,
    desp VARCHAR(255) ,
    PRIMARY KEY (`id`)
  )";
  $pdo->exec($sql);
  echo  "*** Table 'Permission' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'Permission' already exist <br>";
}
//********************************************* Table ROLE_PERMISSION ***************************************************
try {
  $sql = "CREATE TABLE Role_permission(
    role_id INT NOT NULL ,
    permission_id INT NOT NULL,
    CONSTRAINT fk2_roleId
          FOREIGN KEY (role_id) 
          REFERENCES role(id)
           ON UPDATE CASCADE
           ON DELETE RESTRICT,
    CONSTRAINT fk_permissionId
          FOREIGN KEY (permission_id) 
          REFERENCES permission(id)
            ON UPDATE RESTRICT
            ON DELETE CASCADE
  )";
  $pdo->exec($sql);
  echo  "*** Table 'Role_permission' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'Role_permission' already exist <br>";
}
//********************************************* Table COORDINATION ***************************************************
try {
  $sql = "CREATE TABLE Coordination(
   id INT AUTO_INCREMENT NOT NULL ,
    name VARCHAR(255) NOT NULL,
    lat VARCHAR(30) NOT NULL,
    lon VARCHAR(30) NOT NULL,
    type VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
  )";
  $pdo->exec($sql);
  echo  "*** Table 'Coordination' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'Coordination' already exist <br>";
}

//********************************************* Table evaluation ***************************************************
try {
  $sql = "CREATE TABLE evaluation(
    user_id INT NOT NULL ,
    recommended_poi_id INT NOT NULL,
    chosen_poi_id INT NOT NULL,
    date date NOT NULL,
    CONSTRAINT fk_userId
          FOREIGN KEY (user_id) 
          REFERENCES user(id)
            ON UPDATE RESTRICT
            ON DELETE CASCADE,
     CONSTRAINT fk_recommended_poi_id
          FOREIGN KEY (recommended_poi_id) 
          REFERENCES poi(id)
            ON UPDATE RESTRICT
            ON DELETE CASCADE,
     CONSTRAINT fk_chosen_poi_id
          FOREIGN KEY (chosen_poi_id) 
          REFERENCES poi(id)
            ON UPDATE RESTRICT
            ON DELETE CASCADE
  )";
  $pdo->exec($sql);
  echo  "*** Table 'evaluation' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'evaluation' already exist <br>";
}
//********************************************* Table transition ***************************************************
try {
  $sql = "CREATE TABLE transition(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    poi_start_id INT NOT NULL,
    poi_end_id INT NOT NULL,
    frequency INT NOT NULL,
     CONSTRAINT fk_poi_start_id
          FOREIGN KEY (poi_start_id) 
          REFERENCES poi(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
     CONSTRAINT fk_poi_end_id
          FOREIGN KEY (poi_end_id) 
          REFERENCES poi(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
  )";
  $pdo->exec($sql);
  echo  "*** Table 'transition' created ! <br>";
} catch (PDOException $e) {
  echo "*** Table 'transition' already exist <br>";
}
