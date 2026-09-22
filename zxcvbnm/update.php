<?php
include_once("header.php");
include_once '../classes/securityHelper.php';
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

              <?php
              // Sanitize and validate ID from action parameter to prevent SQL injection and ModSecurity issues
              $update = SecurityHelper::sanitizeId($_GET['action'] ?? null);
              $row = null;
              if ($update) {
                // Use prepared statement for security
                $stmt = $conn->prepare("SELECT * FROM `employeedetail` WHERE id=?");
                if ($stmt) {
                  $stmt->bind_param("i", $update);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                  }
                  $stmt->close();
                }
              }
              if (!$row) {
                die("Employee not found");
              }
              ?>
              <form method="post" action="">
                <table class="table">
                  <thead>
                  </thead>
                  <tbody>



                    <tr>
                      <td class="col-md-4">Login Status</td>
                      <td class="col-md-8">
                        <div class="input-group-btn">
                          <select class="btn btn-default dropdown-toggle" name="status">
                            <option value="1" <?php if ($row['flag'] == "1") echo 'selected="selected"'; ?>>1</option>
                            <option value="0" <?php if ($row['status'] == "0") echo 'selected="selected"'; ?>>0</option>
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

              <?php

              if (isset($_POST['update'])) {
                // Sanitize input
                $status = SecurityHelper::sanitizeId($_POST['status'] ?? null);
                if ($status !== null && $update) {
                  // Use prepared statement for security
                  $stmt = $conn->prepare("UPDATE `employeedetail` SET flag=? WHERE id=?");
                  if ($stmt) {
                    $stmt->bind_param("ii", $status, $update);
                    $stmt->execute();
                    $stmt->close();
                    echo "<script>window.location.href='UDR.php';</script>";
                  }
                }
              }
              ?>
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