<?php
error_reporting(E_ALL);
// include_once("config.php");
include_once('../config.php');
$db = new Database();
$conn = $db->getConnection();
$eid = $_GET['report'];

$selectuser = mysqli_query($conn, "SELECT * FROM employeedetail WHERE id= '$eid'");
$user = mysqli_fetch_array($selectuser);
$username = $user['empname'];

$sql_query = "select * from forms where eid='$eid'";
$resultset = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$developer_records = array();
while ($rows = mysqli_fetch_assoc($resultset)) {
	$developer_records[] = $rows;
}

$filename = "export_" . $username . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$show_coloumn = false;

if (!empty($developer_records)) {
	foreach ($developer_records as $record) {
		if (!$show_coloumn) {
			// display field/column names in first row
			echo implode("\t", array_keys($record)) . "\n";
			$show_coloumn = true;
		}
		echo implode("\t", array_values($record)) . "\n";
	}
}
exit;
