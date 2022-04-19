<?php
// Use __ROOT_DIR__ to refer to root directory from here
require_once(__DIR__ . "/../rootpath.php");
if (!isset($_SESSION)) session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * This function returns a list consisting of these entries:
 *    - 'isAuth' => username & ticket valid or not?
 *    - 'userPermissions' => 
 * EFFECTS/OUTPUTS:
 * 	This function should set $loggerIn to the correct value. No output.
*/
function authenticate():array {
	
	if (__DEBUG__) consoleLog("(authenticate.php) The content of the session is: \n");
	if (__DEBUG__) consoleLog(print_r($_SESSION, true));

	// ================================== Session integrity check ==================================
	// Primary session authentication
	$username = null; $ticket_id = null;
	if (isset($_SESSION['ticket'])) $ticket_id = $_SESSION['ticket'];
	if (isset($_SESSION['username'])) $username = $_SESSION['username'];

	// Backup cookie authentication
	if ($username == null || $ticket_id == null) {
		if (isset($_COOKIE['ticket'])) $ticket_id = $_COOKIE['ticket'];
		if (isset($_COOKIE['username'])) $ticket_id = $_COOKIE['username'];
	}

	// No username/tickets, do not allow entry
	if ($username == null || $ticket_id == null) {
		if (__DEBUG__) echo "FORBIDDEN: No ticket or username<br>\n";
		return array(
			'isAuth' => false,
			'userPermissions' => null,
		);
	}

	// ================================== Validate Username & Ticket ==================================
	// Use python to verify ticket
	$output = null; $exitCode = null;
	$command = escapeshellcmd( 'python3 ' . __ROOT_DIR__ . 'authentication/validate_ticket.py '
		. ' --username '  . escapeshellarg($username)
		. ' --ticket_id ' . escapeshellarg($ticket_id))
		. ' 2>&1';
	if (__DEBUG__) echo "Verifying ticket: $command<br>\n";
	exec($command, $output, $exitCode);
	
	// Ticket or username invalid
	if ($exitCode != 0) {
		if (__DEBUG__) echo "FORBIDDEN: Ticket invalid<br>\n";
		return array(
			'isAuth' => false,
			'userPermissions' => null,
		);
	}

	// ================================== Ticket valid: Get user permissions ==================================
	/**
	 * Outputs a list of 5 ones or zeroes. [0]: isStudent, [1]: isProf, [2]: isAdmin [3]: isSysop [4]: isTA
	 * There are no specified exit codes.
	 */
	$output = null; $exitCode = null;
	$command = escapeshellcmd('python3 ' . __ROOT_DIR__ . 'authentication/get_user_roles.py '
		. ' --username ' . escapeshellarg($username))
		. ' 2>&1';
	if (__DEBUG__) echo "Command: $command<br>\n";
	exec($command, $output, $exitCode);

	if ($exitCode != 0) {
		genericError();
	}
	
	// Building list (not very efficient but okay for now)
	$is_student = $output[0];
	$is_prof    = $output[1];
	$is_admin   = $output[2];
	$is_sysop   = $output[3];
	$is_ta      = $output[4];
	
	$userPermissions = array();
	if ($is_student || $is_ta) array_push($userPermissions, "student"); // TAs are also students
	if ($is_prof) array_push($userPermissions, "prof");
	if ($is_admin) array_push($userPermissions, "admin");
	if ($is_sysop) array_push($userPermissions, "sysop");
	if ($is_ta) array_push($userPermissions, "ta");
		
	return array(
		"isAuth" => true,
		"userPermissions" => $userPermissions,
	);
}



?>

