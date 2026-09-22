<?php
error_reporting(0);

// Include config FIRST for session handling
include_once('config.php');
include_once('classes/securityHelper.php');

class SubadminHandler
{
  private $dbConnection;

  public function __construct($connection)
  {
    $this->dbConnection = $connection;
  }

  public function getSubadminLoginDate($adminUsername)
  {
    // Escape the input to prevent SQL injection
    $adminUsername = $this->dbConnection->real_escape_string($adminUsername);

    // Execute the query
    $query = "SELECT * FROM subadmin WHERE adminusername = '$adminUsername'";
    $result = $this->dbConnection->query($query);

    // Fetch data if available
    if ($result && $result->num_rows > 0) {
      return $result->fetch_assoc();
    }
    return null;
  }

  public function parseLoginDate($date)
  {
    if (empty($date)) {
      return [
        "day" => date('d'),
        "year" => date('Y'),
        "month" => date('m'),
        "previousMonth" => date('m') - 1,
      ];
    }
    $parsedDate = date_parse_from_format("Y-m-d", $date);
    return [
      "day" => $parsedDate["day"] ?? date('d'),
      "year" => $parsedDate["year"] ?? date('Y'),
      "month" => $parsedDate["month"] ?? date('m'),
      "previousMonth" => ($parsedDate["month"] ?? date('m')) - 1,
    ];
  }
}

// Initialize the database connection
include_once('config.php');
$db = new Database();
$connection = $db->getConnection();

// Retrieve session data
$utype = $_SESSION['utype'] ?? null;
$id = $_SESSION['id'] ?? null;
$subadmin = $_SESSION['adminusername'] ?? null;

if ($subadmin) {
  // Handle subadmin details
  $subadminHandler = new SubadminHandler($connection);

  $subadminDetails = $subadminHandler->getSubadminLoginDate($subadmin);

  if ($subadminDetails) {
    $loginDate = $subadminDetails['login_date'];

    $parsedDate = $subadminHandler->parseLoginDate($loginDate);

    $day = $parsedDate['day'];
    $year = $parsedDate['year'];
    $month = $parsedDate['month'];
    $month1 = $parsedDate['previousMonth'];

    // Now you can use $day, $year, $month, and $month1 as needed
  } else {
    echo "Subadmin details not found.";
  }
} else {
  echo "Session data missing for adminusername.";
}

// Close the database connection
// $db->closeConnection();
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<?php
include_once('header.php');

?>
<style type="text/css" media="print">
  body {
    visibility: hidden;
    display: none
  }
