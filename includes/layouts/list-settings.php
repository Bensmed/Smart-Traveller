<?php
// Include config file
require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="https://smart-traveller.000webhostapp.com/assets/css/style.css" />
</head>

<body>
  <div class="list-group ">
    <?php if ($role->isAdmin($_SESSION["id"]) || $role->getRoleID($_SESSION["id"]) == 2) : ?>


      <a href="Manage-users" class="list-group-item list-group-item-action <?php if ($user->isActive_page("/Dashboard/Manage-users.php")) {
                                                                              echo "active";
                                                                            } ?> ">Manage users</a>

      <a href="Manage-mods" class="list-group-item list-group-item-action <?php if ($user->isActive_page("/Dashboard/Manage-mods.php")) {
                                                                            echo "active";
                                                                          } ?>"><?php if ($role->isAdmin($_SESSION["id"])) {
                                                                                  echo "Manage moderators ";
                                                                                } else {
                                                                                  echo "Moderators list";
                                                                                } ?></a>

      <a href="Admins-list" class="list-group-item list-group-item-action <?php if ($user->isActive_page("/Dashboard/Admins-list.php")) {
                                                                            echo "active";
                                                                          } ?>">Admins list</a>
    <?php endif; ?>
  </div>
</body>

</html>