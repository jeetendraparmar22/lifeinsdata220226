<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
include_once __DIR__ . '/config.php';
$utype = $_SESSION['utype'];
$_SESSION['inq'] = "";

?>

<script>
  // JavaScript popup window function
  function basicPopup(url) {
    popupWindow = window.open(url, 'popUpWindow', 'height=500,width=700,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')


  }
</script>

<script language="javascript">
  function validate() {
    var chks = document.getElementsByName('checkbox[]');
    var hasChecked = false;
    for (var i = 0; i < chks.length; i++) {
      if (chks[i].checked) {
        hasChecked = true;
        break;
      }
    }
    if (hasChecked == false) {
      alert("Please select at least one.");
      return false;
    }
    return true;
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
    </div>
    <div class="row" style="margin:50px 0px 0px 50px;">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">User Entry</h3>
          <div class="tile-body">
            <?php
            include_once('classes/securityHelper.php');
            $subadmin = $_SESSION['adminusername'] ?? '';
            $subadmin_escaped = SecurityHelper::sanitizeString($conn, $subadmin);
            // Use prepared statement for security
            $stmt = $conn->prepare("SELECT * FROM `employeedetail` WHERE subadmin=?");
            if ($stmt) {
              $stmt->bind_param("s", $subadmin_escaped);
              $stmt->execute();
              $result = $stmt->get_result();
            } else {
              $result = false;
            }
            ?>
            <form class="row" action="entry_list.php" method="get">
              <div class="form-group col-md-4">
                <select class="form-control" id="exampleSelect3" name="inq" style="width:200px;">

                  <option value="selectuser">Select User</option>
                  <?php
                  if ($result) {
                    while ($row = $result->fetch_assoc()) {
                      $emp_id = SecurityHelper::sanitizeId($row['id']);
                      if ($emp_id) {
                  ?>
                        <option value="<?php echo SecurityHelper::escapeHtml($emp_id); ?>"
                          <?= isset($_SESSION['inq']) && $_SESSION['inq'] == $emp_id ? 'selected' : '' ?>>
                          <?php echo SecurityHelper::escapeHtml($row["empname"]); ?>
                        </option>
                  <?php
                      }
                    }
                    if ($stmt) {
                      $stmt->close();
                    }
                  }
                  ?>
                </select>
                <?php
                // $inq = $_SESSION['inq'];
                ?>
              </div>

              <div class="form-group col-md-4 align-self-end">
                <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
              </div>
            </form>

            <?php
            if (isset($_GET['submit'])) {
              if (!isset($_GET['inq']) || $_GET['inq'] == 'selectuser') {
                echo '<script language="javascript">alert("Please Select User Type.");</script>';
              } else {
                // Sanitize and validate ID to prevent SQL injection and ModSecurity issues
                $inq = SecurityHelper::sanitizeId($_GET['inq']);
                if ($inq) {
                  $_SESSION['inq'] = $inq;
                  // Use prepared statement for security
                  $stmt = $conn->prepare("SELECT * FROM employeedetail WHERE id=?");
                  if ($stmt) {
                    $stmt->bind_param("i", $inq);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $stmt->close();
                    if ($row) {
                      echo "Employee Name: " . SecurityHelper::escapeHtml($row['empname']);
            ?>
                      <form id="form_id" name="myform" method="POST" action="delete_all.php" onSubmit="return validate();">
                        <table class="table table-hover table-bordered" id="sampleTable">
                          <thead>
                            <tr>
                              <th>FORM NO</th>
                              <th>RECORD NO</th>
                              <th>INVOICE NO</th>
                              <th>ACTIONS</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            // Use prepared statement for security
                            $stmt = $conn->prepare("SELECT * FROM forms WHERE eid=? AND formno != '' ORDER BY id DESC");
                            if ($stmt) {
                              $stmt->bind_param("i", $inq);
                              $stmt->execute();
                              $res = $stmt->get_result();
                              if ($res && $res->num_rows > 0) {
                                while ($row = $res->fetch_assoc()) {
                                  $form_id = SecurityHelper::sanitizeId($row['id']);
                                  if ($form_id) {
                            ?>
                                    <tr>
                                      <td><input name="checkbox[]" type="checkbox" class="checkbox-item" value="<?= SecurityHelper::escapeHtml($form_id) ?>" /> <?= SecurityHelper::escapeHtml($row['formno']) ?></td>
                                      <td><?= SecurityHelper::escapeHtml($row['record_no']) ?></td>
                                      <td><?= SecurityHelper::escapeHtml($row['invoice_no']) ?></td>
                                      <td>
                                        <a class="btn btn-success" href="viewform.php?id=<?= $form_id ?>">View</a>
                                        <a class="btn btn-danger" href="delete.php?del=<?= $form_id ?>">Delete</a>
                                      </td>
                                    </tr>
                                <?php
                                  }
                                }
                                $stmt->close();
                              } else {
                                ?>
                                <tr>
                                  <td colspan="4">No records found</td>
                                </tr>
                              <?php
                              }
                            } else {
                              ?>
                              <tr>
                                <td colspan="4">Database error</td>
                              </tr>
                            <?php
                            }
                            ?>
                            <tr>
                              <th>
                                <a href="#" onclick="select_all(true); return false;">Select All</a> |
                                <a href="#" onclick="select_all(false); return false;">Unselect All</a><br />
                              </th>
                            </tr>
                          </tbody>
                        </table>
                        <input type="submit" name="delete" value="Delete">
                      </form>
                      <script>
                        function select_all(state) {
                          const checkboxes = document.querySelectorAll('.checkbox-item');
                          checkboxes.forEach(checkbox => {
                            checkbox.checked = state;
                          });
                        }

                        function validate() {
                          const checkboxes = document.querySelectorAll('input[name="checkbox[]"]:checked');
                          if (checkboxes.length === 0) {
                            alert('Please select at least one record to delete.');
                            return false;
                          }
                          return true;
                        }
                      </script>
            <?php
                    }
                  }
                }
              }
            }
            ?>

          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Essential javascripts for application to work-->
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
  <!-- <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

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

    // $('#demoSelect').select2();
  </script>
  <!-- Google analytics script-->

  </body>

  </html>