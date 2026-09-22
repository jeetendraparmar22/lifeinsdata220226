<?php
// session_start();
include_once("check_session.php");

$query1 = "SELECT deactive_date FROM `employeedetail` WHERE id =" . $_SESSION['id'];
$rs = mysqli_query($conn, $query1);

$data = mysqli_fetch_array($rs);

$to_date = $data['deactive_date'] ?? "";
$tz = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
$today = (new DateTime('now', new DateTimeZone($tz)))->format('Y-m-d');

// Define the number of records per page
$records_per_page = 1;

// Get the current page from the URL, if not set default to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

// Calculate the offset
$offset = ($current_page - 1) * $records_per_page;
$id = $_SESSION['id'];
// Get the total number of records
$total_records_query = "SELECT COUNT(*) as total FROM forms WHERE eid='$id' AND formno !=''";
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch records for the current page
$sel = "SELECT * FROM forms WHERE eid='$id' AND formno !='' ORDER BY id DESC";
$res = mysqli_query($conn, $sel);

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('body').on("cut copy paste", function(e) {
      e.preventDefault();
    });
  });
  $(document).ready(function() {
    $('input').on("cut copy paste", function(e) {
      e.preventDefault();
    });
  });

  $(document).ready(function() {
    $('textarea').on("cut copy paste", function(e) {
      e.preventDefault();
    });
  });



  $(document).ready(function() {
    $("body").on("contextmenu", function(e) {
      return false;
    });
  });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
  /* Custom Pagination CSS */
  .pagination {
    display: flex;
    justify-content: right;
    list-style: none;
    padding: 0;
    margin-top: 20px;
  }

  .pagination li {
    margin: 0 5px;
  }

  .pagination a {
    text-decoration: none;
    padding: 8px 12px;
    color: #007bff;
    border: 1px solid #007bff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
  }

  .pagination a:hover,
  .pagination .active {
    background-color: #007bff;
    color: #fff;
  }

  .pagination .disabled {
    pointer-events: none;
    color: #ccc;
    border: 1px solid #ccc;
  }

  /* General styling for icon links */
  .icon-link {
    display: inline-block;
    color: #007bff;
    /* Bootstrap primary color */
    text-decoration: none;
    /* Remove underline */
    font-size: 16px;
    /* Adjust icon size */
    margin-right: 10px;
    /* Add spacing between icons */
    transition: color 0.2s ease;
    /* Smooth hover effect */
  }

  /* Hover effect */
  .icon-link:hover {
    color: #0056b3;
    /* Darker shade on hover */
  }

  /* Align icons centrally */
  .icon-link i {
    vertical-align: middle;
  }
</style>


<?php
include_once('header.php');

?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:../../partials/_sidebar.html -->

  <?php

  include_once('sidebar.php');

  ?>

  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Completed Forms</h4>
              <p class="card-description">

              </p>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Form No</th>
                    <th>Record No</th>
                    <th>Invoice No</th>
                    <th>Date of Purchase</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_array($res)) { ?>
                    <tr>
                      <td><?php echo $row['formno']; ?></td>
                      <td><?php echo $row['record_no']; ?></td>
                      <td><?php echo $row['invoice_no']; ?></td>
                      <td><?php echo $row['demoDate']; ?></td>
                      <td>
                        <a href="viewform.php?id=<?php echo $row[0]; ?>" class="icon-link view-link" title="View">
                          <i class="bi bi-eye"></i>
                        </a>
                        <a href="update_entry.php?id=<?php echo $row[0]; ?>" class="icon-link edit-link" title="Edit">
                          <i class="bi bi-pencil"></i>
                        </a>
                      </td>


                    </tr>
                  <?php } ?>
                </tbody>
              </table>

              <!-- Pagination Links -->
              <!-- <ul class="pagination">
                <li class="<?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
                  <a href="?page=<?php echo $current_page - 1; ?>">Previous</a>
                </li>

                <?php
                // Calculate the range of page numbers to display
                $start_page = max(1, $current_page - 1);
                $end_page = min($total_pages, $current_page + 1);

                // Show the page numbers
                for ($i = $start_page; $i <= $end_page; $i++) {
                  echo '<li><a class="' . ($i == $current_page ? 'active' : '') . '" href="?page=' . $i . '">' . $i . '</a></li>';
                }

                // Show "..." if more pages exist
                if ($end_page < $total_pages) {
                  echo '<li><a href="#">...</a></li>';
                }
                ?>

                <li class="<?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>">
                  <a href="?page=<?php echo $current_page + 1; ?>">Next</a>
                </li>
              </ul> -->
            </div>
          </div>
        </div>



      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->

    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<!-- End custom js for this page-->
</body>

</html>