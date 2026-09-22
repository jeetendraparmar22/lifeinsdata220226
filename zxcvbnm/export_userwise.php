<?php
include_once("header.php");
?>
<style>
  html.js.js body div.wrapper div.structure-row div.right-sec div.content-section div.container-liquid div.row div.col-xs-12 div.sec-box div.contents div.table-box form table.table tbody tr td.col-md-8 div.input-group-btn select.btn.btn-default.dropdown-toggle {
    width: 200px;
  }

  html.js.js body div.wrapper div.structure-row div.right-sec div.content-section div.container-liquid div.row div.col-xs-12 div.sec-box div.contents div.table-box form table.table tbody tr td input.btn.btn-primary.style2 {
    margin: 0px 0px;
  }
</style>
<div class="content-section">
  <div class="container-liquid">
    <div class="row">
      <div class="col-xs-12">
        <div class="sec-box">
          <header>
            <h2 class="heading"> Adminwise Report</h2>
          </header>
          <div class="contents">
            <div class="table-box">


              <form method="post" action="">
                <table class="table">

                  <tbody>
                    <tr>
                      <td class="col-md-8">
                        <div class="input-group-btn">

                          <?php $subadmin = $_REQUEST['subadmin'] ?? "";
                          ?>

                          <select class="btn btn-default dropdown-toggle" name="subadmin">

                            <option value="NULL">Select Admin</option>
                            <?php

                            $select = "SELECT *FROM `subadmin`";
                            $result = mysqli_query($conn, $select);

                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                              <option value="<?php echo $row['adminusername']; ?>"> <?php echo $row['adminusername']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </td>
                      <td><input type="submit" name="submit" value="Export" class="btn btn-primary style2" /> </td>
                    </tr>


                  </tbody>
                </table>
              </form>
            </div>
            <div class="clearfix"></div>
            <?php
            if (isset($_POST['submit'])) {

              if ($_POST['subadmin'] == 'NULL') {

                echo '<script language="javascript">alert("Please Select Admin.");</script>';
              } else {
            ?>
                <tr>
                  <td>
                    <h2>Data List :<a><?php echo $subadmin; ?></a></h2>
                  </td>
                </tr>
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                    <tr>
                      <th>Employee Name</th>
                      <th>Entry</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    //echo $subadmin;
                    $selectadmin = "SELECT *FROM employeedetail WHERE subadmin='$subadmin'";
                    $rs = mysqli_query($conn, $selectadmin);
                    while ($data = mysqli_fetch_array($rs)) {
                    ?>
                      <tr>

                        <td><?php echo $employee = $data['empname'];  ?></td>

                        <td> <?php echo " <a href='export.php?report=" . $data['0'] . "'><img src='images/export_excel.png' /></a>" ?></td>




                      </tr>
                    <?php  } ?>
                  </tbody>
                </table>
            <?php

              }
            } ?>
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