<?php
$timeout = 1200; // Number of seconds until it times out.

// Check if the timeout field exists.
if (isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if ($duration > $timeout) {
        // Reset the login flag so the user can log back in immediately.
        if (!empty($_SESSION['id']) && !empty($_SESSION['utype']) && isset($conn)) {
            $flagId = (int)$_SESSION['id'];
            if ($_SESSION['utype'] === 'employee') {
                $conn->query("UPDATE `employeedetail` SET flag = '1' WHERE id = $flagId");
            } elseif ($_SESSION['utype'] === 'subadmin') {
                $conn->query("UPDATE `subadmin` SET flag = '1' WHERE id = $flagId");
            }
        }
        session_destroy();
        header("location:index.php");
        exit;
    }
}
// Update the timeout field with the current time.
$_SESSION['timeout'] = time();
