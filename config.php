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

// Create database connection for session
$sessionDb = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($sessionDb->connect_error) {
    die("Session DB connection failed: " . $sessionDb->connect_error);
}
$sessionDb->set_charset('utf8mb4');

// Create sessions table
$sessionDb->query("CREATE TABLE IF NOT EXISTS `php_sessions` (
    `id` varchar(128) NOT NULL PRIMARY KEY,
    `data` text NOT NULL,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Session handler class
class DatabaseSessionHandler {
    private $db;
    private $sessionId;
    private $sessionData;

    public function __construct($db) {
        $this->db = $db;
    }

    public function open($savePath, $sessionName) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($id) {
        $id = $this->db->real_escape_string($id);
        $result = $this->db->query("SELECT `data` FROM `php_sessions` WHERE `id` = '$id'");
        if ($result && $row = $result->fetch_assoc()) {
            $this->sessionId = $id;
            return $row['data'];
        }
        return '';
    }

    public function write($id, $data) {
        $id = $this->db->real_escape_string($id);
        $data = $this->db->real_escape_string($data);
        $this->db->query("REPLACE INTO `php_sessions` (`id`, `data`, `updated_at`) VALUES ('$id', '$data', NOW())");
        return true;
    }

    public function destroy($id) {
        $id = $this->db->real_escape_string($id);
        $this->db->query("DELETE FROM `php_sessions` WHERE `id` = '$id'");
        return true;
    }

    public function gc($maxlifetime) {
        $this->db->query("DELETE FROM `php_sessions` WHERE `updated_at` < DATE_SUB(NOW(), INTERVAL " . (int)$maxlifetime . " SECOND)");
        return true;
    }
}

// Create handler instance
$sessionHandler = new DatabaseSessionHandler($sessionDb);

// Register handlers
session_set_save_handler(
    array($sessionHandler, 'open'),
    array($sessionHandler, 'close'),
    array($sessionHandler, 'read'),
    array($sessionHandler, 'write'),
    array($sessionHandler, 'destroy'),
    array($sessionHandler, 'gc')
);

// Configure session - detect HTTPS properly for production (load balancers, proxies)
$isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'
    || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) !== 'off')
    || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

// Get the domain for cookie (use explicit domain or none for current host)
$cookieDomain = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

// Force secure in production if HTTPS is detected
$forceSecure = $isHttps;

ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');
session_name('lifeins_session');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $cookieDomain,
    'secure' => $forceSecure,
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
