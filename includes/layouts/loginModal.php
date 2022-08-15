<?php
// Include config file
require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");
?>


<!-- Login Modal -->
<div class=" modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Login</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="POST">
          <div class="form-group">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" placeholder="email@example.coms" name="email" value="<?php echo $email ?>" required>
              <small class="text-danger"><?php echo $email_err ?></small>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" placeholder="Password" name="password" required>
              <small class="text-danger"><?php echo $password_err ?></small>
            </div>
          </div>


          <!-- Modal footer -->
          <div class="modal-footer">
            <p class="mr-auto mt-auto">Don't have an account? <a data-toggle="modal" data-target="#signupModal" data-dismiss="modal" href="#"> Sign up now</a>.</p>

            <button type="submit" class="btn" name="login_btn" style="margin-bottom: -5px;border-radius: 50px; background-color: #94c045;padding: 10px 30px; color: white;">Login</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>