<?php
// session_start();
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
          <h3 class="tile-title">Datewise Report</h3>
          <div class="tile-body">
            <form class="form-horizontal" method="post">

              <div class="form-group row">
                <label class="control-label col-md-2 report_date">Type Date :</label>
                <div class="col-md-3">
                  <input class="form-control" type="text" placeholder="DD/MM/YYYY" name="date" style="width:250px;">
                </div>
                <div class="col-md-3" style="margin-left:200px;">
                  <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
    $selectdate1 = $_POST['date'] ?? "";
    $date = str_replace('/', '-', $selectdate1);
    $selectdate = date("Y-m-d", strtotime($date)); ?>


    <?php
    if (isset($_POST['submit'])) {
    ?>
      <p style="text-align:left; padding:50px 0px 0px 50px; font-weight:bold">ENTRY REPORT ON:<?php echo $selectdate1; ?></p><br />
      <table class="table table-striped table-bordered bootstrap-datatable datatable" style="margin:50px 0px 0px 50px;">
        <thead>



          <tr>
            <th>Employee Name:</th>
            <th>Total Forms</th>


          </tr>
        </thead>

        <?php

        $subadmin = $_SESSION['adminusername'];
        $select = "SELECT *FROM `employeedetail` WHERE subadmin='$subadmin'";
        $result = mysqli_query($conn, $select);
        $usercount = mysqli_num_fields($result);
        while ($user = mysqli_fetch_array($result)) {
        ?>


          <tr>
            <td><?php echo $user['empname']; ?></td>

            <?php
            $userid = $user['id'];
            $selectentry = mysqli_query($conn, "SELECT *FROM forms WHERE eid ='$userid' AND post_date ='$selectdate' AND formno !=''");
            $count = mysqli_num_rows($selectentry);
            ?>
            <td><?php echo $count; ?></td>
          </tr>
        <?php  } ?>

        <table>

        <?php }
        ?>









  </main>
  <!-- Essential javascripts for application to work-->

  <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
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
    $('#demoDate8').datepicker({
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