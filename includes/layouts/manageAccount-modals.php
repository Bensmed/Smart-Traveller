<!-- Change role Modal -->
<div class="modal fade" id="change_role_modal">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Change role</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) . "?account_id=" . $account_id; ?>" method="POST">
          <div class="form-group">
            <div class="form-group">
              <label for="role">Role:</label>
              <select class="form-control mr-sm-2" name="roleID" style="cursor: pointer">
                <option value="3" <?php if ($account_role == "USER") {
                                    echo "Selected";
                                  } ?>>User</option>
                <option value="2" <?php if ($account_role == "MODERATOR") {
                                    echo "Selected";
                                  } ?>>Moderator</option>
                <option value="1" <?php if ($account_role == "ADMIN") {
                                    echo "Selected";
                                  } ?>>Admin</option>
              </select>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-green" name="change_role_submit" style="border-radius: 20px; ">Change</button>
            <button type="submit" class="btn btn-cancel" data-dismiss="modal" style="border-radius: 20px; ">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Ban confirm Modal -->
<div class="modal fade" id="ban_confirm_modal">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ban confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <form action="<?php echo htmlspecialchars(preg_replace("/\.php/", "", $_SERVER["PHP_SELF"])) . "?account_id=" . $account_id; ?>" method="POST">

          <p style="font-size: 17px">Are you sure you want to ban this account permanently?</p>
          <br>
          <small class="text-danger">If you confirm, this account will no longer exist !</small>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-green" name="ban_submit" style="border-radius: 20px; ">Yes</button>
            <button type="submit" class="btn btn-cancel " data-dismiss="modal" style="border-radius: 20px; ">No</button>
          </div>
        </form>
      </div>
    </div>
  </div>