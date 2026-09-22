<?php

require_once '.././config.php'; // Include the database connection class

class SubAdmin
{
    private $conn;
    private string $format = 'd-m-Y H:i:s';

    // Constructor to initialize the database connection
    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    // Method to check if the admin username already exists
    public function isUsernameTaken($username)
    {
        // Sanitize the username input to prevent SQL injection
        $username = $this->conn->real_escape_string($username);

        // Construct the query
        $query = "SELECT COUNT(*) FROM subadmin WHERE adminusername = '$username'";

        // Execute the query
        $result = $this->conn->query($query);

        if ($result) {
            // Fetch the result
            $row = $result->fetch_row();
            return $row[0] > 0;
        } else {
            // Handle query failure
            throw new Exception("Failed to execute query: " . $this->conn->error);
        }
    }


    public function addSubAdmin($data)
    {
        // Sanitize inputs to prevent SQL injection
        $adminusername = $this->conn->real_escape_string($data['adminusername']);
        $adminpassword = $this->conn->real_escape_string($data['adminpassword']);
        $emailid = $this->conn->real_escape_string($data['emailid']);
        $to_date = $this->conn->real_escape_string($data['to_date']);
        $address = $this->conn->real_escape_string($data['address']);
        $status = $this->conn->real_escape_string($data['status']);
        $nou = (int) $data['nou']; // Cast to integer
        $active_date = $this->conn->real_escape_string($data['active_date']);
        $active_time = $this->conn->real_escape_string($data['active_time']);
        $deactive_date = $this->conn->real_escape_string($data['deactive_date']);
        $deactive_time = $this->conn->real_escape_string($data['deactive_time']);
        $timezone = $this->conn->real_escape_string($data['timezone']);

        // Construct the query
        $query = "INSERT INTO subadmin (adminusername, adminpassword, adminemail, login_date, address, status, utype, no_of_user, active_date, active_time, deactive_date, deactive_time, timezone)
              VALUES ('$adminusername', '$adminpassword', '$emailid', '$to_date', '$address', '$status', 'subadmin', $nou, '$active_date', '$active_time', '$deactive_date', '$deactive_time', '$timezone')";

        // Execute the query
        if ($this->conn->query($query)) {
            return true;
        } else {
            throw new Exception("Failed to add subadmin: " . $this->conn->error);
        }
    }

    public function updateEmployeeStatus($adminusername, $status, $to_date, $active_time = null, $deactive_time = null, $active_date = null, $deactive_date = null)
    {
        try {
            $query = "UPDATE `employeedetail` SET ";
            $query .= "status='$status', to_date='$to_date'";

            if ($active_time) $query .= ", active_time='$active_time'";
            if ($deactive_time) $query .= ", deactive_time='$deactive_time'";
            if ($active_date) $query .= ", active_date='$active_date'";
            if ($deactive_date) $query .= ", deactive_date='$deactive_date'";

            $query .= " WHERE subadmin='$adminusername'";
            if (!mysqli_query($this->conn, $query)) {
                throw new Exception(mysqli_error($this->conn));
            }
        } catch (Exception $e) {
            throw new Exception("Error updating employee status: " . $e->getMessage());
        }
    }

    public function updateSubAdmin($data, $id)
    {

        try {
            $query = "UPDATE `subadmin` SET ";
            $query .= "adminusername='{$data['adminusername']}', ";
            $query .= "adminpassword='{$data['adminpassword']}', ";
            $query .= "adminemail='{$data['emailid']}', ";
            $query .= "login_date='{$data['to_date']}', ";
            $query .= "address='{$data['address']}', ";
            $query .= "status='{$data['status']}', ";
            $query .= "utype='subadmin', ";
            $query .= "no_of_user='{$data['no_of_user']}', ";
            $query .= "active_date='{$data['active_date']}', ";
            $query .= "deactive_date='{$data['deactive_date']}', ";
            $query .= "active_time='{$data['active_time']}', ";
            $query .= "deactive_time='{$data['deactive_time']}' ";
            $query .= "WHERE id='$id'";

            if (!mysqli_query($this->conn, $query)) {
                throw new Exception(mysqli_error($this->conn));
            }
        } catch (Exception $e) {
            throw new Exception("Error updating subadmin: " . $e->getMessage());
        }
    }

    // Convert to DateTime object
    private function convertToDateTime(string $dateTime): ?DateTime
    {
        return DateTime::createFromFormat($this->format, $dateTime) ?: null;
    }

    // Extract date in Y-m-d format
    public function getDate(string $dateTime): ?string
    {
        $dateTimeObj = $this->convertToDateTime($dateTime);
        return $dateTimeObj ? $dateTimeObj->format('Y-m-d') : null;
    }

    // Extract time in H:i:s format
    public function getTime(string $dateTime): ?string
    {
        $dateTimeObj = $this->convertToDateTime($dateTime);
        return $dateTimeObj ? $dateTimeObj->format('H:i:s') : null;
    }

    // Convert to "Y-m-d H:i:s" format
    public function convertToMySQLFormat(string $dateTime): ?string
    {
        $dateTimeObj = $this->convertToDateTime($dateTime);
        return $dateTimeObj ? $dateTimeObj->format('Y-m-d H:i:s') : null;
    }
}