</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:../../partials/_sidebar.html -->


  <?php
  include_once('subadminsidebar.php');
  ?>
  <main class="app-content">
    <div class="app-title">
      <div>

        <h3 style="margin:10px 0px 0px 50px;"><i class="fa fa-th-list"></i> Employee Detail</h3>

      </div>

    </div>
    <div class="row" style="margin:50px 0px 0px 50px;">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <?php
            // Handle form submission (POST method - safe from ModSecurity)
            if (isset($_POST['update'])) {
              // Get and sanitize employee ID from POST (preferred) or session (fallback)
              $up = SecurityHelper::sanitizeId($_POST['employee_id'] ?? null);
              if (!$up) {
                $up = SecurityHelper::sanitizeId($_SESSION['enterid'] ?? null);
              }

              if (!$up) {
                echo "<div class='alert alert-danger'>Invalid employee ID.</div>";
              } else {
                // Sanitize all POST inputs
                $username = SecurityHelper::sanitizeString($connection, $_POST['username'] ?? '');
                $password = SecurityHelper::sanitizeString($connection, $_POST['password'] ?? '');
                $address = SecurityHelper::sanitizeString($connection, $_POST['address'] ?? '');
                $email = SecurityHelper::sanitizeEmail($connection, $_POST['email'] ?? '');
                $mobile = SecurityHelper::sanitizeString($connection, $_POST['mobile'] ?? '');
                $contact = SecurityHelper::sanitizeString($connection, $_POST['contact'] ?? '');
                $status = SecurityHelper::sanitizeString($connection, $_POST['status'] ?? 'n');

                // Validate status value
                if (!in_array($status, ['y', 'n'])) {
                  $status = 'n';
                }

                // Handle adware admin special fields
                if (isset($_SESSION['adminusername']) && $_SESSION['adminusername'] == 'adware') {
                  $active_date1 = SecurityHelper::sanitizeString($connection, $_POST['active_date'] ?? '');
                  $active_time = SecurityHelper::sanitizeString($connection, $_POST['active_time'] ?? '00:00:00');
                  $deactive_date1 = SecurityHelper::sanitizeString($connection, $_POST['deactive_date'] ?? '');
                  $deactive_time = SecurityHelper::sanitizeString($connection, $_POST['deactive_time'] ?? '00:00:00');

                  // Convert date format from DD-MM-YYYY to YYYY-MM-DD
                  $active_date = '';
                  $deactive_date = '';
                  if (!empty($active_date1)) {
                    $date_parts = explode('-', $active_date1);
                    if (count($date_parts) == 3) {
                      $active_date = date("Y-m-d", strtotime($date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]));
                    }
                  }
                  if (!empty($deactive_date1)) {
                    $date_parts = explode('-', $deactive_date1);
                    if (count($date_parts) == 3) {
                      $deactive_date = date("Y-m-d", strtotime($date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]));
                    }
                  }

                  $to_date = '2022-07-01';

                  // Use prepared statement for better security
                  $stmt = $connection->prepare("UPDATE `employeedetail` SET empname=?, username=?, password=?, address=?, email=?, mobile=?, contact=?, status=?, to_date=?, active_time=?, deactive_time=?, active_date=?, deactive_date=? WHERE id=?");
                  if ($stmt) {
                    $stmt->bind_param("sssssssssssssi", $username, $username, $password, $address, $email, $mobile, $contact, $status, $to_date, $active_time, $deactive_time, $active_date, $deactive_date, $up);
                    $update = $stmt->execute();
                    $stmt->close();
                  } else {
                    $update = false;
                  }
                } else {
                  // Regular admin update (no special fields)
                  $stmt = $connection->prepare("UPDATE `employeedetail` SET empname=?, username=?, password=?, address=?, email=?, mobile=?, contact=?, status=? WHERE id=?");
                  if ($stmt) {
                    $stmt->bind_param("ssssssssi", $username, $username, $password, $address, $email, $mobile, $contact, $status, $up);
                    $update = $stmt->execute();
                    $stmt->close();
                  } else {
                    $update = false;
                  }
                }

                if ($update) {
                  // Clear the session enterid
                  unset($_SESSION['enterid']);
                  echo "<script>window.location.href='emp_list.php';</script>";
                  exit;
                } else {
                  echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($connection->error, ENT_QUOTES, 'UTF-8') . "</div>";
                }
              }
            }

            // Handle edit mode - Keep original structure with action=edit but sanitize properly
            $arr = null;
            if (isset($_GET['id'])) {
              // Check action parameter - only allow 'edit' to prevent ModSecurity issues
              // Use strict comparison and only allow specific safe values
              $action = isset($_GET['action']) ? trim($_GET['action']) : '';

              // Only proceed if action is exactly 'edit' (whitelist approach)
              if ($action === 'edit') {
                // Sanitize and validate ID
                $e = SecurityHelper::sanitizeId($_GET['id']);

                if ($e) {
                  // Store sanitized ID in session
                  $_SESSION['enterid'] = $e;

                  // Use prepared statement to fetch employee data
                  $stmt = $connection->prepare("SELECT * FROM `employeedetail` WHERE id=?");
                  if ($stmt) {
                    $stmt->bind_param("i", $e);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result && $result->num_rows > 0) {
                      $arr = $result->fetch_assoc();
                    }
                    $stmt->close();
                  }
                }
              }
            }

            // Show form only if we have employee data (edit mode)
            if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'edit' && $arr) {
            ?>

              <form class="form-horizontal" action="" method="post">
                <div class="form-group row">
                  <label class="control-label col-md-2">User Name:</label>
                  <div class="col-md-10">
                    <input class="form-control fix-input" type="text" placeholder="Enter full User Name" name="username" value="<?php echo SecurityHelper::escapeHtml($arr['username'] ?? ''); ?>" required="required">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-2">Pass word:</label>
                  <div class="col-md-10">
                    <input class="form-control fix-input" type="password" placeholder="Enter Password" name="password" value="<?php echo SecurityHelper::escapeHtml($arr['password'] ?? ''); ?>" required="required">
                  </div>
                </div>



                <?php

                if ($_SESSION['adminusername'] == 'adware') {
                ?>

                  <div class="form-group row">
                    <label class="control-label col-md-2">Active Date:</label>
                    <div class="col-md-10">
                      <input class="form-control fix-input" type="text" placeholder="DD-MM-YYYY" name="active_date" required="required" value="<?php
                                                                                                                                                $active_date = $arr['active_date'] ?? '';
                                                                                                                                                if (!empty($active_date)) {
                                                                                                                                                  echo SecurityHelper::escapeHtml(date("d-m-Y", strtotime($active_date)));
                                                                                                                                                }
                                                                                                                                                ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-2">Active Time:</label>
                    <div class="col-md-10">
                      <select style="height:35px; width:175px;" name="active_time">
                        <?php
                        $saved_active_time = $arr['active_time'] ?? '00:00:00';
                        for ($i = 0; $i < 24; ++$i) {
                          $t = sprintf("%02d", $i);
                          $time_value = $t . ':00:00';
                          $selected = ($time_value == $saved_active_time) ? 'selected="selected"' : '';
                          echo '<option value="' . SecurityHelper::escapeHtml($time_value) . '" ' . $selected . '>' . SecurityHelper::escapeHtml($time_value) . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-2">Deactive Date:</label>
                    <div class="col-md-10">
                      <input class="form-control fix-input" type="text" placeholder="DD-MM-YYYY" name="deactive_date" required="required" value="<?php
                                                                                                                                                  $deactive_date = $arr['deactive_date'] ?? '';
                                                                                                                                                  if (!empty($deactive_date)) {
                                                                                                                                                    echo SecurityHelper::escapeHtml(date("d-m-Y", strtotime($deactive_date)));
                                                                                                                                                  }
                                                                                                                                                  ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-2">Deactive Time:</label>
                    <div class="col-md-10">
                      <select style="height:35px; width:175px;" name="deactive_time">
                        <?php
                        $saved_deactive_time = $arr['deactive_time'] ?? '00:00:00';
                        for ($i = 0; $i < 24; ++$i) {
                          $t = sprintf("%02d", $i);
                          $time_value = $t . ':00:00';
                          $selected = ($time_value == $saved_deactive_time) ? 'selected="selected"' : '';
                          echo '<option value="' . SecurityHelper::escapeHtml($time_value) . '" ' . $selected . '>' . SecurityHelper::escapeHtml($time_value) . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>


                <?php }

                ?>

                <div class="form-group row">
                  <label class="control-label col-md-2">Address:</label>
                  <div class="col-md-10">
                    <input class="form-control fix-input" type="text" placeholder="Enter Address" name="address" required="required" value="<?php echo SecurityHelper::escapeHtml($arr['address'] ?? ''); ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-2">Email:</label>
                  <div class="col-md-10">
                    <input class="form-control fix-input" type="email" placeholder="Enter Email" name="email" required="required" value="<?php echo SecurityHelper::escapeHtml($arr['email'] ?? ''); ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-2">Mobile:</label>
                  <div class="col-md-10">
                    <input class="form-control fix-input" type="text" placeholder="Enter Mobile No" name="mobile" required="required" value="<?php echo SecurityHelper::escapeHtml($arr['mobile'] ?? ''); ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-2">Contact:</label>
                  <div class="col-md-10">
                    <input class="form-control fix-input" type="text" placeholder="Enter Contact" name="contact" required="required" value="<?php echo SecurityHelper::escapeHtml($arr['contact'] ?? ''); ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleSelect6" class="control-label col-md-2">Status:</label>
                  <div class="col-md-10">
                    <select class="form-control fix-input" id="exampleSelect6" name="status">
                      <option value="y" <?php if (($arr['status'] ?? '') == "y") echo 'selected="selected"'; ?>>Active</option>
                      <option value="n" <?php if (($arr['status'] ?? '') == "n") echo 'selected="selected"'; ?>>Deactive</option>
                    </select>
                  </div>
                </div>
                <div class="tile-footer">
                  <div class="row">
                    <div class="col-md-8 col-md-offset-3">
                      <button class="btn btn-primary" type="submit" name="update"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                    </div>
                  </div>
                </div>
              </form>

            <?php } else {
            ?>
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Name</th>

                    <th>UserName</th>
                    <th>Password</th>
                    <th>Login Status</th>

                    <th>Active Time</th>
                    <th>Deactive Time</th>
                    <th>Active Date</th>
                    <th>Deactive Date</th>

                    <th>Action</th>
                  </tr>
                </thead>


                <tbody>
                  <?php
                  $subadmin = $_SESSION['adminusername'] ?? '';

                  // Sanitize subadmin username
                  $subadmin = SecurityHelper::sanitizeString($connection, $subadmin);

                  // Use prepared statement for security
                  $stmt = $connection->prepare("SELECT * FROM `employeedetail` WHERE subadmin=?");
                  if ($stmt) {
                    $stmt->bind_param("s", $subadmin);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_assoc()) {
                      $employee_id = SecurityHelper::sanitizeId($row['id']);
                      if (!$employee_id) continue; // Skip invalid IDs
                  ?>
                      <tr>
                        <td><?php echo SecurityHelper::escapeHtml($row['empname'] ?? ''); ?></td>
                        <td><?php echo SecurityHelper::escapeHtml($row['username'] ?? ''); ?></td>
                        <td><?php echo SecurityHelper::escapeHtml($row['password'] ?? ''); ?></td>
                        <td><?php
                            if (($row['status'] ?? '') == 'y') {
                              echo 'Active';
                            } else {
                              echo 'Deactive';
                            }
                            ?></td>
                        <td><?php echo SecurityHelper::escapeHtml($row['active_time'] ?? ''); ?></td>
                        <td><?php echo SecurityHelper::escapeHtml($row['deactive_time'] ?? ''); ?></td>
                        <td><?php echo SecurityHelper::escapeHtml($row['active_date'] ?? ''); ?></td>
                        <td><?php echo SecurityHelper::escapeHtml($row['deactive_date'] ?? ''); ?></td>
                        <td>
                          <?php
                          // Keep original format with action=edit
                          // Use htmlspecialchars for URL to prevent ModSecurity issues while maintaining original design
                          $edit_url = 'emp_list.php?id=' . $employee_id . '&action=edit';
                          echo "<a class='btn btn-info' href='" . htmlspecialchars($edit_url, ENT_QUOTES, 'UTF-8') . "' class='btn btn-success'><i class='halflings-icon white edit'></i> Edit</a> 										 ";
                          ?>
                        </td>
                      </tr>
                  <?php
                    }
                    $stmt->close();
                  } else {
                    echo "<tr><td colspan='9' class='text-center'>Error loading employee data.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>

            <?php }
            ?>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <!-- End custom js for this page-->
  </body>

  </html>