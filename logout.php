<?php
// ini_set('errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);

ob_start();

include_once('config.php');
// Initialize Database connection
$db = new Database();
$conn = $db->getConnection();



// Check session variables active or not
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $flagupdate = "UPDATE `employeedetail` SET flag = '1' WHERE id = $id";
    $sql = mysqli_query($conn, $flagupdate);

    if ($sql) {
        $_SESSION['utype'] = "";

        session_destroy();

        echo '<script>
        alert("You’ve successfully logged out");
        window.location.href = "index.php";
        </script>';
        exit;
    } else {
        echo '<script>
        alert("Error updating record. Please try again.");
        window.location.href = "index.php";
        </script>';
        exit;
    }
} else {
    // Redirect directly to the index page if session ID does not exist
    echo '<script>
    alert("Session expired. Redirecting to login page.");
    window.location.href = "index.php";
    </script>';
    exit;
}

// $id = $_SESSION['id'];

// $flagupdate = "UPDATE `employeedetail` SET flag ='1' WHERE id=" . $_SESSION['id'];
// $sql = mysqli_query($conn, $flagupdate);

// if ($sql) {
//     $_SESSION['utype'] == "";

//     session_destroy();

//     echo '<script>
//     alert("You’ve successfully logged out");
//     window.location.href = "index.php";
//     </script>';
//     exit;
// }
