<?php
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "utils/cookies_utils.php");
if (isset($_SESSION)) {
	$success = session_destroy(); // Get rid of stuff from previous session
	if (!$success) {
		appendMsg("Failed to delete session\n");
	}
	unset($_SESSION);
}
deleteAllCookies();
if (!isset($_SESSION)) session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * This file is expected to be called from a POST request containing fields
 * 'username' and 'password'. It should return a JSON array of {[exitcode]: ? ,[message]: ?}
 *     exitcode: Exit code of the program (for JS to get and process)
 *     message: Any print statement so that JS can relay them to the console
 */

$retArr = array(
	"exitcode" => "",
	"message" => "",
);

function appendMsg($msg) {
	global $retArr;
	$retArr["message"] = $retArr["message"] . $msg;
}

if (__DEBUG__) appendMsg("The initial content of the session is: \n");
if (__DEBUG__) appendMsg(print_r($_SESSION, true));
if (__DEBUG__) appendMsg("The initial content of POST is: \n");
if (__DEBUG__) appendMsg(print_r($_POST, true));
$username = $_POST['username'];
$password = $_POST['password'];

// ================================== Field(s) Empty ==================================
if (empty($username) || empty($password)) {
	$retArr["exitcode"] = "1";
	echo json_encode($retArr);
	exit();
}

// ================================== Call to python ==================================
/**
 * Checks for the user in the database and returns a JSON file with fields "username"
 * and "ticket" for the newly created ticket. Exit codes:
 *   0: Authentication succeeded. New ticket in "username"
 *   1: No user with provided username and password combo. Ignore output.
 */
$output = null; $exitCode = null;
$command = escapeshellcmd("python3 " . __ROOT_DIR__ . "authentication/verify_login.py"
	. " --username " . escapeshellarg($username)
	. " --password " . escapeshellarg($password))
	. " 2>&1";
if (__DEBUG__) appendMsg("Command: $command\n");
exec($command, $output, $exitCode);

if (__DEBUG__) appendMsg("The output was: \n");
if (__DEBUG__) appendMsg((print_r($output, true)));
if (__DEBUG__) appendMsg("The exit code was: $exitCode\n");

// No user with that name/password combination
if ($exitCode != 0) {
	$retArr["exitcode"] = "2";
	echo json_encode($retArr);
	exit();
}

// ================================== Call to python ==================================
$ticket = json_decode($output[0], true);

if (__DEBUG__) appendMsg("The ticket consists of: \n");
if (__DEBUG__) appendMsg(print_r($ticket, true));
if (__DEBUG__) appendMsg("The output consists of: \n");
if (__DEBUG__) appendMsg(print_r($output[0], true));

// Dual saving just in case
$_SESSION['ticket'] = $ticket["ticket_id"];
$_SESSION['username'] = $ticket["username"];
setcookie("ticket", $ticket["ticket_id"], 0, "/");
setcookie("username", $ticket["username"], 0, "/");

if (__DEBUG__) appendMsg("The session consists of: \n");
if (__DEBUG__) appendMsg(print_r($_SESSION, true));

// Session set, let them through
$retArr["exitcode"] = "0";
echo json_encode($retArr);
exit();

?>