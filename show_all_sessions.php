<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('config.php');

// Query all sessions from database
$result = $sessionDb->query("SELECT * FROM `php_sessions` ORDER BY `updated_at` DESC");

echo "<h1>All Active Sessions (Database)</h1>";
echo "<table border='1' cellpadding='10'>";
echo "<tr>
    <th>Session ID</th>
    <th>IP Address</th>
    <th>User Agent</th>
    <th>Updated At</th>
    <th>Session Data</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['ip_address'] ?? 'N/A') . "</td>";
    echo "<td>" . htmlspecialchars($row['user_agent'] ?? 'N/A') . "</td>";
    echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
    echo "<td><pre>" . htmlspecialchars($row['data']) . "</pre></td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>Current Session Info</h2>";
echo "<p>Current Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . "</p>";

if (!empty($_SESSION)) {
    echo "<h3>Current Session Data:</h3>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
} else {
    echo "<p>No session data currently set.</p>";
}
?>
