<?php
ini_set("errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
class adminLogin
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function sanitizeInput($input)
    {
        $input = stripslashes($input);
        return mysqli_real_escape_string($this->conn, $input);
    }

    public function authenticate($username, $password)
    {
        $username = $this->sanitizeInput($username);
        $password = $this->sanitizeInput($password);

        $query = "SELECT * FROM administrator WHERE adminusername='$username' AND adminpassword='$password'";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $fetch = mysqli_fetch_array($result);

            $_SESSION['adminusername'] = $fetch['adminusername'];
            $_SESSION['id'] = $fetch['adminid'];

            return true;
        }

        return false;
    }

    public function getAdminDetails($id)
    {
        $query = "SELECT * FROM administrator WHERE adminid = $id";
        $result = mysqli_query($this->conn, $query);

        return $result ? mysqli_fetch_array($result) : null;
    }
}

// Usage example
if (isset($_POST['login'])) {

    session_start();
    $login = new adminLogin($conn);

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($login->authenticate($username, $password)) {
        $adminDetails = $login->getAdminDetails($_SESSION['id']);

        header("Location: add_admin.php");
        exit;
    } else {
        echo "<script>alert('You cannot login');</script>";
    }
}
