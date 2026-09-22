<?php
error_reporting(0);

include_once('config.php');
include_once('classes/securityHelper.php');
$db = new Database();
$conn = $db->getConnection();


// session_start();
if (!isset($_SERVER['HTTP_REFERER'])) {
  // redirect them to your desired location
  header('location:../error.php');
  exit;
}

$utype = $_SESSION['utype'];
$id = $_SESSION['id'];

$subadmin = $_SESSION['adminusername'];
$select = "SELECT *FROM `employeedetail` WHERE subadmin='$subadmin'";
$result = mysqli_query($conn, $select);
$count = mysqli_num_rows($result);
$select1 = mysqli_query($conn, "SELECT *FROM subadmin WHERE adminusername='$subadmin'");
$row = mysqli_fetch_array($select1);

$active_date_time = $row['active_date'];
$to_date = date('Y-m-d', strtotime($active_date_time));

$nou = $row['no_of_user'];

if (isset($_POST['insert'])) {
  // $empn ame = $_POST['empname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $contact = $_POST['contact'];
  $status = $_POST['status'];

  $subadmin = $_SESSION['adminusername'];
  $username_check = SecurityHelper::sanitizeString($conn, $_POST["username"]);
  $result = mysqli_query($conn, "SELECT count(*) FROM employeedetail WHERE username='" . $username_check . "'");
  $row = mysqli_fetch_row($result);

  $user_count = $row[0];
  if ($user_count > 0) {
    echo '<script language="javascript">alert("Username Already Taken."); window.location.href="add_newemp.php";</script>';
    exit;
  }


  if ($count >= $nou) {
    echo '<script language="javascript">alert("You Can not Add  User");window.location.href="add_newemp.php";</script>';
  } else {
    $subadmin_escaped = SecurityHelper::sanitizeString($conn, $subadmin);
    $query = mysqli_query($conn, "SELECT *FROM subadmin WHERE adminusername='$subadmin_escaped'");
    $rs = mysqli_fetch_array($query);

    // Sanitize all POST inputs
    $username = SecurityHelper::sanitizeString($conn, $_POST['username']);
    $password = SecurityHelper::sanitizeString($conn, $_POST['password']);
    $address = SecurityHelper::sanitizeString($conn, $_POST['address']);
    $email = SecurityHelper::sanitizeEmail($conn, $_POST['email']);
    $mobile = SecurityHelper::sanitizeString($conn, $_POST['mobile']);
    $contact = SecurityHelper::sanitizeString($conn, $_POST['contact']);
    $status = SecurityHelper::sanitizeString($conn, $_POST['status']);

    if ($_SESSION['adminusername'] == 'adware') {
      $active_time = SecurityHelper::sanitizeString($conn, $_POST['active_time']);
      $deactive_time = SecurityHelper::sanitizeString($conn, $_POST['deactive_time']);
      $active_date1 = SecurityHelper::sanitizeString($conn, $_POST['active_date']);
      $active_date = date("Y-m-d", strtotime($active_date1));
      $deactive_date1 = SecurityHelper::sanitizeString($conn, $_POST['deactive_date']);
      $deactive_date = date("Y-m-d", strtotime($deactive_date1));
    }

    if ($_SESSION['adminusername'] != 'adware') {
      $active_time = $rs['active_time'];
      $deactive_time = $rs['deactive_time'];
      $active_date = $rs['active_date'];
      $deactive_date = $rs['deactive_date'];
      $timezone = $rs['timezone'];
    }

    $ins = mysqli_query($conn, "insert into `employeedetail`(empname,username,password,address,email,mobile,contact,utype,to_date,status,subadmin,active_time, deactive_time,active_date,deactive_date,timezone)
                               values('$username','$username','$password','$address','$email','$mobile','$contact','employee','$to_date','$status','$subadmin_escaped','$active_time','$deactive_time','$active_date','$deactive_date','$timezone')");

    if (mysqli_error($conn)) {
      echo "Error:" . mysqli_error($conn);
    } else {
      echo '<script language="javascript">alert("User Detail Succesfully Added.");</script>';
    }
  }
}
?>

<?php
if (isset($_GET['id'])) {
  // Sanitize and validate ID to prevent SQL injection and ModSecurity issues
  $delete_id = SecurityHelper::sanitizeId($_GET['id']);
  if ($delete_id) {
    // Use prepared statement for security
    $stmt = $conn->prepare("DELETE FROM employeedetail WHERE id=?");
    if ($stmt) {
      $stmt->bind_param("i", $delete_id);
      $stmt->execute();
      $stmt->close();
      echo '<script language="javascript">window.location.href="emp_list.php";</script>';
    }
  }
}
//include_once("adminheader.php"); 

$subadmin = $_SESSION['adminusername'];

$selectdate = mysqli_query($conn, "SELECT *FROM subadmin WHERE adminusername='$subadmin'");
$row1 = mysqli_fetch_array($selectdate);
$date = $row1['login_date'];
$d = date_parse_from_format("Y-m-d", $date);
$day = $d["day"];
$year = $d["year"];
$month = $d["month"];
$month1 = $month - 1;
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(function() {
    var date = new Date();
    var currentMonth = "<?php echo $month1 ?>";
    var currentDate = "<?php echo $day ?>";
    var currentYear = "<?php echo $year ?>";
    $("#datepicker").datepicker({
      minDate: 0,
      maxDate: new Date(currentYear, currentMonth, currentDate)
    });
  });
</script>
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
  <div class="row" style="margin:50px 0px 0px 100px;">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Employee Details</h3>
        <div class="tile-body">
          <form class="form-horizontal" action="add_newemp.php" method="post">
            <div class="form-group row">
              <label class="control-label col-md-2">User Name:</label>
              <div class="col-md-10">
                <input class="form-control fix-input" type="text" placeholder="Enter full User Name" name="username" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2">Password: &nbsp;</label>
              <div class="col-md-10">
                <input class="form-control fix-input" type="password" placeholder="Enter Password" name="password" required>
              </div>
            </div>


            <?php

            if ($_SESSION['adminusername'] == 'adware') {
            ?>

              <div class="form-group row">
                <label class="control-label col-md-2">Active Date:</label>
                <div class="col-md-10">
                  <input class="form-control fix-input" type="text" placeholder="DD-MM-YYYY" name="active_date" required>
                </div>
              </div>




              <div class="form-group row">
                <label class="control-label col-md-2">Active Time:</label>
                <div class="col-md-10">
                  <select style="height:35px; width:175px;" name="active_time">
                    <?php

                    //$save_active_time = $row['active_time'];


                    // date_default_timezone_set('Asia/Kolkata');


                    for ($i = 0; $i < 24; ++$i) {
                      $t = date("H", strtotime($i . ":00:00"));

                      echo '<option value="' . $t . ':00:00">' . $t . ':00:00</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label col-md-2">Deactive Date:</label>
                <div class="col-md-10">
                  <input class="form-control fix-input" type="text" placeholder="DD-MM-YYYY" name="deactive_date" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label col-md-2">Deactive Time:</label>
                <div class="col-md-10">
                  <select style="height:35px; width:175px;" name="deactive_time">
                    <?php

                    //$save_active_time = $row['active_time'];

                    // date_default_timezone_set('Asia/Kolkata');


                    for ($i = 0; $i < 24; ++$i) {
                      $t = date("H", strtotime($i . ":00:00"));

                      echo '<option value="' . $t . ':00:00">' . $t . ':00:00</option>';
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
                <input class="form-control fix-input" type="text" placeholder="Enter Address" name="address" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2">Email:</label>
              <div class="col-md-10">
                <input class="form-control fix-input" type="email" placeholder="Enter Email" name="email" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2">Mobile:</label>
              <div class="col-md-10">
                <input class="form-control fix-input" type="text" placeholder="Enter Mobile No" name="mobile" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2">Contact:</label>
              <div class="col-md-10">
                <input class="form-control fix-input" type="text" placeholder="Enter Contact" name="contact" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleSelect6" class="control-label col-md-2">Status:</label>
              <div class="col-md-10">
                <select class="form-control fix-input" id="exampleSelect6" name="status">
                  <option value="y">Active</option>
                  <option value="n">Deactive</option>
                </select>
              </div>
            </div>
            <div class="tile-footer">
              <div class="row">
                <div class="col-md-8 col-md-offset-3">
                  <button class="btn btn-primary" type="submit" name="insert"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>
                </div>
              </div>
            </div>
          </form>
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





  </body>

  </html>