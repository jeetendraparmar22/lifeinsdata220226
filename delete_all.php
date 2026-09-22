<?php
error_reporting(0);
include_once("config.php");
$db = new Database();
$conn = $db->getConnection();


// Check if session is active
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
	echo '<script>
    alert("Session expired. Redirecting to login page.");
    window.location.href = "index.php";
    </script>';
	exit;
}

// Enforce deactive_time so a user whose access window has closed cannot delete records
$flagId = (int)$_SESSION['id'];
$utype  = $_SESSION['utype'] ?? '';
if ($utype === 'employee') {
	$deactRes = $conn->query("SELECT deactive_time FROM `employeedetail` WHERE id = $flagId");
	if ($deactRes && $row = $deactRes->fetch_assoc()) {
		$tz          = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
		$currentTime = (new DateTime('now', new DateTimeZone($tz)))->format('H:i:s');
		if ($currentTime >= $row['deactive_time']) {
			$conn->query("UPDATE `employeedetail` SET flag = '1' WHERE id = $flagId");
			session_destroy();
			echo '<script>alert("Your access time is over.");window.location.href="index.php";</script>';
			exit;
		}
	}
} elseif ($utype === 'subadmin') {
	$deactRes = $conn->query("SELECT deactive_time FROM `subadmin` WHERE id = $flagId");
	if ($deactRes && $row = $deactRes->fetch_assoc()) {
		$tz          = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
		$currentTime = (new DateTime('now', new DateTimeZone($tz)))->format('H:i:s');
		if ($currentTime >= $row['deactive_time']) {
			$conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $flagId");
			session_destroy();
			echo '<script>alert("Your access time is over.");window.location.href="index.php";</script>';
			exit;
		}
	}
}


if (isset($_POST['delete'])) {
	$checkbox = $_REQUEST['checkbox'];
	for ($i = 0; $i < count($checkbox); $i++) {

		$del_id = $checkbox[$i];
		$sqldelete = "DELETE FROM forms WHERE id= '$del_id'";
		$resultdelete = mysqli_query($conn, $sqldelete);
	}
	// if successful redirect to delete_multiple.php
	if ($resultdelete) {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=entry_list.php\">";
	}
}
