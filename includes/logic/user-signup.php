<?php

redirectIfNeeded();

// Check if the user is already logged in, if yes then redirect him to home page
if ($user->is_loggedin()) {
  $user->redirect("/Home");
  exit;
}

// Define variables and initialize with empty values
$email_signup  = $password_signup = $confirm_password_signup =  "";
$email_signup_err  = $password_signup_err = $confirm_password_signup_err = "";
$err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["signup_btn"])) {
    if (empty(trim($_POST["email_signup"]))) {
      $email_signup_err = "Please enter email";
    } else {
      //Check if email_signup is available
      if ($user->check_email_exist(trim($_POST["email_signup"])) != "") {
        $email_signup_err = "Email already exist.";
      } else {
        $email_signup = trim($_POST["email_signup"]);
      }
    }


    //check if password_signup is valid
    if (empty(trim($_POST["password_signup"]))) {
      $password_signup_err = "Enter your password.";
    } else if (strlen(trim($_POST["password_signup"])) < 6) {
      $password_signup_err = "The password must have atleast 6 characters.";
    } else {
      if (empty(trim($_POST["confirm_password_signup"]))) {
        $confirm_password_signup_err = "Enter password confirmation.";
      } else {
        if (trim($_POST["confirm_password_signup"]) != trim($_POST["password_signup"])) {
          $confirm_password_signup_err = "password does not match.";
        } else {
          $password_signup = trim($_POST["password_signup"]);
        }
      }
    }


    //if there is no errors THEN register
    if (empty($email_signup_err) && empty($password_signup_err)  && empty($confirm_password_signup_err)) {
      //Save current date
      $last_seen = date("Y-m-d H:i:s");

      if ($user->register($email_signup, $password_signup, $last_seen)) {


        if ($response = $user->login($email_signup, $password_signup)) {

          session_start();
          // Store data in session variables
          $_SESSION["loggedin"] = true;
          $_SESSION["id"] = $response;
          $_SESSION["role"] = $role->getRoleID($_SESSION["id"]);
          // Redirect user to Home page
          $user->redirect("/Home");
        }
      } else {
        $err = "Something went wrong! Please try again later...";
      }
    }
  }
}
