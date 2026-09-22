<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

error_reporting(0);

// Clear any output buffering that could prevent session writes
if (ob_get_level()) {
	ob_end_clean();
}

if (session_status() !== PHP_SESSION_ACTIVE) {
	$isHttps = (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
		|| strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
	ini_set('session.use_only_cookies', '1');
	ini_set('session.use_strict_mode', '1');
	session_name('lifeins_session');
	session_save_path(__DIR__ . '/sessions');
	session_set_cookie_params([
		'lifetime' => 0,
		'path' => '/',
		'secure' => $isHttps,
		'httponly' => true,
		'samesite' => 'Lax'
	]);
	session_start();
	// Write and close session immediately to prevent data loss
	session_write_close();
}

class Database
{
	// private $serverName = "localhost";
	// private $userName = "root";
	// private $password = "";
	// private $dbName = "life_ins";

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
		// Create a new database connection
		$this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);

		// Check for connection errors
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
