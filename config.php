<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Clear output buffering
while (ob_get_level()) {
    ob_end_clean();
}

// Database configuration
$dbHost = "208.91.198.160";
$dbUser = "nextt3ac_lifeins";
$dbPass = "o)K#4[(kokL^";
$dbName = "nextt3ac_lifeins";

// Create database connection
$sessionDb = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($sessionDb->connect_error) {
    die("Session DB connection failed: " . $sessionDb->connect_error);
}
$sessionDb->set_charset('utf8mb4');

// Create sessions table if not exists
$sessionDb->query("CREATE TABLE IF NOT EXISTS `php_sessions` (
    `id` varchar(128) NOT NULL PRIMARY KEY,
    `data` text NOT NULL,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Register shutdown function to close session DB connection
register_shutdown_function(function() use ($sessionDb) {
    $sessionDb->close();
});

// Custom session handlers
function custom_sess_open($save_path, $session_name) {
    return true;
}

function custom_sess_close() {
    return true;
}

function custom_sess_read($id) {
    global $sessionDb;
    $result = $sessionDb->query("SELECT `data` FROM `php_sessions` WHERE `id` = '" . $sessionDb->real_escape_string($id) . "'");
    if ($result && $row = $result->fetch_assoc()) {
        return $row['data'];
    }
    return '';
}

function custom_sess_write($id, $data) {
    global $sessionDb;
    $id = $sessionDb->real_escape_string($id);
    $data = $sessionDb->real_escape_string($data);
    $sessionDb->query("REPLACE INTO `php_sessions` (`id`, `data`, `updated_at`) VALUES ('$id', '$data', NOW())");
    return true;
}

function custom_sess_destroy($id) {
    global $sessionDb;
    $id = $sessionDb->real_escape_string($id);
    $sessionDb->query("DELETE FROM `php_sessions` WHERE `id` = '$id'");
    return true;
}

function custom_sess_gc($maxlifetime) {
    global $sessionDb;
    $sessionDb->query("DELETE FROM `php_sessions` WHERE `updated_at` < DATE_SUB(NOW(), INTERVAL " . (int)$maxlifetime . " SECOND)");
    return true;
}

// Register handlers
session_set_save_handler(
    'custom_sess_open',
    'custom_sess_close',
    'custom_sess_read',
    'custom_sess_write',
    'custom_sess_destroy',
    'custom_sess_gc'
);

// Configure session
$isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';

ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');
session_name('lifeins_session');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Start session
session_start();

class Database {
    private $serverName = "208.91.198.160";
    private $userName = "nextt3ac_lifeins";
    private $password = "o)K#4[(kokL^";
    private $dbName = "nextt3ac_lifeins";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            die("Database connection failed.");
        }
        $this->connection->set_charset('utf8mb4');
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

$defaultTimezone = 'Asia/Kolkata';
date_default_timezone_set($_SESSION['timezone'] ?? $defaultTimezone);
