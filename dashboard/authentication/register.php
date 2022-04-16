<?php
require( __DIR__ . "/../rootpath.php");

if (isset($_POST['register-btn'])) {
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$password_confirm = md5($_POST['password_confirm']);
	$email = $_POST['email'];
	$studentid = $_POST['studentid'];
	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	
	if (!empty($username) && !empty($password) && !empty($password_confirm) && !empty($email) && !empty($studentid) && !empty($first_name) && !empty($last_name)) {
		$command = escapeshellcmd('python '.__ROOT_DIR__.'register_login/register_user.py'.' '.$username.' '.$password.' '.$password_confirm.' '.$email.' '.$studentid.' '.$first_name.' '.$last_name);
		$output = exec($command);
	
		if ($output == '1' || $output == '2' || $output == '3') {
			echo '<script>alert("User already exists. Enter new credentials.")</script>';
			//header("Refresh:0");
			//exit;
		}
	
		if ($output == '4') {
			echo '<script>alert("Make sure that your passwords match.")</script>';
			//header("Refresh:0");
			//exit;
		}
	
		if ($output == '0') {
			echo '<script>alert("Your account has been registered successfully.")</script>';
			header("Location: index.php");
			exit;
		}
	} else {
		echo '<script>alert("Some of the fields were left empty.")</script>';
		//header("Refresh:0");	
		//exit;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/stylesheet.css">
		<title>McGill TA Management System | Registration</title>
	</head>
	
	<body>
		<div id="register">
			<h3>Register</h3>
		
			<div class="register-form">
				<form method="post" action="">
					<label for="username">Username: </label>
					<input type="text" name="username" id="username">
					<label for="password">Password: </label>
					<input type="password" name="password" id="password">
					<label for="password_confirm">Confirm password: </label>
					<input type="password" name="password_confirm" id="password_confirm">
					<label for="email">Email address: </label>
					<input type="text" name="email" id="email">
					<label for="studentid">Student ID: </label>
					<input type="text" name="studentid" id="studentid">
					<label for="firstname">First name: </label>
					<input type="text" name="firstname" id="firstname">
					<label for="lastname">Last name: </label>
					<input type="text" name="lastname" id="lastname">
					
					<button type="submit" name="register-btn" class="submit" value="Register">Register</button>
			</div>

			<div class="login-link">
				<a href="index.php">Back to login page</a>
			</div>
		</div>
	</body>
</html>