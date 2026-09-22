<?php

// include_once("config.php");
include_once('../config.php');
include_once('../classes/securityHelper.php');
$db = new Database();
$conn = $db->getConnection();
// Sanitize and validate ID to prevent SQL injection and ModSecurity issues
$del = SecurityHelper::sanitizeId($_GET['del'] ?? null);
if ($del) {
  // Use prepared statement for security
  $stmt = $conn->prepare("DELETE FROM subadmin WHERE id=?");
  if ($stmt) {
    $stmt->bind_param("i", $del);
    $stmt->execute();
    $stmt->close();
    echo '<script language="javascript">alert("Admin Successfully Deleted");</script>';
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=admin_detail.php\">";
  }
}
