<?php
include_once("header.php");
include_once 'classes/subAdmin.php';

$update = $_GET['update'];
$selectupdate = mysqli_query($conn, "SELECT *FROM `subadmin` WHERE id='$update'");

$row = mysqli_fetch_array($selectupdate);

$adminusername1 = $row['adminusername'];
$admin_todate = $row['login_date'];


// Format to DD-MM-YYYY H:i:s
$activeDateTime =  date('d-m-Y H:i:s', strtotime($row['active_date']));
$deactiveDateTime =  date('d-m-Y H:i:s', strtotime($row['deactive_date']));

?>
<div class="content-section">
  <div class="container-liquid">
    <div class="row">
      <div class="col-xs-12">
        <div class="sec-box">
          <header>
            <h2 class="heading">Update Admin Detail</h2>
          </header>
          <div class="contents">
            <div class="table-box">

              <form method="post" action="">
                <table class="table">
                  <thead>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="col-md-4">USERNAME:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" placeholder="Username" class="form-control" name="adminusername" value="<?php echo $row['adminusername']; ?>" />
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">PASSWORD:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Password" name="adminpassword" value="<?php echo $row['adminpassword']; ?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">ADDRESS:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Address" name="address" value="<?php echo $row['address']; ?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">EMAIL ID:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Email Id" name="emailid" value="<?php echo $row['adminemail']; ?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">Number Of Users:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Number Of Users" name="nou" value="<?php echo $row['no_of_user']; ?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">Active Date & Time (DD-MM-YYYY HH:MM:SS):</td>
                      <td class="col-md-8">
                        <div class="input-group">

                          <input type="text" class="form-control" name="active_date_time" value="<?= $activeDateTime; ?>" placeholder="DD-MM-YYYY HH:MM:SS" required>

                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">Deactive Date & Time (DD-MM-YYYY HH:MM:SS):</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" name="deactive_date_time" value="<?= $deactiveDateTime; ?>" placeholder="DD-MM-YYYY HH:MM:SS" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">Select time Zone:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <select style="height:35px; width:175px;" name="timezone">
                            <?php
                            // Get all timezones from PHP
                            $timezones = timezone_identifiers_list();

                            // Assume $selected_timezone holds the value from the database
                            $selected_timezone = isset($row['timezone']) ? $row['timezone'] : 'Asia/Kolkata';

                            // Display a default "Select Timezone" option
                            echo '<option value="">Select Timezone</option>';

                            // Loop through each timezone and create an option
                            foreach ($timezones as $timezone) {
                              // Check if the current timezone matches the database value
                              $selected = ($timezone === $selected_timezone) ? 'selected' : '';
                              echo "<option value=\"$timezone\" $selected>$timezone</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </td>
                    </tr>



                    <tr>
                      <td class="col-md-4">Login Status</td>
                      <td class="col-md-8">
                        <div class="input-group-btn">
                          <select class="btn btn-default dropdown-toggle" name="status">

                            <option value="y" <?php if ($row['status'] == "y") echo 'selected="selected"'; ?>>Active</option>
                            <option value="n" <?php if ($row['status'] == "n") echo 'selected="selected"'; ?>>Deactive</option>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>

                      <td colspan="8"><input type="submit" name="update" value="Update Detail" class="btn btn-primary style2" style="margin-left:340px;" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>

            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Row End -->
  </div>
</div>
<!-- Content Section End -->
</div>
<!-- Right Section End -->
</div>
</div>
</body>

</html>