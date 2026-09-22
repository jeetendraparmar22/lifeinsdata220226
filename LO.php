<?php
ob_start();
error_reporting(0);

include_once(‘config.php’);

// Re-open session since config.php closes it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db = new Database();
$conn = $db->getConnection();
$id = $_SESSION[‘id’] ?? 0;

$flagupdate1 = "UPDATE `subadmin` SET flag =’1’,last_action_time = now() WHERE id=" . $id;
$sql = mysqli_query($conn, $flagupdate1);
if ($sql) {
    $_SESSION = array();
    session_destroy();

    echo ‘<script>
    alert("You’ve successfully logged out");
    window.location.href = "index.php";
    </script>’;
    exit;
}
