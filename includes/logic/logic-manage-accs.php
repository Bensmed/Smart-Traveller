<?php
// Include config file
require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");

redirectIfNeeded();

// Check if the user is already logged in, if no then redirect him to index page
if (!$user->is_loggedin()) {
  $user->redirect("/");
  exit;
}

$account_id = $account_email = $account_Fname = $account_Lname = $account_age = $account_function = $account_phone  = $account_role = $account_last_seen = $change_success = $change_err = "";

$searchInput = $searchBy = "";

//pagination
if ($user->isActive_page("/Dashboard/Manage-mods.php")) {
  $roleID = 2;
} else  if ($user->isActive_page("/Dashboard/Manage-users.php")) {
  $roleID = 3;
}
$nRow_pPage = 10;

if (isset($_GET["searchInput"]) && isset($_GET["searchBy"]) && $_GET["searchInput"] != "") {
  $searchInput = $_GET["searchInput"];
  if ($_GET["searchBy"] == "id") {
    $searchBy = "id";
    $total_pages = ceil($role->count_search_Accounts_byID($_GET["searchInput"]) / $nRow_pPage);
  } else if ($_GET["searchBy"] == "email") {
    $searchBy = "email";
    $total_pages = ceil($role->count_search_Accounts_byemail($_GET["searchInput"]) / $nRow_pPage);
  } else if ($_GET["searchBy"] == "firstName") {
    $searchBy = "firstName";
    $total_pages = ceil($role->count_search_Accounts_byFname($_GET["searchInput"]) / $nRow_pPage);
  } else if ($_GET["searchBy"] == "lastName") {
    $searchBy = "lastName";
    $total_pages = ceil($role->count_search_Accounts_byLname($_GET["searchInput"]) / $nRow_pPage);
  }
} else {
  $total_pages = ceil($role->count_Accounts_Of($roleID) / $nRow_pPage);
}

if (isset($_GET['pageNo'])) {
  $pageNo = $_GET['pageNo'];
} else {
  $pageNo = 1;
}
/** */

if (isset($_GET["account_id"])) {

  $account_id = $_GET["account_id"];

  if ($row = $user->fetch_UserInfo($account_id)) {
    $account_email = $row["email"];
    $account_Fname = $row["Fname"];
    $account_Lname = $row["Lname"];
    $account_age = $row["age"];
    $account_function = $row["function"];
    $account_phone = $row["phone"];
    $account_role = $role->getRole($account_id);
    $account_last_seen = $row["last_seen"];
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST["change_role_submit"])) {

    $change_roleID = $_POST["roleID"];

    if ($role->changeRole($account_id, $change_roleID)) {
      $account_role = $role->getRole($account_id);
      $change_success = "The role of this account has been changed successfully.";
    } else {
      $change_err = "Oops! something went wrong .. Please try later!";
    }
  }
  if (isset($_POST["ban_submit"])) {
    if ($user->delete_user($account_id)) {
      $user->redirect("Manage-users?Ban_success");
    } else {
      $change_err = "Oops! something went wrong .. Please try later!";
    }
  }
}
if (isset($_GET["Ban_success"])) {
  $change_success = "Account has been banned successfully.";
}
