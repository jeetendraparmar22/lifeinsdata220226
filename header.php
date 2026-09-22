<?php

// Keep database and session details out of the production response.
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);


// Include config first so session is started and timezone is set before anything else
include_once(__DIR__ . '/config.php');

// Initialize Database connection
$db = new Database();
$conn = $db->getConnection();

// Retrieve session variables
$utype = $_SESSION['utype'] ?? null;

$id = $_SESSION['id'] ?? null;
$curempname = $_SESSION['empname'] ?? null;
$adminusername = $_SESSION['adminusername'] ?? null;

// Session timeout check — must run after DB is ready so we can reset the flag
$timeout = 1200;
if (isset($_SESSION['timeout'])) {
  $duration = time() - (int)$_SESSION['timeout'];
  if ($duration > $timeout) {
    if (!empty($id) && !empty($utype)) {
      $flagId = (int)$id;
      if ($utype === 'employee') {
        $conn->query("UPDATE `employeedetail` SET flag = '1' WHERE id = $flagId");
      } elseif ($utype === 'subadmin') {
        $conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $flagId");
      }
    }
    session_destroy();
    header("location:index.php");
    exit;
  }
}
$_SESSION['timeout'] = time();

// Handle updates based on user type
class UserFlagHandler
{
  private $dbConnection;

  public function __construct($connection)
  {
    $this->dbConnection = $connection;
  }

  public function updateFlag($tableName, $idColumn, $id)
  {
    $query = "UPDATE `$tableName` SET flag = '0', last_action_time = NOW() WHERE `$idColumn` = $id";
    if (!$this->dbConnection->query($query)) {
      throw new Exception("Failed to update flag: " . $this->dbConnection->error);
    }

    return true;
  }
}

if ($utype && $id) {
  $flagHandler = new UserFlagHandler($conn);

  if ($utype === 'employee') {
    $flagHandler->updateFlag('employeedetail', 'id', $id);
  } elseif ($utype === 'subadmin') {
    $flagHandler->updateFlag('subadmin', 'id', $id);
  }
}

// Close the database connection
// $db->closeConnection();
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php if ($utype == 'subadmin') {
          ?>
    <?php echo $cruser = $adminusername ?? '';
          } ?>
    <?php if ($utype == 'employee') {
    ?>
    <?php echo $cruser1 = $curempname ?? '';
    } ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

  <style type="text/css" media="print">
    body {
      visibility: hidden;
      display: none
    }
  </style>



  <!--captch code start-->

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
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="#">Life Insurance</a>
        <a class="navbar-brand brand-logo-mini" href="#"></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <?php
          if ($utype == 'employee') {

          ?>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">

              </a>

              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">

                <a class="dropdown-item">
                  <div class="item-thumbnail">
                    <div class="item-icon bg-success">
                      <i class="ti-info-alt mx-0"></i>
                    </div>
                  </div>

                </a>
              </div>
            </li>
          <?php
          }
          ?>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <?php

              if ($utype == 'subadmin') { ?>
                Welcome,<br /><?php echo $cruser = $adminusername ?? ''; ?>

              <?php
              } else { ?>

                Welcome,<br /><?php echo $cruser1 = $curempname ?? '';
                            } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

              <?php
              if ($utype == 'subadmin') { ?>
                <a class="dropdown-item" href="change_password.php">
                  <i class="ti-settings text-primary"></i>
                  Change Password
                </a>
              <?php  } else { ?>

                <a class="dropdown-item" href="reset_password1.php">
                  <i class="ti-settings text-primary"></i>
                  Change Password
                </a>
              <?php }

              if ($utype == 'subadmin') { ?>



                <a class="dropdown-item" href="LO.php">
                  <i class="ti-power-off text-primary"></i>
                  Logout
                </a>
              <?php } else {
              ?>

                <a class="dropdown-item" href="logout.php">
                  <i class="ti-power-off text-primary"></i>
                  Logout
                </a>
              <?php } ?>
            </div>
          </li>



        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>