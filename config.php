<?php
error_reporting(0);

// Clear any output buffering
while (ob_get_level()) {
    ob_end_clean();
}

// Database session configuration
$dbHost = "208.91.198.160";
$dbUser = "nextt3ac_lifeins";
$dbPass = "o)K#4[(kokL^";
$dbName = "nextt3ac_lifeins";

// Create database connection for session handler
$sessionDb = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($sessionDb->connect_error) {
    die("Session database connection failed.");
}
$sessionDb->set_charset('utf8mb4');

// Create sessions table if not exists
$sessionDb->query("CREATE TABLE IF NOT EXISTS `sessions` (
    `session_id` varchar(128) NOT NULL PRIMARY KEY,
    `session_data` text NOT NULL,
    `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// Custom session open
function sess_open($savePath, $sessionName) {
    return true;
}

// Custom session close
function sess_close() {
    return true;
}

// Custom session read
function sess_read($sessionId) {
    global $sessionDb;

    $stmt = $sessionDb->prepare("SELECT session_data FROM sessions WHERE session_id = ?");
    if ($stmt) {
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['session_data'];
        }
        $stmt->close();
    }
    return '';
}

// Custom session write
function sess_write($sessionId, $sessionData) {
    global $sessionDb;

    $stmt = $sessionDb->prepare("REPLACE INTO sessions (session_id, session_data, last_activity) VALUES (?, ?, NOW())");
    if ($stmt) {
        $stmt->bind_param("ss", $sessionId, $sessionData);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Custom session destroy
function sess_destroy($sessionId) {
    global $sessionDb;

    $stmt = $sessionDb->prepare("DELETE FROM sessions WHERE session_id = ?");
    if ($stmt) {
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Custom session garbage collector
function sess_gc($maxlifetime) {
    global $sessionDb;

    $sessionDb->query("DELETE FROM sessions WHERE last_activity < NOW() - INTERVAL " . (int)$maxlifetime . " SECOND");
    return true;
}

// Register custom session handlers BEFORE session_start()
session_set_save_handler(
    'sess_open',
    'sess_close',
    'sess_read',
    'sess_write',
    'sess_destroy',
    'sess_gc'
);

// Start session with secure settings
$isHttps = (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
    || strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';

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

session_start();

// Close the session database connection after session is loaded
$sessionDb->close();

class Database
{
    private $serverName = "208.91.198.160";
    private $userName = "nextt3ac_lifeins";
    private $password = "o)K#4[(kokL^";
    private $dbName = "nextt3ac_lifeins";

    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            die("Database connection failed.");
        }
        $this->connection->set_charset('utf8mb4');
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

$defaultTimezone = 'Asia/Kolkata';
date_default_timezone_set($_SESSION['timezone'] ?? $defaultTimezone);
