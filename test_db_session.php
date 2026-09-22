<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('config.php');

echo "<h2>Database Session Test</h2>";
echo "<p>Session ID: " . session_id() . "</p>";

if (!isset($_SESSION['test'])) {
    $_SESSION['test'] = 'Hello ' . time();
    $_SESSION['admin'] = 'admin_user';
    $_SESSION['time'] = time();
    echo "<p style='color:green'>Session data SET</p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
    echo "<p><a href='test_db_session.php'>Refresh to test persistence</a></p>";
} else {
    echo "<p style='color:green'>Session PERSISTED!</p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
    echo "<p>Age: " . (time() - $_SESSION['time']) . " seconds</p>";
}

// Check database table
$db = new Database();
$conn = $db->getConnection();
$result = $conn->query("SELECT * FROM php_sessions WHERE id = '" . session_id() . "'");
if ($result && $row = $result->fetch_assoc()) {
    echo "<h3>Database Record Found:</h3>";
    echo "<p>ID: " . $row['id'] . "</p>";
    echo "<p>Data length: " . strlen($row['data']) . " bytes</p>";
    echo "<p>Updated: " . $row['updated_at'] . "</p>";
    if (strlen($row['data']) > 0) {
        echo "<p style='color:green'>SUCCESS: Session data is in database!</p>";
    } else {
        echo "<p style='color:red'>WARNING: Data is empty in database!</p>";
    }
} else {
    echo "<p style='color:red'>No database record found for this session!</p>";
}
?>