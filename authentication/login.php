<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (__DEBUG__) echo consoleLog("The content of the session is: \n");
if (__DEBUG__) echo consoleLog(print_r($_SESSION, true));

if (isset($_POST['login-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (!empty($username) && !empty($password)) {
		$output = null; $exitCode = null;
		$command = escapeshellcmd("python3 " . __ROOT_DIR__ . "authentication/verify_login.py"
			. " --username " . escapeshellarg($username)
			. " --password " . escapeshellarg($password))
			. " 2>&1";
		if (__DEBUG__) echo "Command: $command\n";
		exec($command, $output, $exitCode);
		//popen($command, "");

//		exec("./trash.sh 2>&1", $output, $exitCode);
//		exec("./a.out", $output, $exitCode);
//		exec("pwd", $output, $exitCode);
//		exec("whoami", $output, $exitCode);
		
		
		if (__DEBUG__) consoleLog("The output was: \n");
		if (__DEBUG__) consoleLog((print_r($output, true)));
		if (__DEBUG__) consoleLog("The exit code was: $exitCode\n");
		
//		exec("ls -la", $output, $exitCode);
//
//		if (__DEBUG__) echo("The output was: \n");
//		if (__DEBUG__) echo(nl2br(print_r($output, true)));
//		if (__DEBUG__) echo("The exit code was: $exitCode\n");

		if ($exitCode == 1) {
			echo '<script>alert("Invalid username or password.")</script>';
			// header("Refresh:0");
			exit;
		}
		
		$ticket = explode(',', $output[0]);

		if (__DEBUG__) echo "The ticket consists of: \n";
		if (__DEBUG__) print_r($ticket);
		echo "The output consists of: <br>\n";
		if (__DEBUG__) print_r($output[0]);

		// Dual saving just in case
		$_SESSION['ticket'] = $ticket[0];
		$_SESSION['username'] = $ticket[1];
		setcookie("ticket", $ticket[0], 0, "/");
		setcookie("username", $ticket[1], 0, "/");

		if (__DEBUG__) consoleLog("The session consists of: ");
		if (__DEBUG__) consoleLog(print_r($_SESSION, true));
		
		// header("Location: ../dashboard.php");
    }
	else {
		echo '<script>alert("Some of the fields were left empty.")</script>';
		exit;
	}
}
?>