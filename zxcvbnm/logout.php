<?php
ob_start();
error_reporting(0);
session_start();

$id = (int)($_SESSION['id'] ?? 0);

include_once('../config.php');
$db = new Database();
$conn = $db->getConnection();

// Reset flag so this account can log in again
if ($id > 0) {
    $conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $id");
}

$_SESSION['adminusername'] = "";
session_destroy();

echo '<script>alert("Now you have successfully logged out of the system");window.location.href="index.php";</script>';
exit;
