<?php

redirectIfNeeded();

// Check if the user is already logged in, if yes then redirect him to home page
if ($user->is_loggedin()) {
  $user->redirect("/Home");
  exit;
}


// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["login_btn"])) {
    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter email.";
    } else {
      $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter your password.";
    } else {
      $password = trim($_POST["password"]);
    }


    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
      if ($response = $user->login($email, $password)) {
        if ($response == "email_err") {
          $email_err = "No account found with that email.";
        } else if ($response == "password_err") {
          $password_err = "The password you entered was not valid.";
        } else {
          // Password is correct, so start a new session
          session_start();
          // Store data in session variables
          $_SESSION["loggedin"] = true;
          $_SESSION["id"] = $response;
          $_SESSION["role"] = $role->getRoleID($_SESSION["id"]);
          // last seen time
          $user->last_seen();
          // Redirect user to Home page
          $user->redirect("/Home");
        }
      }
    }
  }
}
