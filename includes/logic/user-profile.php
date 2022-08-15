<?php
redirectIfNeeded();

// Check if the user is already logged in, if no then redirect him to index page
if (!$user->is_loggedin()) {
  $user->redirect("/");
  exit;
}

if (isset($_GET["logout"])) {
  $user->logout();
}

//Initialisation of variables
$email = $Fname = $Lname = $password  =  $age = $function = $phone = $new_email = $new_Fname = $new_Lname  = $new_age = $new_function = $new_phone = $current_password = $new_password = $confirm_new_password  = $email_err = $Fname_err = $Lname_err = $password_err = $new_phone_operator = $new_phone_number =
  $age_err = $function_err = $phone_err = $new_email_err = $new_Fname_err = $new_Lname_err  = $new_age_err = $new_function_err = $new_phone_err = $current_password_err = $new_password_err = $confirm_new_password_err = $change_err = $change_success =  "";

//fetch profile data
if ($row = $user->fetch_profile()) {
  $email = $row["email"];
  $Fname = $new_Fname = $row["Fname"];
  $Lname = $new_Lname = $row["Lname"];
  $age = $new_age = $row["age"];
  $function = $new_function = $row["function"];
  $phone = $row["phone"];
  $password = "password";
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Change personal informations form submitted
  if (isset($_POST["changePersonal_info_submit"])) {
    //check if First name is valid
    if (empty(trim($_POST["new_Fname"])) || strlen(trim($_POST["new_Fname"])) < 3 || strlen(trim($_POST["new_Fname"])) > 30) {
      $new_Fname_err = "Please enter a valid name.";
    }
    $new_Fname = ucfirst(strtolower(trim($_POST["new_Fname"])));

    //check if Last name is valid
    if (empty(trim($_POST["new_Lname"])) || strlen(trim($_POST["new_Lname"])) < 3 || strlen(trim($_POST["new_Lname"])) > 30) {
      $new_Lname_err = "Please enter a valid name.";
    }
    $new_Lname = ucfirst(strtolower(trim($_POST["new_Lname"])));

    //check if birthday is valid
    if (empty(trim($_POST["new_age"]))) {
      $new_age_err = "Enter your age.";
    } else if (date("Y") - date("Y", strtotime(trim($_POST["new_age"]))) <= 16) {

      $new_age_err = "Your age must be at least 16 years old.";
    } else {
      $new_age = $_POST["new_age"];
    }

    //check if function is selected
    if (empty(trim($_POST["new_function"]))) {
      $new_function_err = "Select a function.";
    } else {
      $new_function = trim($_POST["new_function"]);
    }


    //Check for no errors
    if (empty($new_Fname_err) && empty($new_Lname_err) && empty($new_age_err) && empty($new_function_err)) {
      //Check if nothing is modified
      if ($new_Fname == $Fname && $new_Lname == $Lname && $new_age == $age && $new_function == $function) {
        //Do nothing ...
      } else {

        if ($user->change_personalInfo($new_Fname, $new_Lname, $new_age, $new_function)) {
          $change_success = "Your information has been updated successfully ! ";
          $Fname = $new_Fname;
          $Lname = $new_Lname;
          $age = $new_age;
          $function = $new_function;
        } else {
          $change_err = "Something went wrong ! Please try again later ... ";
        }
      }
    }
  }

  //Change phone number form submitted
  if (isset($_POST["change_phone_submit"])) {

    //check if the phone is valid
    $new_phone_operator = $_POST["new_phone_operator"];

    if (empty(trim($_POST["new_phone_operator"])) || empty(trim($_POST["new_phone"])) || strlen(trim($_POST["new_phone"])) != 8 || !preg_match("/^[0-9]*$/", (trim($_POST["new_phone"])))) {
      $new_phone_err = "Please enter a valid phone number.";
    } else {
      if ($user->check_phone_exist($new_phone_operator . trim($_POST["new_phone"])) != "") {
        $new_phone_err = "Phone number already exist.";
      } else {
        $new_phone = trim($_POST["new_phone"]);
        $new_phone_number = $new_phone_operator . $new_phone;
      }
    }
    //if there is no errors THEN change phone
    if (empty($new_phone_err)) {
      if ($user->change_phone($new_phone_number)) {
        $change_success = "Your phone number has been updated successfully ! ";
        $phone = $new_phone_number;
        $new_phone =  $new_phone_number = "";
      } else {
        $change_err = "Something went wrong ! Please try again later ... ";
      }
    }
  }

  //Change password form submitted
  if (isset($_POST["new_password_submit"])) {

    if (empty(trim($_POST["current_password"]))) {
      $current_password_err = "Please enter your current password.";
    } else {
      $current_password = trim($_POST["current_password"]);
      if ($user->isCorrect_password($current_password)) {
        if (empty(trim($_POST["new_password"]))) {
          $new_password_err = "Enter new password Please.";
        } else if (strlen(trim($_POST["new_password"])) < 6) {
          $new_password_err = "Password must have atleast 6 characters.";
        } else {
          if (empty(trim($_POST["confirm_new_password"]))) {
            $confirm_new_password_err = "Enter new password confirmation.";
          } else {
            if (trim($_POST["confirm_new_password"]) != trim($_POST["new_password"])) {
              $confirm_new_password_err = "Password does not match.";
            } else {
              if ($current_password == trim($_POST["new_password"])) {
                $new_password_err = "Enter new password Please.";
              } else {
                $new_password = trim($_POST["new_password"]);
              }
            }
          }
        }
      } else {
        $current_password_err = "Wrong password. Please try again!";
      }
    }

    if (empty($current_password_err) && empty($new_password_err) && empty($confirm_new_password_err)) {

      if ($user->change_password($current_password, $new_password)) {
        $change_success = "Password has been changed successfully.";
      } else {
        $change_err = "Something went wrong! Please try again later.";
      }
    }
  }
}
