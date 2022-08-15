 <?php
  // Include config file
  require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");


  ?>


 <html>

 <body>
   <style>
     .manage-btn {
       width: 80%;
       font-family: inherit;
       font-size: 22px;
       font-weight: bold;
     }

     #body {
       margin-bottom: 200px;
     }
   </style>
   <!-- body -->
   <div class="container-fluid mt-4" id="body">
     <div class="row">
       <div class="col-sm-2 ">
         <div class="col-sm-12 mt-4 mx-auto">
           <?php include(INCLUDE_PATH . "/layouts/list-settings.php") ?>
         </div>
       </div>
       <div class="col-sm-9 ml-5">
         <?php if (!isset($_GET["account_id"])) : ?>

           <div class=" text-center">

             <h4 class="text-success">
               <?php echo $change_success; ?>
             </h4>
             <h4 class="text-danger">
               <?php echo $change_err . " <br> "; ?>
             </h4>
           </div>
           <nav class="navbar navbar-expand-sm bg-red navbar-dark justify-content-end" data-aos="fade-up">
             <div class="mr-5">
               <form class="form-inline" method="GET">
                 <input class="form-control mr-sm-2" name="searchInput" id="searchInput" type="text" placeholder="Search" value="<?php echo $searchInput; ?>">

                 <select class="form-control mr-sm-2" id="searchBy" name="searchBy" style="cursor: pointer">
                   <option value="" disabled selected>Search by...</option>
                   <option <?php if ($searchBy == "id") echo "selected"; ?> value="id">ID</option>
                   <option <?php if ($searchBy == "firstName") echo "selected"; ?> value="firstName">First name</option>
                   <option <?php if ($searchBy == "lastName") echo "selected"; ?> value="lastName">Last name</option>
                   <option <?php if ($searchBy == "email") echo "selected"; ?> value="email">Email</option>
                 </select>


                 <button class="btn btn-manage" type="submit">
                   <i class="fa fa-search"></i>
                 </button>
               </form>
             </div>
           </nav>
           <div data-aos="fade-up">
             <table class="table table-hover " style="cursor: pointer">
               <thead class="table-warning">
                 <tr>
                   <th>ID</th>
                   <th>Email</th>
                   <th>First name</th>
                   <th>Last name</th>
                   <th>Birthday</th>
                   <th>Function</th>
                   <th>Phone number</th>
                   <th>Last seen</th>
                   <th></th>
                 </tr>
               </thead>
               <tbody id="usersTable">
                 <?php
                  if (isset($_GET["searchInput"]) && isset($_GET["searchBy"]) && $_GET["searchInput"] != "") {

                    if ($_GET["searchBy"] == "id") {
                      if (!preg_match("/^[0-9]*$/", ($_GET["searchInput"]))) {
                        $userTable = "";
                      } else {
                        $userTable  = $role->search_accounts_ByID($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                      }
                    } else if ($_GET["searchBy"] == "email") {
                      $userTable  = $role->search_accounts_ByEmail($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                    } else if ($_GET["searchBy"] == "firstName") {
                      $userTable  = $role->search_accounts_ByFname($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                    } else if ($_GET["searchBy"] == "lastName") {
                      $userTable  = $role->search_accounts_ByLname($_GET["searchInput"], $roleID, $pageNo, $nRow_pPage);
                    }
                  } else {
                    $userTable = $role->fetch_accounts($roleID, $pageNo, $nRow_pPage);
                  }
                  if ($userTable == "") { ?>
               </tbody>
             </table>
             <?php if ($user->isActive_page("/Dashboard/Manage-mods.php")) : ?>
               <p class=" text-center " style="font-size: 19px">There is no moderators ! </p>
             <?php else :  ?>
               <p class=" text-center " style="font-size: 19px">There is no users ! </p>
             <?php endif; ?>
           <?php } else {
                    foreach ($userTable as $row) {
                      echo '<form method="GET">';
                      echo " <tr>";
                      echo "<td>" . $row['id'] . "</td> ";
                      echo "<td>" . $row['email'] . "</td> ";
                      if ($row['Fname'] == NULL) {
                        echo '<td class="text-secondary font-italic">No information</td> ';
                      } else {
                        echo "<td>" . $row['Fname'] . "</td> ";
                      }
                      if ($row['Lname'] == NULL) {
                        echo '<td class="text-secondary font-italic">No information</td> ';
                      } else {
                        echo "<td>" . $row['Lname'] . "</td> ";
                      }
                      if ($row['age'] == NULL) {
                        echo '<td class="text-secondary font-italic">No information</td> ';
                      } else {
                        echo "<td>" . date_format(date_create($row['age']), "d-m-Y") . "</td> ";
                      }
                      if ($row['function'] == NULL) {
                        echo '<td class="text-secondary font-italic">No information</td> ';
                      } else {
                        echo "<td>" . $row['function'] . "</td> ";
                      }
                      if ($row['phone'] == NULL) {
                        echo '<td class="text-secondary font-italic">No information</td> ';
                      } else {
                        echo "<td>" . $row['phone'] . "</td> ";
                      }
                      echo "<td>" . $row['last_seen'] . "</td>";
                      if ($role->isAdmin($_SESSION["id"]) || $user->isActive_page("/SmartTraveller/Dashboard/Manage-users.php")) {
                        echo '<td><button class="btn btn-manage" name="account_id" value="' . $row['id'] . '">Manage</button></td>';
                      }
                      echo "</tr>";
                      echo "</form>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                  }
            ?>
           <?php if ($total_pages != 1) : ?>
             <ul class="pagination pagination-dashboard justify-content-center mt-4">
               <li class="page-item <?php if ($pageNo <= 1) {
                                      echo "disabled";
                                    } ?>"><a class="page-link" href="<?php if ($pageNo <= 1) {
                                                                        echo '#';
                                                                      } else {
                                                                        if (isset($_GET["searchInput"]) && isset($_GET["searchBy"])) {
                                                                          echo "?searchInput=" . $_GET["searchInput"] . "&searchBy=" . $_GET["searchBy"] . "&pageNo=" . ($pageNo - 1);
                                                                        } else {
                                                                          echo "?pageNo=" . ($pageNo - 1);
                                                                        }
                                                                      } ?>">Previous</a></li>
               <?php
                for ($page = 1; $page <= $total_pages; $page++) : ?>
                 <li class="page-item <?php if ($page == $pageNo) {
                                        echo "active";
                                      } ?>"><a class="page-link" href="<?php if (isset($_GET["searchInput"]) && isset($_GET["searchBy"])) {
                                                                          echo "?searchInput=" . $_GET["searchInput"] . "&searchBy=" . $_GET["searchBy"] . "&pageNo=" . $page;
                                                                        } else {
                                                                          echo "?pageNo=" . $page;
                                                                        } ?>"><?php echo $page ?></a></li>
               <?php endfor; ?>
               <li class="page-item <?php if ($pageNo >= $total_pages) {
                                      echo "disabled";
                                    } ?>"><a class="page-link" href="<?php if ($pageNo == $total_pages) {
                                                                        echo '#';
                                                                      } else {
                                                                        if (isset($_GET["searchInput"]) && isset($_GET["searchBy"])) {
                                                                          echo "?searchInput=" . $_GET["searchInput"] . "&searchBy=" . $_GET["searchBy"] . "&pageNo=" . ($pageNo + 1);
                                                                        } else {
                                                                          echo "?pageNo=" . ($pageNo + 1);
                                                                        }
                                                                      } ?>">Next</a></li>

             </ul>
           <?php endif; ?>
           </div>


           <?php else : if ($role->isAdmin($_SESSION["id"]) || $user->isActive_page("/Dashboard/Manage-users.php")) : ?>

             <div class=" text-center">

               <h4 class="text-success">
                 <?php echo $change_success; ?>
               </h4>
               <h4 class="text-danger">
                 <?php echo $change_err . " <br> "; ?>
               </h4>
             </div>
             <div class="form-group" data-aos="fade-right">

               <div class="form-group">
                 <label for="ID">ID:</label>
                 <input type="number" class="form-control " name="ID" value="<?php echo $account_id ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="email">Email:</label>
                 <input type="text" class="form-control" name="email" value="<?php echo $account_email ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="Fname">First name:</label>
                 <input type="text" class="form-control <?php if ($account_Fname == NULL) {
                                                          echo "text-secondary font-italic";
                                                        } ?>" name="Fname" value="<?php if ($account_Fname == NULL) {
                                                                      echo "No information";
                                                                    } else {
                                                                      echo $account_Fname;
                                                                    } ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="Lname">Last name:</label>
                 <input type="text" class="form-control <?php if ($account_Lname == NULL) {
                                                          echo "text-secondary font-italic";
                                                        } ?>" name="Lname" value="<?php if ($account_Lname == NULL) {
                                                                      echo "No information";
                                                                    } else {
                                                                      echo $account_Lname;
                                                                    } ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="age">Birthday:</label>
                 <input type="date" class="form-control <?php if ($account_age == NULL) {
                                                          echo "text-secondary font-italic";
                                                        } ?>" name="age" value="<?php echo $account_age ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="function">Function:</label>
                 <input type="text" class="form-control <?php if ($account_function == NULL) {
                                                          echo "text-secondary font-italic";
                                                        } ?>" name="function" value="<?php if ($account_function == NULL) {
                                                                        echo "No information";
                                                                      } else {
                                                                        echo $account_function;
                                                                      } ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="phone">Phone number:</label>
                 <input type="text" class="form-control <?php if ($account_phone == NULL) {
                                                          echo "text-secondary font-italic";
                                                        } ?>" name="phone" value="<?php if ($account_phone == NULL) {
                                                                      echo "No information";
                                                                    } else {
                                                                      echo $account_phone;
                                                                    } ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="role">Role:</label>
                 <input type="text" class="form-control" name="role" value="<?php echo ucfirst(strtolower($account_role)); ?>" readonly>
               </div>
               <div class="form-group">
                 <label for="last_seen">Last seen:</label>
                 <input type="text" class="form-control" name="last_seen" value="<?php echo $account_last_seen ?>" readonly>
               </div>
             </div>
             <br>
             <br>

             <div class="row">
               <div class="col-sm-6 ">
                 <button class="btn btn-danger btn-block mx-auto py-3 manage-btn" data-toggle="modal" data-target="#ban_confirm_modal" id="ban-btn">Ban account</button>
               </div>
               <div class="col-sm-6 ">
                 <?php if ($role->isAdmin($_SESSION["id"])) : ?>
                   <button class="btn btn-manage btn-block mx-auto py-3 manage-btn" data-toggle="modal" data-target="#change_role_modal" id="changeRole-btn">Change role</button>
                 <?php endif; ?>
               </div>
             </div>
           <?php endif; ?>
         <?php endif; ?>
       </div>
     </div>
   </div>
 </body>

 <!-- <script>
   var userSel;
   $('#userSel').change(function() {
     userSel = $(this).val();
   });

   function searchTbl() {
     var input, filter, table, tr, td, i, txtValue;
     input = document.getElementById('userInput');
     filter = input.value.toUpperCase();
     table = document.getElementById('usersTable');
     tr = table.getElementsByTagName('tr');
     if (userSel == "id") {
       for (i = 0; i < tr.length; i++) {
         td = tr[i].getElementsByTagName('td')[0];
         if (td) {
           txtValue = td.textContent || td.innerText;
           if (txtValue.toUpperCase().indexOf(filter) > -1) {
             tr[i].style.display = '';
           } else {
             tr[i].style.display = 'none';
           }
         }
       }
     } else if (userSel == "name") {
       for (i = 0; i < tr.length; i++) {
         td = tr[i].getElementsByTagName('td')[3];
         if (td) {
           txtValue = td.textContent || td.innerText;
           if (txtValue.toUpperCase().indexOf(filter) > -1) {
             tr[i].style.display = '';
           } else {
             tr[i].style.display = 'none';
           }
         }
       }
     } else if (userSel == "email") {
       for (i = 0; i < tr.length; i++) {
         td = tr[i].getElementsByTagName('td')[1];
         if (td) {
           txtValue = td.textContent || td.innerText;
           if (txtValue.toUpperCase().indexOf(filter) > -1) {
             tr[i].style.display = '';
           } else {
             tr[i].style.display = 'none';
           }
         }
       }
     }
   }
 </script> -->

 </html>