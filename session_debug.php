<?php
// Complete Session Diagnostic - Run this on production
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
<title>Session Debug</title>
<style>
body { font-family: monospace; padding: 20px; }
.pass { color: green; }
.fail { color: red; }
.info { color: blue; }
</style>
</head>
<body>
<h1>Session Diagnostic</h1>
<pre>
<?php
echo "=== PHP SESSION CONFIG ===\n";
echo "session.save_path: " . ini_get('session.save_path') . "\n";
echo "session.name: " . ini_get('session.name') . "\n";
echo "session.save_handler: " . ini_get('session.save_handler') . "\n";
echo "session.use_cookies: " . ini_get('session.use_cookies') . "\n";
echo "session.use_only_cookies: " . ini_get('session.use_only_cookies') . "\n";
echo "session.cookie_path: " . ini_get('session.cookie_path') . "\n";
echo "session.cookie_domain: " . ini_get('session.cookie_domain') . "\n";
echo "session.cookie_secure: " . ini_get('session.cookie_secure') . "\n";
echo "session.cookie_httponly: " . ini_get('session.cookie_httponly') . "\n";
echo "session.serialize_handler: " . ini_get('session.serialize_handler') . "\n";
echo "session.gc_probability: " . ini_get('session.gc_probability') . "\n";
echo "session.gc_divisor: " . ini_get('session.gc_divisor') . "\n";
echo "session.gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . "\n";

echo "\n=== OUTPUT BUFFERING ===\n";
echo "output_buffering: " . ini_get('output_buffering') . "\n";
echo "output_handler: " . ini_get('output_handler') . "\n";
echo "Current ob level: " . ob_get_level() . "\n";

echo "\n=== SESSION STATUS ===\n";
echo "session_status(): " . session_status() . " (";
switch (session_status()) {
    case PHP_SESSION_DISABLED: echo "DISABLED"; break;
    case PHP_SESSION_NONE: echo "NONE"; break;
    case PHP_SESSION_ACTIVE: echo "ACTIVE"; break;
}
echo ")\n";

echo "\n=== TESTING SESSION START ===\n";
$result = session_start();
echo "session_start() returned: " . ($result ? "true" : "false") . "\n";
echo "session_status() after start: " . session_status() . "\n";
echo "session_id(): " . session_id() . "\n";

echo "\n=== TESTING SESSION WRITE ===\n";
$_SESSION['test_value'] = 'Hello ' . time();
$_SESSION['adminusername'] = 'test_admin';
$_SESSION['utype'] = 'subadmin';
$_SESSION['id'] = 123;
echo "Set session variables:\n";
print_r($_SESSION);
echo "\n";

echo "\n=== CHECKING SESSION FILE ===\n";
$savePath = ini_get('session.save_path');
$sessionFile = $savePath . '/sess_' . session_id();
echo "Session file path: $sessionFile\n";
echo "File exists: " . (file_exists($sessionFile) ? "YES" : "NO") . "\n";
if (file_exists($sessionFile)) {
    echo "File size: " . filesize($sessionFile) . " bytes\n";
    echo "File content:\n";
    echo file_get_contents($sessionFile);
}
echo "\n";

echo "\n=== SESSION WRITE CLOSE ===\n";
session_write_close();
echo "session_write_close() called\n";
echo "session_status() after write_close: " . session_status() . "\n";

if (file_exists($sessionFile)) {
    echo "File size after write_close: " . filesize($sessionFile) . " bytes\n";
}

echo "\n=== RELOAD TEST (Click refresh) ===\n";
if (isset($_SESSION['test_value'])) {
    echo "<span class='pass'>✓ Session persisted! Value: " . $_SESSION['test_value'] . "</span>\n";
    echo "<span class='info'>Session ID: " . session_id() . "</span>\n";
} else {
    echo "<span class='fail'>✗ Session NOT persisted - data lost!</span>\n";
}

echo "\n=== PERMISSIONS CHECK ===\n";
echo "Save path is dir: " . (is_dir($savePath) ? "YES" : "NO") . "\n";
echo "Save path is writable: " . (is_writable($savePath) ? "YES" : "NO") . "\n";
echo "Save path permissions: " . substr(sprintf('%o', fileperms($savePath)), -4) . "\n";
?>
</pre>
</body>
</html>