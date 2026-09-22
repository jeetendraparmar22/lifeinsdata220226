<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cron for Active</title>
</head>

<body>

    <?php


    include_once('config.php');
    $db = new Database();
    $conn = $db->getConnection();

    // date_default_timezone_set('Asia/Calcutta');

    $time = date('H:i');
    $query = "update employeedetails  set status ='n'  WHERE active_time <= '$time'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));




    ?>


</body>

</html>