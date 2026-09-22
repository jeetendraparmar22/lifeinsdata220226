<?php
// Debug script - add this to any page to see session status
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Session Debug for: " . basename($_SERVER['PHP_SELF']) . "</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'ACTIVE' : 'NONE/INACTIVE') . "</p>";
echo "<p>Cookie: " . ($_COOKIE['lifeins_session'] ?? 'NOT SET') . "</p>";

echo "<h3>Session Data:</h3>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

echo "<h3>All Cookies:</h3>";
echo "<pre>" . print_r($_COOKIE, true) . "</pre>";

echo "<p><a href='debug_session.php'>Refresh</a></p>";
?>