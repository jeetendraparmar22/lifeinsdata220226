<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Create sessions table if not exists
$sessionDb->query("CREATE TABLE IF NOT EXISTS `php_sessions` (
    `id` varchar(128) NOT NULL PRIMARY KEY,
    `data` text NOT NULL,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Add missing columns if they don't exist (for existing tables)
$columns = $sessionDb->query("SHOW COLUMNS FROM `php_sessions` LIKE 'ip_address'");
if ($columns->num_rows == 0) {
    $sessionDb->query("ALTER TABLE `php_sessions` ADD COLUMN `ip_address` varchar(45) DEFAULT NULL AFTER `updated_at`");
}
$columns = $sessionDb->query("SHOW COLUMNS FROM `php_sessions` LIKE 'user_agent'");
if ($columns->num_rows == 0) {
    $sessionDb->query("ALTER TABLE `php_sessions` ADD COLUMN `user_agent` varchar(255) DEFAULT NULL AFTER `ip_address`");
}

// Session handler class
class DatabaseSessionHandler {
    private $db;
    private $sessionId;
    private $sessionData;
    private $isActive = false;

    public function __construct($db) {
        $this->db = $db;
    }

    public function open($savePath, $sessionName) {
        $this->isActive = true;
        return true;
    }

    public function close() {
        $this->isActive = false;
        return true;
    }

    public function read($id) {
        $id = $this->db->real_escape_string($id);
        $result = $this->db->query("SELECT `data` FROM `php_sessions` WHERE `id` = '$id'");
        if ($result && $row = $result->fetch_assoc()) {
            $this->sessionId = $id;
            $this->sessionData = $row['data'];
            return $row['data'];
        }
        return '';
    }

    public function write($id, $data) {
        $id = $this->db->real_escape_string($id);
        $data = $this->db->real_escape_string($data);
        $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $this->db->real_escape_string($_SERVER['REMOTE_ADDR']) : '';
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $this->db->real_escape_string($_SERVER['HTTP_USER_AGENT']) : '';

        $this->db->query("INSERT INTO `php_sessions` (`id`, `data`, `updated_at`, `ip_address`, `user_agent`)
                          VALUES ('$id', '$data', NOW(), '$ipAddress', '$userAgent')
                          ON DUPLICATE KEY UPDATE `data` = '$data', `updated_at` = NOW(), `ip_address` = '$ipAddress', `user_agent` = '$userAgent'");
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

// Register handlers - tells PHP to use database instead of files
session_set_save_handler(
    [$sessionHandler, 'open'],
    [$sessionHandler, 'close'],
    [$sessionHandler, 'read'],
    [$sessionHandler, 'write'],
    [$sessionHandler, 'destroy'],
    [$sessionHandler, 'gc']
);

// Configure session cookie for security
$isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'
    || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Start session
session_start();

// Database class
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
date_default_timezone_set($defaultTimezone);
