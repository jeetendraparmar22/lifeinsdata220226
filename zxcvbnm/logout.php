<?php
ob_start();
error_reporting(0);

include_once('../config.php');

$id = (int)($_SESSION['id'] ?? 0);

if ($id > 0) {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $id");
}

session_destroy();

echo '<script>alert("Now you have successfully logged out of the system");window.location.href="index.php";</script>';
exit;
