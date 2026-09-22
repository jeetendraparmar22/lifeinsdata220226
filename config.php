<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

error_reporting(0);

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

class DatabaseSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface
{
	private mysqli $connection;
	private int $lifetime;

	public function __construct(mysqli $connection, int $lifetime = 1440)
	{
		$this->connection = $connection;
		$this->lifetime = $lifetime;
	}

	public function open(string $path, string $name): bool
	{
		return true;
	}

	public function close(): bool
	{
		return true;
	}

	public function read(string $id): string|false
	{
		$stmt = $this->connection->prepare(
			'SELECT session_data FROM lifeins_sessions WHERE session_id = ? AND last_activity >= ?'
		);
		if (!$stmt) {
			return false;
		}
		$minimumActivity = time() - $this->lifetime;
		$stmt->bind_param('si', $id, $minimumActivity);
		$stmt->execute();
		$stmt->bind_result($data);
		$result = $stmt->fetch() ? $data : '';
		$stmt->close();
		return $result;
	}

	public function validateId(string $id): bool
	{
		$stmt = $this->connection->prepare(
			'SELECT session_id FROM lifeins_sessions WHERE session_id = ? AND last_activity >= ?'
		);
		if (!$stmt) {
			return false;
		}
		$minimumActivity = time() - $this->lifetime;
		$stmt->bind_param('si', $id, $minimumActivity);
		$stmt->execute();
		$stmt->store_result();
		$valid = $stmt->num_rows === 1;
		$stmt->close();
		return $valid;
	}

	public function updateTimestamp(string $id, string $data): bool
	{
		$now = time();
		$stmt = $this->connection->prepare(
			'UPDATE lifeins_sessions SET session_data = ?, last_activity = ? WHERE session_id = ?'
		);
		if (!$stmt) {
			return false;
		}
		$stmt->bind_param('sis', $data, $now, $id);
		$success = $stmt->execute();
		$stmt->close();
		return $success;
	}

	public function write(string $id, string $data): bool
	{
		$now = time();
		$stmt = $this->connection->prepare(
			'INSERT INTO lifeins_sessions (session_id, session_data, last_activity) VALUES (?, ?, ?)
			 ON DUPLICATE KEY UPDATE session_data = VALUES(session_data), last_activity = VALUES(last_activity)'
		);
		if (!$stmt) {
			return false;
		}
		$stmt->bind_param('ssi', $id, $data, $now);
		$success = $stmt->execute();
		$stmt->close();
		return $success;
	}

	public function destroy(string $id): bool
	{
		$stmt = $this->connection->prepare('DELETE FROM lifeins_sessions WHERE session_id = ?');
		if (!$stmt) {
			return false;
		}
		$stmt->bind_param('s', $id);
		$success = $stmt->execute();
		$stmt->close();
		return $success;
	}

	public function gc(int $max_lifetime): int|false
	{
		$minimumActivity = time() - $max_lifetime;
		$stmt = $this->connection->prepare('DELETE FROM lifeins_sessions WHERE last_activity < ?');
		if (!$stmt) {
			return false;
		}
		$stmt->bind_param('i', $minimumActivity);
		$success = $stmt->execute();
		$deleted = $stmt->affected_rows;
		$stmt->close();
		return $success ? $deleted : false;
	}
}


session_name('lifeins_session');

if (session_status() === PHP_SESSION_NONE) {
	$isHttps = (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
		|| strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
	ini_set('session.use_only_cookies', '1');
	ini_set('session.use_strict_mode', '1');

	$sessionDatabase = new Database();
	$sessionConnection = $sessionDatabase->getConnection();
	$sessionConnection->query(
		'CREATE TABLE IF NOT EXISTS lifeins_sessions (' .
			'session_id VARCHAR(128) NOT NULL PRIMARY KEY, ' .
			'session_data MEDIUMBLOB NOT NULL, ' .
			'last_activity INT UNSIGNED NOT NULL, ' .
			'KEY idx_lifeins_sessions_activity (last_activity)' .
			') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
	);
	session_set_save_handler(new DatabaseSessionHandler($sessionConnection), true);

	session_set_cookie_params([
		'lifetime' => 0,
		'path' => '/',
		'secure' => $isHttps,
		'httponly' => true,
		'samesite' => 'Lax'
	]);

	session_start();
}

$defaultTimezone = 'Asia/Kolkata';
date_default_timezone_set($_SESSION['timezone'] ?? $defaultTimezone);
