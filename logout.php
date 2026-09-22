<?php
error_reporting(0);
ob_start();

include_once('config.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $id = (int)$_SESSION['id'];
    $db = new Database();
    $conn = $db->getConnection();

    $flagupdate = "UPDATE `employeedetail` SET flag = '1' WHERE id = $id";
    $sql = mysqli_query($conn, $flagupdate);

    session_unset();
    session_destroy();

    echo '<script>
    alert("You have successfully logged out");
    window.location.href = "index.php";
    </script>';
    exit;
} else {
    echo '<script>
    alert("Session expired. Redirecting to login page.");
    window.location.href = "index.php";
    </script>';
    exit;
}
