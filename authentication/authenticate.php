<?php
// Use __ROOT_DIR__ to refer to root directory from here
require_once(__DIR__ . "/../rootpath.php");
if (!isset($_SESSION)) session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function authenticate() {

	// Duplicate storage just in case
	$username = ""; $ticket_id = "";

	$ticket_id = $_SESSION['ticket'];
	$username = $_SESSION['username'];

	$ticket_id = $_COOKIE["ticket"];
	$username = $_COOKIE["username"];

	if (__DEBUG__) echo nl2br("The content of the session is: \n");
	if (__DEBUG__) echo nl2br(print_r($_SESSION, true));

	/* MICHEAL'S AUTHENTICATION CODE
	I don't care what happens in here, but after this block $loggedIn should
	be set to the proper value! (T/F)
	
	INPUTS:
		$isAuth; // Value is currently placeholder true.
		$currentSection; // {"profile", "rate", "admin", "management, "sysop"}
		$currentPage; // See gooogle doc for accepted strings
	
	EFFECTS/OUTPUTS:
		This function should set $loggerIn to the correct value. No output.
	*/

	$output = null; $exitCode = null;
	$command = escapeshellcmd( 'python3 ' . __ROOT_DIR__ . 'authentication/validate_ticket.py '
		. ' --username '  . escapeshellarg($username)
		. ' --ticket_id ' . escapeshellarg($ticket_id))
		. ' 2>&1';
	if (__DEBUG__) echo "Command: $command<br>\n";
	exec($command, $output, $exitCode);
	
	if ($exitCode == 0) {
		$isAuth = true;
	} else {
		$isAuth = false;
	}
	
	$output = null; $exitCode = null;
	$command = escapeshellcmd('python3 ' . __ROOT_DIR__ . 'authentication/get_user_roles.py '
		. ' --username ' . escapeshellarg($username))
		. ' 2>&1';
	if (__DEBUG__) echo "Command: $command<br>\n";
	exec($command, $output, $exitCode);
	
	$is_student = $output[0];
	$is_prof = $output[1];
	$is_admin = $output[2];
	$is_sysop = $output[3];
	$is_ta = $output[4];
	
	$userPermissions = array();
	if ($is_student) array_push($userPermissions, "student");
	if ($is_prof) array_push($userPermissions, "prof");
	if ($is_admin) array_push($userPermissions, "admin");
	if ($is_sysop) array_push($userPermissions, "sysop");
	if ($is_ta) array_push($userPermissions, "ta");
		
	//echo "authenticate.php ran! <br>";
	$returnArray = array(
		"isAuth" => $isAuth, // or false
		"userPermissions" => $userPermissions,
	);
	return $returnArray;
}



?>

