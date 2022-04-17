<?php
session_start();
require_once("../rootpath.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['login-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (!empty($username) && !empty($password)) {
		$output = null; $exitCode = null;
		$command = 'python3 ' . __ROOT_DIR__ . 'authentication/verify_login.py '
			. ' --username ' . escapeshellarg($username)
			. ' --password ' . escapeshellarg($password);
		echo "Command: $command<br>\n";
		exec(escapeshellcmd($command), $output, $exitCode);
		
		echo print_r($output, true);
		echo print_r($exitCode, true);

		if ($exitCode == 1) {
			echo '<script>alert("Invalid username or password.")</script>';
			// header("Refresh:0");
			exit;
		}
		
		$ticket = explode(",", $output[0]);
		$_SESSION['ticket'] = $ticket[0];
		$_SESSION['username'] = $ticket[1];
		
		// header("Location: ../dashboard.php");
    } else {
		echo '<script>alert("Some of the fields were left empty.")</script>';
		// header("Refresh:0");	
		exit;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/stylesheet.css">
		<title>McGill TA Management System | Login</title>
	</head>

	<body>
		<div class="header">
			<h1>McGill TA Management System</h1>
		</div>
		
		<div class="desc">
			<h2>Welcome to the McGill SOCS TA Management System. This system can be accessed by students, faculty, and staff within the SOCS department.</h2>
		</div>
	
		<div id="login">
			<h3>Login</h3>
			
			<div class="login-form">
				<form method="post" action="">
					<label for="username">Username: </label>
					<input type="text" name="username" id="username">
					<label for="password">Password: </label>
					<input type="password" name="password" id="password">
					
					<button type="submit" name="login-btn" class="submit" value="Login">Login</button>
				</form>
			</div>
			
			<div class="register-link">
				<a href="register.php">Register an account</a>
			</div>
		</div>
		
		<div class="footer">
			<p>&copy 1995, Joe Vybihal</p>
		</div>
	</body>
</html>
