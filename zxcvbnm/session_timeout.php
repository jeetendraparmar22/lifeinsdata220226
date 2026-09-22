<?php
$timeout = 1200; // Number of seconds until it times out.

// Check if the timeout field exists.
if (isset($_SESSION['timeout'])) {
    $duration = time() - (int)$_SESSION['timeout'];
    if ($duration > $timeout) {
        // Reset flag before destroying session so the user can log in again
        if (!empty($_SESSION['id']) && isset($conn)) {
            $flagId = (int)$_SESSION['id'];
            $conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $flagId");
        }
        session_destroy();
        header("location:index.php");
        exit;
    }
}
// Update the timeout field with the current time.
$_SESSION['timeout'] = time();
