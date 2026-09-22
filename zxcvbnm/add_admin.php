<?php
include_once("header.php");
include_once 'classes/subAdmin.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type='text/javascript'>
  $(document).ready(function() {
    $('#datetimepicker1').datetimepicker();
  });
</script>
<script type='text/javascript'>
  $(document).ready(function() {
    $('#datetimepicker2').datetimepicker();
  });
</script>
<div class="content-section">
  <div class="container-liquid">
    <div class="row">
      <div class="col-xs-12">
        <div class="sec-box">
          <header>
            <h2 class="heading">Add Admin Detail</h2>
          </header>
          <div class="contents">
            <div class="table-box">
              <form method="post" id="add-admin-form">
                <table class="table">
                  <thead>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="col-md-4">USERNAME:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" placeholder="Username" class="form-control" name="adminusername" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">PASSWORD:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="password" class="form-control" placeholder="Password" name="adminpassword" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">ADDRESS:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Address" name="address" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">EMAIL ID:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Email Id" name="emailid" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">Number Of Users:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Number Of Users" name="nou" required>
                        </div>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td class="col-md-4">Login Date:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="DD-MM-YYYY" name="to_date" required>
                        </div>
                      </td>
                    </tr> -->

                    <tr>
                      <td class="col-md-4">Active Date & Time (DD-MM-YYYY HH:MM:SS):</td>
                      <td class="col-md-8">
                        <div class="input-group">

                          <input type="text" class="form-control" name="active_date_time" placeholder="DD-MM-YYYY HH:MM:SS" required>

                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-md-4">Deactive Date & Time (DD-MM-YYYY HH:MM:SS):</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <input type="text" class="form-control" name="deactive_date_time" placeholder="DD-MM-YYYY HH:MM:SS" required>
                        </div>
                      </td>
                    </tr>


                    <!-- Time zone listing -->
                    <tr>
                      <td class="col-md-4">Select time Zone:</td>
                      <td class="col-md-8">
                        <div class="input-group">
                          <select style="height:35px; width:175px;" name="timezone">
                            <?php
                            // Get all timezones from PHP
                            $timezones = timezone_identifiers_list();

                            // Display a default "Select Timezone" option
                            echo '<option value="Asia/Kolkata">Select Timezone</option>';

                            // Loop through each timezone and create an option
                            foreach ($timezones as $timezone) {
                              echo "<option value=\"$timezone\">$timezone</option>";
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
                            <option value="y">Active</option>
                            <option value="n">Deactive</option>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="8"><input type="submit" name="submit" value="Add Detail" class="btn btn-primary style2" style="margin-left:340px;" /></td>
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