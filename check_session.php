<?php
include_once __DIR__ . '/config.php';

class EmployeeSessionHandler
{
	private $conn;
	private $sessionData;

	public function __construct($dbConnection, $sessionData)
	{
		$this->conn = $dbConnection;
		$this->sessionData = $sessionData;
	}

	public function checkSession()
	{
		try {
			// Fetch employee details
			$employeeDetails = $this->getEmployeeDetails($this->sessionData['id']);

			if (!$employeeDetails) {
				throw new Exception("Employee not found.");
			}

			// Access dates are enforced during login. Do not destroy a valid
			// session during navigation because of a server/user timezone mismatch.
		} catch (Exception $e) {
			echo '<script language="javascript">alert("Error: ' . $e->getMessage() . '");</script>';
		}
	}

	private function getEmployeeDetails($id)
	{
		// Sanitize the input to prevent SQL injection
		$id = (int) $id;

		// Directly execute the query
		$query = "SELECT * FROM `employeedetail` WHERE id = $id";
		$result = $this->conn->query($query);

		if ($result === false) {
			die("Query failed: " . $this->conn->error);
		}

		// Fetch and return the associative array
		return $result->fetch_assoc();
	}

	private function updateFlag($id)
	{
		// Sanitize the input to prevent SQL injection
		$id = (int) $id;

		// Directly execute the query
		$query = "UPDATE `employeedetail` SET flag = '1' WHERE id = $id";
		if (!$this->conn->query($query)) {
			throw new Exception("Failed to update flag: " . $this->conn->error);
		}
	}


	private function endSession($message)
	{
		session_destroy();
		session_unset();
		echo '<script language="javascript">alert("' . $message . '");</script>';
		echo '<script>window.location.href = "index.php";</script>';
		exit();
	}

	private function getCurrentTime()
	{
		$tz = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
		return (new DateTime('now', new DateTimeZone($tz)))->format('H:i:s');
	}

	private function getCurrentDate()
	{
		$tz = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
		return (new DateTime('now', new DateTimeZone($tz)))->format('Y-m-d');
	}
}

// Initialize database and session data
if (empty($_SESSION['utype']) || empty($_SESSION['id'])) {
	header('Location: index.php');
	exit;
}

$db = new Database();
$conn = $db->getConnection();
$sessionData = [
	'utype' => $_SESSION['utype'],
	'id' => $_SESSION['id'],
	'empname' => $_SESSION['empname']
];

// Create an instance of EmployeeSessionHandler and check session
$employeeSessionHandler = new EmployeeSessionHandler($conn, $sessionData);
$employeeSessionHandler->checkSession();
