<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('config.php');

echo "<h2>Database Session Test</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'ACTIVE' : 'INACTIVE') . "</p>";

if (!isset($_SESSION['test'])) {
    $_SESSION['test'] = 'Hello ' . time();
    $_SESSION['adminusername'] = 'admin_user';
    $_SESSION['id'] = 123;
    $_SESSION['utype'] = 'subadmin';
    echo "<p style='color:green'>Session data SET</p>";
} else {
    echo "<p style='color:green'>Session PERSISTED!</p>";
}

echo "<p>Session Data:</p>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

echo "<p><a href='test_db_session.php'>Click to refresh</a></p>";

echo "<hr><h3>Login Test:</h3>";
if (isset($_SESSION['adminusername']) && isset($_SESSION['id'])) {
    echo "<p style='color:green'>Logged in user: " . $_SESSION['adminusername'] . " (ID: " . $_SESSION['id'] . ")</p>";
    echo "<p><a href='logout.php'>Test Logout</a></p>";
} else {
    echo "<p>Not logged in yet.</p>";
}
?>