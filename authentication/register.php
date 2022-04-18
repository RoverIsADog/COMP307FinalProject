<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['register-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password_confirm'];
	$email = $_POST['email'];
	$studentid = $_POST['studentid'];
	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	$role = $_POST['role'];
	
	if (!empty($username) && !empty($password) && !empty($password_confirm) && !empty($email) && !empty($studentid) && !empty($first_name) && !empty($last_name) && !empty($role)) {

		$output = null; $exitCode = null;
		$command = 'python3 ' . __ROOT_DIR__ . 'authentication/register_user.py '
			. ' --username '           . escapeshellarg($username)
			. ' --password '           . escapeshellarg($password)
			. ' --confirm_password '   . escapeshellarg($password_confirm)
			. ' --email '              . escapeshellarg($email)
			. ' --student_id '         . escapeshellarg($studentid)
			. ' --first_name '         . escapeshellarg($first_name)
			. ' --last_name '          . escapeshellarg($last_name)
			. ' --role '               . escapeshellarg($role);
		echo "Command: $command<br>\n";
		exec(escapeshellcmd($command), $output, $exitCode);

		echo "The exit code was: $exitCode<br>\n";
		echo "The output was: <br>";
		print_r($output);
	
		if ($exitCode == 1 || $exitCode == 2 || $exitCode == 3) {
			echo '<script>alert("User already exists. Enter new credentials.")</script>';
//			header("Refresh:0");
			exit;
		}
	
		if ($exitCode == 4) {
			echo '<script>alert("Make sure that your passwords match.")</script>';
//			header("Refresh:0");
			exit;
		}
		
		if ($exitCode == 5 || $exitCode == 6) {
			echo '<script>alert("Could not grant your requested role. Defaulted to student. Please contact a system operator to have your role changed..")</script>';
//			header("Refresh:0");
			exit;
		}
		
		if ($exitCode == 7) {
			echo '<script>alert("ERROR.")</script>';
//			header("Refresh:0");
			exit;
		}
	
		if ($exitCode == '0') {
			echo '<script>alert("Your account has been registered successfully.")</script>';
//			header("Location: index.php");
			exit;
		}
	} else {
		echo '<script>alert("Some of the fields were left empty.")</script>';
//		header("Refresh:0");	
		exit;
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
					
					<input type="radio" name="role" value="1">
                    <label for="student">Student</label>
                    <input type="radio" name="role" value="2">
                    <label for="ta">Teacher's Assistant</label>
                    <input type="radio" name="role" value="3">
                    <label for="professor">Professor</label>
					
					<button type="submit" name="register-btn" class="submit" value="Register">Register</button>
				</form>
			</div>

			<div class="login-link">
				<a href="index.php">Back to login page</a>
			</div>
		</div>
	</body>
</html>