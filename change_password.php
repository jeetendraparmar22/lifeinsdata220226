<?php
error_reporting(0);
// session_start();
$utype = $_SESSION['utype'];
$id = $_SESSION['id'];

include_once('config.php');
include_once('classes/securityHelper.php');
$db = new Database();
$conn = $db->getConnection();

$adminusername = $_SESSION['adminusername'];
if (count($_POST) > 0) {
  // Sanitize session ID
  $session_id = SecurityHelper::sanitizeId($_SESSION['id'] ?? null);
  if ($session_id) {
    // Use prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM subadmin WHERE id=?");
    if ($stmt) {
      $stmt->bind_param("i", $session_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
      
      if ($row && $_POST["currentPassword"] == $row["adminpassword"]) {
        // Sanitize new password
        $newPassword = SecurityHelper::sanitizeString($conn, $_POST["newPassword"]);
        // Use prepared statement for update
        $stmt = $conn->prepare("UPDATE subadmin SET adminpassword=? WHERE id=?");
        if ($stmt) {
          $stmt->bind_param("si", $newPassword, $session_id);
          $stmt->execute();
          $stmt->close();
          $message = "Password Changed";
        }
      } else {
        $message = "Current Password is not correct";
      }
    }
  }
}
?>

<script type="text/javascript">
  function validatePassword() {
    var currentPassword, newPassword, confirmPassword, output = true;

    currentPassword = document.frmChange.currentPassword;
    newPassword = document.frmChange.newPassword;
    confirmPassword = document.frmChange.confirmPassword;

    if (!currentPassword.value) {
      currentPassword.focus();
      document.getElementById("currentPassword").innerHTML = "required";
      output = false;
    } else if (!newPassword.value) {
      newPassword.focus();
      document.getElementById("newPassword").innerHTML = "required";
      output = false;
    } else if (!confirmPassword.value) {
      confirmPassword.focus();
      document.getElementById("confirmPassword").innerHTML = "required";
      output = false;
    }
    if (newPassword.value != confirmPassword.value) {
      newPassword.value = "";
      confirmPassword.value = "";
      newPassword.focus();
      document.getElementById("confirmPassword").innerHTML = " New Password and Confirm Password not same";
      output = false;
    }
    return output;
  }
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



  <main class="app-content">
    <div class="app-title">
      <div>

      </div>

    </div>
    <div class="row" style="margin:50px 0px 0px 50px;">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Change Password</h3>
          <div class="tile-body">
            <form class="form-horizontal" name="frmChange" method="post" action="" onSubmit="return validatePassword()">

              <?php if (isset($message)) {
                echo $message;
              } ?>
              <div class="form-group row">
                <label class="control-label col-md-2">Current Password :</label>
                <div class="col-md-10">
                  <input class="form-control fix-input" type="password" placeholder="Enter Current Password" name="currentPassword">
                </div>
                <span id="currentPassword" class="required"></span>
              </div>
              <div class="form-group row">
                <label class="control-label col-md-2">New Password :</label>
                <div class="col-md-10">
                  <input class="form-control fix-input" type="password" placeholder="Enter New Password" name="newPassword">
                </div>
                <span id="newPassword" class="required"></span>
              </div>
              <div class="form-group row">
                <label class="control-label col-md-2">Confirm Password :</label>
                <div class="col-md-10">
                  <input class="form-control fix-input" type="password" placeholder="Enter Confirm Password" name="confirmPassword">
                </div>
                <span id="confirmPassword" class="required"></span>
              </div>

              <div class="tile-footer">
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                    <button class="btn btn-primary" type="submit" name="submit" value="Submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </main>
  <!-- Essential javascripts for application to work-->
  <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript">
    $('#sl').click(function() {
      $('#tl').loadingBtn();
      $('#tb').loadingBtn({
        text: "Signing In"
      });
    });

    $('#el').click(function() {
      $('#tl').loadingBtnComplete();
      $('#tb').loadingBtnComplete({
        html: "Sign In"
      });
    });

    $('#demoDate').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      todayHighlight: true
    });
    $('#demoDate1').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      todayHighlight: true
    });
    $('#demoDate2').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      todayHighlight: true
    });
    $('#demoDate3').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      todayHighlight: true
    });

    $('#demoSelect').select2();
  </script>
  <!-- Google analytics script-->
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