<?php

// error_reporting(0);
include_once("config.php");
include_once('classes/securityHelper.php');
$db = new Database();
$conn = $db->getConnection();
// Sanitize and validate ID to prevent SQL injection and ModSecurity issues
$del = SecurityHelper::sanitizeId($_GET['del'] ?? null);
if ($del) {
  // Use prepared statement for security
  $stmt = $conn->prepare("DELETE FROM forms WHERE id=?");
  if ($stmt) {
    $stmt->bind_param("i", $del);
    $sql = $stmt->execute();
    $stmt->close();
    if ($sql) {
      echo '<script>
          alert("Record Successfully Deleted");
          window.location.href = "entry_list.php";
      </script>';
      exit;
    }
  }
}
echo '<script>
    alert("Error deleting record");
    window.location.href = "entry_list.php";
</script>';
exit;
