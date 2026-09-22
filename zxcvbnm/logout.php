<?php
ob_start();
error_reporting(0);

// Include config first - it handles session properly
include_once('../config.php');

// Re-open session since config.php closes it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = (int)($_SESSION['id'] ?? 0);

$db = new Database();
$conn = $db->getConnection();

// Reset flag so this account can log in again
if ($id > 0) {
    $conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $id");
}

$_SESSION = array();
session_destroy();

echo '<script>alert("Now you have successfully logged out of the system");window.location.href="index.php";</script>';
exit;