if (isset($_POST['submit'])) {
    try {
        // Create a database instance
        $db = new Database();
        $conn = $db->getConnection();

        // Create SubAdmin object
        $subAdmin = new SubAdmin($conn);

        $activeDateTime = $_POST['active_date_time'];
        $deactiveDateTime = $_POST['deactive_date_time'];

        // Validate format using regex
        $regex = '/^\d{2}-\d{2}-\d{4} \d{2}:\d{2}:\d{2}$/';

        if (!preg_match($regex, $activeDateTime) || !preg_match($regex, $deactiveDateTime)) {

            echo '<script language="javascript">alert("Error: Dates must be in the format DD-MM-YYYY HH:MM:SS."); window.location.href="add_admin.php";</script>';
            exit;
        }

        // Convert to DateTime objects
        $activeDate = DateTime::createFromFormat('d-m-Y H:i:s', $activeDateTime);
        $deactiveDate = DateTime::createFromFormat('d-m-Y H:i:s', $deactiveDateTime);

        // Validate order
        if ($activeDate && $deactiveDate) {
            if ($deactiveDate < $activeDate) {

                echo '<script language="javascript">alert("Error: Deactive Date & Time must not be earlier than Active Date & Time."); window.location.href="add_admin.php";</script></script>';
                exit;
            }
            // echo 'Dates are valid.';
        } else {

            echo '<script language="javascript">alert("Error: Invalid date or time values."); window.location.href="add_admin.php";</script></script>';
            exit;
        }


        // Check if username is already taken
        if ($subAdmin->isUsernameTaken($_POST['adminusername'])) {
            echo '<script language="javascript">alert("Subadmin Name Already Taken.");</script>';
            exit;
        }

        // Prepare data for insertion
        $data = [
            'adminusername' => $_POST['adminusername'],
            'adminpassword' => $_POST['adminpassword'],
            'emailid' => $_POST['emailid'],
            'to_date' => $subAdmin->convertToMySQLFormat($activeDateTime),
            'address' => $_POST['address'],
            'status' => $_POST['status'],
            'nou' => $_POST['nou'],
            'active_date' => $subAdmin->convertToMySQLFormat($activeDateTime),
            'active_time' => $subAdmin->getTime($activeDateTime),
            'deactive_date' => $subAdmin->convertToMySQLFormat($deactiveDateTime),
            'deactive_time' => $subAdmin->getTime($deactiveDateTime),
            'timezone' => $_POST['timezone'],

        ];

        // Insert the new subadmin record
        if ($subAdmin->addSubAdmin($data)) {
            echo '<script language="javascript">alert("Subadmin added successfully!");</script>';
        } else {
            echo '<script language="javascript">alert("Error adding subadmin.");</script>';
        }

        // Close the database connection
        $db->closeConnection();
    } catch (Exception $e) {
        // Display error message
        echo '<script language="javascript">alert("An error occurred: ' . $e->getMessage() . '");</script>';
    }
}


if (isset($_POST['update'])) {
    try {
        // Create a database instance
        $db = new Database();
        $conn = $db->getConnection();

        // Create SubAdmin object
        $subAdmin = new SubAdmin($conn);
        $update = $_GET['update'];

        $activeDateTime = $_POST['active_date_time'];
        $deactiveDateTime = $_POST['deactive_date_time'];

        // Validate format using regex
        $regex = '/^\d{2}-\d{2}-\d{4} \d{2}:\d{2}:\d{2}$/';

        if (!preg_match($regex, $activeDateTime) || !preg_match($regex, $deactiveDateTime)) {

            echo '<script language="javascript">alert("Error: Dates must be in the format DD-MM-YYYY HH:MM:SS."); window.location.href="add_admin.php";</script>';
            exit;
        }

        // Convert to DateTime objects
        $activeDate = DateTime::createFromFormat('d-m-Y H:i:s', $activeDateTime);
        $deactiveDate = DateTime::createFromFormat('d-m-Y H:i:s', $deactiveDateTime);

        // Validate order
        if ($activeDate && $deactiveDate) {
            if ($deactiveDate < $activeDate) {

                echo '<script language="javascript">alert("Error: Deactive Date & Time must not be earlier than Active Date & Time."); window.location.href="add_admin.php";</script></script>';
                exit;
            }
            // echo 'Dates are valid.';
        } else {

            echo '<script language="javascript">alert("Error: Invalid date or time values."); window.location.href="add_admin.php";</script></script>';
            exit;
        }
        // Prepare data for update
        $data = [
            'adminusername' => $_POST['adminusername'],
            'adminpassword' => $_POST['adminpassword'],
            'address' => $_POST['address'],
            'emailid' => $_POST['emailid'],
            'no_of_user' => $_POST['nou'],
            'to_date' => $subAdmin->convertToMySQLFormat($activeDateTime),
            'status' => $_POST['status'],
            'active_date' => $subAdmin->convertToMySQLFormat($activeDateTime),
            'active_time' => $subAdmin->getTime($activeDateTime),
            'deactive_time' => $subAdmin->getTime($deactiveDateTime),
            'deactive_date' => $subAdmin->convertToMySQLFormat($deactiveDateTime),
            'timezone' => $_POST['timezone']
        ];

        // Perform the update based on status
        if ($data['status'] === "n") {
            $subAdmin->updateEmployeeStatus($data['adminusername'], 'n', '2015-10-08');
            $subAdmin->updateSubAdmin($data, $update);
            echo "<script>window.location.href='admin_detail.php';</script>";
        } else {
            $subAdmin->updateEmployeeStatus($data['adminusername'], 'y', $data['to_date'], $data['active_time'], $data['deactive_time'], $data['active_date'], $data['deactive_date']);
            $subAdmin->updateSubAdmin($data, $update);

            echo "<script>window.location.href='admin_detail.php';</script>";
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo '<script language="javascript">alert("An error occurred: ' . $e->getMessage() . '");</script>';
    }
}
