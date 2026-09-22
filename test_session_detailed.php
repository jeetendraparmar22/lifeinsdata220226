<?php
// Clean output before anything else
error_reporting(0);
while (ob_get_level()) {
    ob_end_clean();
}
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Detailed Session Test</h2>";

// Step 1: Check if config is loading
echo "<h3>Step 1: Including config...</h3>";
include_once('config.php');
echo "Config included<br>";

// Step 2: Check session status
echo "<h3>Step 2: Session Status</h3>";
$status = session_status();
echo "session_status(): " . $status . " ";
switch ($status) {
    case PHP_SESSION_DISABLED: echo "(DISABLED)"; break;
    case PHP_SESSION_NONE: echo "(NONE)"; break;
    case PHP_SESSION_ACTIVE: echo "(ACTIVE)"; break;
}
echo "<br>";

// Step 3: Check cookie
echo "<h3>Step 3: Session Cookie</h3>";
if (isset($_COOKIE['lifeins_session'])) {
    echo "Cookie SET: " . $_COOKIE['lifeins_session'] . "<br>";
} else {
    echo "Cookie NOT SET<br>";
}

// Step 4: Check session ID
echo "<h3>Step 4: Session ID</h3>";
$sid = session_id();
echo "Session ID: " . ($sid ?: 'EMPTY') . "<br>";

// Step 5: Set test data
echo "<h3>Step 5: Setting Test Data</h3>";
$_SESSION['test_count'] = ($_SESSION['test_count'] ?? 0) + 1;
$_SESSION['adminusername'] = 'test_admin';
$_SESSION['time'] = date('Y-m-d H:i:s');
echo "Count: " . $_SESSION['test_count'] . "<br>";

// Step 6: Check database
echo "<h3>Step 6: Database Check</h3>";
if ($sid) {
    $db = new Database();
    $conn = $db->getConnection();
    $result = $conn->query("SELECT * FROM php_sessions WHERE id = '" . $conn->real_escape_string($sid) . "'");
    if ($result && $row = $result->fetch_assoc()) {
        echo "DB Record: YES, Data length: " . strlen($row['data']) . "<br>";
    } else {
        echo "DB Record: NO<br>";
    }
}

echo "<p><a href='test_session_detailed.php'>REFRESH</a></p>";
ob_end_flush();