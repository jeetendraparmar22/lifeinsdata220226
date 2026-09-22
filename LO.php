<?php
ob_start();
error_reporting(0);
// session_start();

include_once('config.php');
$db = new Database();
$conn = $db->getConnection();
$id = $_SESSION['id'];

$flagupdate1 = "UPDATE `subadmin` SET flag ='1',last_action_time = now() WHERE id=" . $_SESSION['id'];
// mysqli_query($conn, $flagupdate1);

$sql = mysqli_query($conn, $flagupdate1);
if ($sql) {
    $_SESSION['utype'] == "";

    session_destroy();

    echo '<script>
    alert("You’ve successfully logged out");
    window.location.href = "index.php";
    </script>';
    exit;
}
