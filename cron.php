<?php

// Security: only allow requests with the correct token
$validToken = 'abc123XyZ987';
if (!isset($_GET['token']) || $_GET['token'] !== $validToken) {
    http_response_code(403);
    exit('Forbidden');
}

include_once('config.php');
$db   = new Database();
$conn = $db->getConnection();

// ---------------------------------------------------------------
// PART 1 — Reset flag for inactive users (login-lock safety net)
// Uses MySQL timestampdiff so no PHP timezone needed
// ---------------------------------------------------------------
$conn->query("UPDATE employeedetail SET flag = '1'
              WHERE timestampdiff(MINUTE, last_action_time, now()) > 15");

$conn->query("UPDATE subadmin SET flag = '1'
              WHERE timestampdiff(MINUTE, last_action_time, now()) > 10");

// ---------------------------------------------------------------
// PART 2 — Deactivate / Re-activate per user's own timezone
// ---------------------------------------------------------------

// -- EMPLOYEES: deactivate --
$empRows = $conn->query("SELECT id, timezone, deactive_time
                         FROM employeedetail WHERE status = 'y'");
if ($empRows) {
    while ($row = $empRows->fetch_assoc()) {
        $tz          = !empty($row['timezone']) ? $row['timezone'] : 'Asia/Kolkata';
        $currentTime = (new DateTime('now', new DateTimeZone($tz)))->format('H:i:s');
        if ($currentTime >= $row['deactive_time']) {
            $id = (int)$row['id'];
            $conn->query("UPDATE employeedetail SET status = 'n', flag = '1' WHERE id = $id");
        }
    }
}

// -- EMPLOYEES: re-activate next day when active window starts --
$empReact = $conn->query("SELECT id, timezone, active_time, deactive_time, active_date, deactive_date
                          FROM employeedetail WHERE status = 'n'");
if ($empReact) {
    while ($row = $empReact->fetch_assoc()) {
        $tz          = !empty($row['timezone']) ? $row['timezone'] : 'Asia/Kolkata';
        $dt          = new DateTime('now', new DateTimeZone($tz));
        $currentTime = $dt->format('H:i:s');
        $currentDate = $dt->format('Y-m-d');
        if (
            $currentDate >= $row['active_date']   &&
            $currentDate <= $row['deactive_date'] &&
            $currentTime >= $row['active_time']   &&
            $currentTime <  $row['deactive_time']
        ) {
            $id = (int)$row['id'];
            $conn->query("UPDATE employeedetail SET status = 'y' WHERE id = $id");
        }
    }
}

// -- SUBADMINS: deactivate --
$subRows = $conn->query("SELECT id, timezone, deactive_time
                         FROM subadmin WHERE status = 'y'");
if ($subRows) {
    while ($row = $subRows->fetch_assoc()) {
        $tz          = !empty($row['timezone']) ? $row['timezone'] : 'Asia/Kolkata';
        $currentTime = (new DateTime('now', new DateTimeZone($tz)))->format('H:i:s');
        if ($currentTime >= $row['deactive_time']) {
            $id = (int)$row['id'];
            $conn->query("UPDATE subadmin SET status = 'n', flag = '1' WHERE id = $id");
        }
    }
}

// -- SUBADMINS: re-activate next day when active window starts --
$subReact = $conn->query("SELECT id, timezone, active_time, deactive_time, active_date, deactive_date
                          FROM subadmin WHERE status = 'n'");
if ($subReact) {
    while ($row = $subReact->fetch_assoc()) {
        $tz          = !empty($row['timezone']) ? $row['timezone'] : 'Asia/Kolkata';
        $dt          = new DateTime('now', new DateTimeZone($tz));
        $currentTime = $dt->format('H:i:s');
        $currentDate = $dt->format('Y-m-d');
        if (
            $currentDate >= $row['active_date']   &&
            $currentDate <= $row['deactive_date'] &&
            $currentTime >= $row['active_time']   &&
            $currentTime <  $row['deactive_time']
        ) {
            $id = (int)$row['id'];
            $conn->query("UPDATE subadmin SET status = 'y' WHERE id = $id");
        }
    }
}
