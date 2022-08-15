<?php
// Include config file
require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");
?>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">


      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title "><b>Signup</b></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) ?>" method="POST">
          <div class="form-group">
            <div class="form-group">
              <label for="email_signup">Email:</label>
              <input type="email" class="form-control" placeholder="email@example.com" name="email_signup" value="<?php echo $email_signup ?>" required>
              <small class="text-danger"><?php echo $email_signup_err ?></small>
            </div>
            <div class="form-group">
              <label for="password_signup">Password:</label>
              <input type="password" class="form-control" placeholder="Enter password" name="password_signup" required>
              <small class="text-danger"><?php echo $password_signup_err ?></small>
            </div>
            <div class="form-group">
              <label for="confirm_password_signup">Confirm password:</label>
              <input type="password" class="form-control" placeholder="Enter password confirmation" name="confirm_password_signup" required>
              <small class="text-danger"><?php echo $confirm_password_signup_err ?></small>
            </div>
          </div>


          <!-- Modal footer -->
          <div class="modal-footer">
            <p class="mr-auto mt-auto">You already have an account ? <a data-toggle="modal" data-target="#loginModal" data-dismiss="modal" href="#"> Login now</a>.</p>

            <button type="submit" class="btn" name="signup_btn" style="margin: 0px -5px -5px 0px;border-radius: 50px; background-color: rgb(245, 77, 77);padding: 10px 25px; color: white;">Sign up</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>