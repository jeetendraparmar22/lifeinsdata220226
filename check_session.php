<?php
include_once __DIR__ . '/config.php';

// Re-open session since config.php closes it immediately
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['utype']) || empty($_SESSION['id'])) {
	header('Location: index.php');
	exit;
}

$db = new Database();
$conn = $db->getConnection();
