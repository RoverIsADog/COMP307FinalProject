<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (__DEBUG__) echo nl2br("The content of the session is: \n");
if (__DEBUG__) echo nl2br(print_r($_SESSION, true));

if (isset($_POST['login-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (!empty($username) && !empty($password)) {
		$output = null; $exitCode = null;
		$command = 'python3 ' . __ROOT_DIR__ . 'authentication/verify_login.py'
			. ' --username ' . escapeshellarg($username)
			. ' --password ' . escapeshellarg($password)
			. ' 2>&1';
		if (__DEBUG__) echo "Command: $command<br>\n";
		exec(escapeshellcmd($command), $output, $exitCode);
		
		if (__DEBUG__) echo("The output was: \n");
		if (__DEBUG__) echo(nl2br(print_r($output, true)));
		if (__DEBUG__) echo("The exit code was: $exitCode<br>\n");

		if ($exitCode == 1) {
			// echo '<script>alert("Invalid username or password.")</script>';
			// header("Refresh:0");
			exit;
		}
		
		$ticket = explode(',', $output[0]);

		if (__DEBUG__) echo "The ticket consists of: <br>\n";
		if (__DEBUG__) print_r($ticket);
		echo "The output consists of: <br>\n";
		print_r($output[0]);

		// Dual saving
		$_SESSION['ticket'] = $ticket[0];
		$_SESSION['username'] = $ticket[1];
		setcookie("ticket", $ticket[0], 0, "/");
		setcookie("username", $ticket[1], 0, "/");

		echo "The session consists of: <br>\n";
		print_r($_SESSION);
		
		// header("Location: ../dashboard.php");
    } else {
		echo '<script>alert("Some of the fields were left empty.")</script>';
		// header("Refresh:0");
		exit;
	}
}
?>