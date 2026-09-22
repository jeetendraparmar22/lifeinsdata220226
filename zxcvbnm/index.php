<?php

include_once('../config.php');
$db = new Database();
$conn = $db->getConnection();

include_once 'classes/adminLogin.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administator Login</title>
	<!--// Stylesheets //-->
	<link href="assets/css/style.css" rel="stylesheet" media="screen" />
	<link href="assets/css/bootstrap.css" rel="stylesheet" media="screen" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/icheck.min.js"></script>
</head>
</head>

<body>
	<div class="loginwrapper"> <span class="circle"></span>
		<div class="loginone">
			<header> <a><img src="assets/images/logo.png" alt="" /></a>
				<p>Enter Username and Password </p>
			</header>
			<form method="post" action="index.php">
				<div class="username">
					<input type="text" class="form-control" placeholder="Enter your username" name="username" />
					<i class="glyphicon glyphicon-user"></i>
				</div>
				<div class="password">
					<input type="password" class="form-control" placeholder="Enter your password" name="password" />
					<i class="glyphicon glyphicon-lock"></i>
				</div>
				<div class="custom-radio-checkbox">
					<label></label>
				</div>
				<script>
					$(document).ready(function() {
						$('.bluecheckradios').iCheck({
							checkboxClass: 'icheckbox_flat-blue',
							radioClass: 'iradio_flat-blue',
							increaseArea: '20%' // optional
						});
					});
				</script>
				<input type="submit" class="btn btn-primary style2" value="Sign In" name="login" />
			</form>
			<footer>
				<div class="clear"></div>
			</footer>
		</div>
	</div>
</body>

</html>