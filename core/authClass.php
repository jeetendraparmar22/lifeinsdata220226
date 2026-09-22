<?php
// Include config FIRST so custom session handler is registered before any session operations
require_once __DIR__ . '/../config.php';

class Login
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection(); // Retrieve the database connection
    }

    public function logout()
    {
        if (isset($_SESSION['utype'])) {
            $utype = $_SESSION['utype'];
            $id    = (int)($_SESSION['id'] ?? 0);
            if ($id > 0) {
                if ($utype === 'employee') {
                    $this->db->query("UPDATE `employeedetail` SET flag = '1' WHERE id = $id");
                } elseif ($utype === 'subadmin') {
                    $this->db->query("UPDATE `subadmin` SET flag = '1' WHERE id = $id");
                }
            }
            unset($_SESSION);
            session_destroy();
            header("Location: index.php");
            exit;
        }
    }

    private function sanitizeInput($input)
    {
        $input = stripslashes($input);
        return $this->db->real_escape_string($input);
    }

    public function authenticate($username, $password, $userType)
    {
        $username = $this->sanitizeInput($username);
        $password = $this->sanitizeInput($password);

        if ($userType === 'subadmin') {
            return $this->authenticateSubAdmin($username, $password);
        } elseif ($userType === 'employee') {
            return $this->authenticateEmployee($username, $password);
        } else {
            $this->showAlert('Invalid user type.');
        }
    }

    private function authenticateSubAdmin($username, $password)
    {
        $query = "SELECT * FROM `subadmin` WHERE adminusername='$username' AND adminpassword='$password'";
        $result = $this->db->query($query);

        if ($result && $data = $result->fetch_assoc()) {
            $this->checkSubAdminValidity($data);
        } else {
            $this->showAlert('Invalid credentials for Subadmin.');
        }
    }

    private function checkSubAdminValidity($data)
    {
        $timezone = !empty($data['timezone']) ? $data['timezone'] : 'Asia/Kolkata';

        // set default timezone
        date_default_timezone_set($timezone);

        $currentDate = date('Y-m-d H:i:s');
        $currentTime = date('H:i:s');

        if ($data['flag'] == '0') {
            $this->showAlert('You are already logged in.');
        } elseif (
            $data['status'] === 'y' &&
            $currentTime > $data['active_time'] &&
            $currentTime < $data['deactive_time'] &&
            $currentDate >= $data['active_date'] &&
            $currentDate <= $data['deactive_date']
        ) {
            // Set session data BEFORE regenerating ID
            $_SESSION['utype'] = $data['utype'];
            $_SESSION['adminusername'] = $data['adminusername'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['timezone'] = $timezone;
            $_SESSION['timeout'] = time();

            // Now regenerate ID (preserves session data)
            session_regenerate_id(true);
            session_write_close(); // Ensure session is written to database

            $this->redirectBasedOnDate('subadmin', $data['id'], 'add_newemp.php', 'emp_list.php');
        } else {
            $this->showAlert('Access time is over or not started.');
        }
    }

    private function authenticateEmployee($username, $password)
    {
        $query = "SELECT * FROM employeedetail WHERE username='$username' AND password='$password'";
        $result = $this->db->query($query);

        if ($result && $data = $result->fetch_assoc()) {
            $this->checkEmployeeValidity($data);
        } else {
            $this->showAlert('Invalid credentials for Employee.');
        }
    }

    private function checkEmployeeValidity($data)
    {
        // get user's timezone
        $timezone = !empty($data['timezone']) ? $data['timezone'] : 'Asia/Kolkata';

        // set default timezone
        date_default_timezone_set($timezone);

        $currentDate = date('Y-m-d H:i:s');
        $currentTime = date('H:i:s');

        if ($data['flag'] == '0') {
            $this->showAlert('You are already logged in.');
        } elseif (
            $data['status'] === 'y' &&
            $currentTime > $data['active_time'] &&
            $currentTime < $data['deactive_time'] &&
            $currentDate >= $data['active_date'] &&
            $currentDate <= $data['deactive_date']
        ) {
            // Set session data BEFORE regenerating ID
            $_SESSION['utype'] = $data['utype'];
            $_SESSION['empname'] = $data['empname'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['timezone'] = $timezone;
            $_SESSION['timeout'] = time();

            // Now regenerate ID (preserves session data)
            session_regenerate_id(true);
            session_write_close(); // Ensure session is written to database

            $this->redirectBasedOnDate('employeedetail', $data['id'], 'add_entry.php', 'entrylist.php');
        } else {
            $this->showAlert('Access time is over or not started.');
        }
    }

    private function redirectBasedOnDate($table, $id, $redirectIfValid, $redirectIfInvalid)
    {
        $query = "SELECT * FROM `$table` WHERE id='$id'";
        $result = $this->db->query($query);

        if ($result && $data = $result->fetch_assoc()) {

            $currentDate = date('Y-m-d');


            if ($currentDate <= $data['deactive_date']) {

                header("Location: $redirectIfValid");
            } else {
                header("Location: $redirectIfInvalid");
            }
            exit;
        }
    }

    private function showAlert($message)
    {
        echo "<script>alert('$message');</script>";
    }
}

$database = new Database();
$login = new Login($database);

// Handle logout - only when explicitly requested
if (isset($_GET['logout']) || (isset($_POST['logout']) && $_POST['logout'] == 'true')) {
    $login->logout();
}

// Handle login submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['utype'];

    $login->authenticate($username, $password, $userType);
}
