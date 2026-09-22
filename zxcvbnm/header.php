<?php

if (!isset($_SERVER['HTTP_REFERER'])) {
  header('location:../error.php');
  exit;
}

include_once('../config.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_SESSION['adminusername'])) {
} else {
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php if (isset($_SESSION['adminusername'])) {
            echo $_SESSION['adminusername'];
          } ?></title>
  <link href="assets/css/style.css" rel="stylesheet" media="screen" />
  <link href="assets/css/bootstrap.css" rel="stylesheet" media="screen" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--// Javascript //-->
  <script type="text/javascript" src="assets/js/jquery.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery.accordion.js"></script>
  <script type="text/javascript" src="assets/js/jquery.custom-scrollbar.min.js"></script>
  <script type="text/javascript" src="assets/js/icheck.min.js"></script>
  <script type="text/javascript" src="assets/js/selectnav.min.js"></script>
  <script type="text/javascript" src="assets/js/functions.js"></script>
</head>

<body>
  <div class="wrapper">
    <div class="structure-row">
      <!-- Sidebar Start -->
      <aside class="sidebar">
        <div class="sidebar-in">
          <!-- Sidebar Header Start -->
          <header>
            <!-- Logo Start -->
            <div class="logo"> <a href=""><img src="assets/images/logo.png" alt="Adminise" /></a> </div>
            <!-- Logo End -->
            <!-- Toggle Button Start -->
            <a href="#" class="togglemenu">&nbsp;</a>
            <!-- Toggle Button End -->
            <div class="clearfix"></div>
          </header>
          <!-- Sidebar Header End -->
          <!-- Sidebar Navigation Start -->
          <nav class="navigation">
            <ul class="navi-acc" id="nav2">
              <li> <a href="add_admin.php" class="loginoptions">Add Admin</a> </li>
              <li><a href="export_userwise.php" class="pages">Export Userwise</a></li>
              <li> <a href="admin_detail.php" class="loginoptions">Admin Detail</a> </li>
              <li> <a href="UDR.php" class="pages">Admin User Data Report </a> </li>
            </ul>
            <div class="clearfix"></div>
          </nav>
          <!-- Sidebar Navigation End -->
          <!-- Shadow Start -->
          <span class="shadows"></span>
          <!-- Shadow End -->
        </div>
      </aside>
      <!-- Sidebar End -->
      <!-- Right Section Start -->
      <div class="right-sec">
        <!-- Right Section Header Start -->
        <header>
          <!-- User Section Start -->
          <div class="user">
            <figure> <a href="#"></a> </figure>
            <div class="welcome">
              <p>Welcome</p>
              <h5><a href="#"> <?php if (isset($_SESSION['adminusername'])) {

                                  echo $_SESSION['adminusername'];
                                } ?> </a></h5>
            </div>
          </div>
          <!-- User Section End -->
          <!-- Search Section Start -->

          <!-- Search Section End -->
          <!-- Header Top Navigation Start -->
          <nav class="topnav">
            <ul id="nav1">
              <div class="popdown popdown-right settings">
                <nav> <a href="logout.php" style="border-top: none;">Log out</a> </nav>
              </div>
              </li>
            </ul>
          </nav>
          <!-- Header Top Navigation End -->
          <div class="clearfix"></div>
        </header>
        <!-- Right Section Header End -->
        <!-- Content Section Start -->