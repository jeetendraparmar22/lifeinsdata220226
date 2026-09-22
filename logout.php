<?php
error_reporting(0);
ob_start();

include_once(‘config.php’);

if (isset($_SESSION[‘id’]) && !empty($_SESSION[‘id’])) {
    $id = $_SESSION[‘id’];
    $flagupdate = "UPDATE `employeedetail` SET flag = ‘1’ WHERE id = $id";
    $sql = mysqli_query($conn, $flagupdate);

    if ($sql) {
        $_SESSION[‘utype’] = "";
        session_destroy();

        echo ‘<script>
        alert("You’ve successfully logged out");
        window.location.href = "index.php";
        </script>’;
        exit;
    } else {
        echo ‘<script>
        alert("Error updating record. Please try again.");
        window.location.href = "index.php";
        </script>’;
        exit;
    }
} else {
    echo ‘<script>
    alert("Session expired. Redirecting to login page.");
    window.location.href = "index.php";
    </script>’;
    exit;
}
