<?php

// Include the database connection
include_once('../config.php');

class RecordDeletion
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db->getConnection();
    }

    public function deleteRecordsBySubadmin($subadmin)
    {
        // Sanitize input to prevent SQL injection
        $subadmin = mysqli_real_escape_string($this->conn, $subadmin);
        $dataDeleted = false;

        // Fetch all IDs from the employeedetail table where subadmin matches
        $selectAdminQuery = "SELECT id FROM employeedetail WHERE subadmin = '$subadmin'";
        $result = mysqli_query($this->conn, $selectAdminQuery);

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];

                // Delete related data from the forms table
                $deleteQuery = "DELETE FROM forms WHERE eid = '$id'";
                if (mysqli_query($this->conn, $deleteQuery)) {
                    $dataDeleted = true;
                }
            }

            // Display a single alert message after all deletions
            if ($dataDeleted) {
                $this->redirectWithAlert('All related records have been deleted successfully!', 'UDR.php');
            } else {
                $this->redirectWithAlert('No related records found to delete!', 'UDR.php');
            }
        } else {
            $this->redirectWithAlert('No records found for the provided subadmin.', 'UDR.php');
        }
    }

    private function redirectWithAlert($message, $redirectUrl)
    {
        echo "<script>alert('$message'); window.location.href = '$redirectUrl';</script>";
        exit;
    }
}

// Initialize database connection
$db = new Database();
$deletionHandler = new RecordDeletion($db);

// Check if `subadmin` is passed in the URL
if (isset($_GET['subadmin'])) {
    $subadmin = $_GET['subadmin'];
    $deletionHandler->deleteRecordsBySubadmin($subadmin);
} else {
    echo "<script>alert('Invalid request: subadmin parameter missing.'); window.location.href = 'UDR.php';</script>";
}

// Close the database connection
$db->closeConnection();
