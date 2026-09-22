<?php
include_once __DIR__ . '/config.php';

if (empty($_SESSION['utype']) || empty($_SESSION['id'])) {
	header('Location: index.php');
	exit;
}

$db = new Database();
$conn = $db->getConnection();
