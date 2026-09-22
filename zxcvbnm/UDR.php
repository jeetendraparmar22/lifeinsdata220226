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

  /* General button styles */
  .action-btn {
    display: inline-block;
    text-decoration: none;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 5px;
    font-size: 14px;
    transition: background-color 0.3s ease;
  }

  /* Edit button styles */
  .edit-btn {
    background-color: #007bff;
    /* Blue color */
  }

  .edit-btn:hover {
    background-color: #0056b3;
  }

  /* View button styles */
  .view-btn {
    background-color: #17a2b8;
    /* Light blue color */
  }

  .view-btn:hover {
    background-color: #117a8b;
  }

  /* Icon styles */
  .action-icon {
    font-size: 16px;
    margin-right: 5px;
    vertical-align: middle;
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

                          <select class="btn btn-default dropdown-toggle" name="subadmin">
                            <?php $subadmin = $_REQUEST['subadmin'];

                            ?>

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
                      <td><input type="submit" name="submit" value="View Report" class="btn btn-primary style2" /> </td>
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

                      <th>Total Entry</th>
                      <th>Login Status</th>
                      <th>Action</th>
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
                        <?php

                        $eid = $data['id'];
                        $healthentry = mysqli_query($conn, "SELECT * FROM `forms` WHERE eid='$eid'");
                        $entrycount = mysqli_num_rows($healthentry);
                        ?>

                        <td> <?php echo $entrycount; ?></td>



                        <td><?php if ($data['flag'] == '1') { ?>
                            <img src="images/offline.png" />
                          <?php } else { ?>
                            <img src="images/online.png" />
                          <?php }
                          ?>
                        </td>

                        <td>
                          <!-- Edit Button -->
                          <a href="update.php?action=<?php echo $data['0']; ?>" class="action-btn edit-btn" title="Edit">
                            <span class="action-icon">&#9998;</span> <!-- Unicode for a pencil -->
                            Edit
                          </a>

                          <!-- View Button -->
                          <a href="view_data.php?id=<?php echo $data['0']; ?>" class="action-btn view-btn" title="View" target="_blank">
                            <span class="action-icon">&#128065;</span> <!-- Unicode for an eye -->
                            View
                          </a>
                        </td>

                      </tr>
                    <?php  } ?>
                  </tbody>

                </table>
                <button class="btn btn-danger deleteBtn" data-id="<?= $subadmin; ?>">Delete Users Data</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.deleteBtn').on('click', function() {
      const subAdmin = $(this).data('id'); // Get the ID from the button's data attribute
      if (confirm("Are you sure you want to delete this forms?")) {
        window.location.href = `delete_user_form.php?subadmin=${subAdmin}`; // Redirect with ID
      }
    });
  });
</script>
</body>

</html>