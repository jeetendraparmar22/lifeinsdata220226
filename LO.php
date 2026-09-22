<?php
ob_start();
error_reporting(0);

include_once('config.php');
$db = new Database();
$conn = $db->getConnection();
$id = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

if ($id > 0) {
    $flagupdate1 = "UPDATE `subadmin` SET flag ='1', last_action_time = NOW() WHERE id = " . $id;
    $sql = mysqli_query($conn, $flagupdate1);
}

session_unset();
session_destroy();

echo '<script>
alert("You have successfully logged out");
window.location.href = "index.php";
</script>';
exit;
