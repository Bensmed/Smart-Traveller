<?php
if (isset($_GET["logout"])) {
  $user->logout();
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- ======= Header ======= -->
<header id="header" class="<?php if ($user->isActive_page("/index.php")) {
                              echo "fixed-top";
                            } ?>">
  <div class="container d-flex">

    <div class="logo mr-auto">

      <div class="row">
        <a href="/"><img src="assets/img/logo.png" alt="" class="img-fluid mr-3"></a>
        <h1><a href="/" style="color: #94c045;">Smart Traveller</a></h1>
      </div>
    </div>
    <nav class="nav-menu d-none d-lg-block">
      <ul>
        <li class="<?php if ($user->isActive_page("/index.php") || $user->isActive_page("/Home.php")) {
                      echo "active";
                    } ?>"><a href="/">Home</a></li>


        <?php if (!$user->is_loggedIn()) : ?>
          <li class="<?php if ($user->isActive_page("/Search.php")) {
                        echo "active";
                      } ?>"><a href="#">Search</a></li>
          <li class="<?php if ($user->isActive_page("/Services.php")) {
                        echo "active";
                      } ?>"><a href="/#services">Services</a></li>

          <li><a href="#footer">Contact</a></li>
          <li class="get-started"><a data-toggle="modal" href="#" data-target="#loginModal">Login</a></li>

        <?php else : ?>
          <li class="<?php if ($user->isActive_page("/Recommendation.php")) {
                        echo "active";
                      } ?>"><a href="/Recommendation">Recommendation</a></li>
          <li class="<?php if ($user->isActive_page("/Search.php")) {
                        echo "active";
                      } ?>"><a href="#">Search</a></li>
          <li class="<?php if ($user->isActive_page("/History.php")) {
                        echo "active";
                      } ?>"><a href="/History">History</a></li>
          <li class="drop-down"><a href="#">More</a>
            <ul>
              <?php if ($role->getRoleID($_SESSION["id"]) != 3) : ?>
                <li><a class="bg-green" id="nav-dashboard" href="/Dashboard/Manage-users">Dashboard</a></li>
              <?php endif; ?>
              <li><a href="/Profile">Profile</a></li>
              <li><a href="/#services">Services</a></li>
              <li><a href="#footer">Contact</a></li>
            </ul>
          </li>

          <li>
            <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="GET">
              <button id="logout-btn" type="submit" name="logout">Logout</button>
            </form>
          </li>

        <?php endif; ?>
      </ul>
    </nav><!-- .nav-menu -->

  </div>
</header><!-- End Header -->




</html>