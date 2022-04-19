<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$retArr = array(
	"exitcode" => "",
	"message" => "",
);

/**
 * This file is expected to be called from a POST request containing many fields (see register.html)
 * It should return a JSON array of {[exitcode]: ? ,[message]: ?} 
 *     exitcode: Exit code of the program (for JS to get and process)
 *     message: Any print statement so that JS can relay them to the console
 */

function appendMsg($msg) {
	global $retArr;
	$retArr["message"] = $retArr["message"] . $msg;
}

if (__DEBUG__) appendMsg("The initial content of the session is: \n");
if (__DEBUG__) appendMsg(print_r($_SESSION, true) . "\n");
if (__DEBUG__) appendMsg("The initial content of POST is: \n");
if (__DEBUG__) appendMsg(print_r($_POST, true) . "\n");

$username = $_POST['user-username'];
$studentid = $_POST['user-studentid'];
$first_name = $_POST['user-firstname'];
$last_name = $_POST['user-lastname'];
$email = $_POST['user-email'];
$password = $_POST['user-password'];
$password_confirm = $_POST['user-confirm-password'];
$role = $_POST['user-role'];

appendMsg("Checkpoint 1\n");
appendMsg(print_r($_POST, true));

// ================================== Field(s) Empty ==================================
if (empty($username) || empty($password) || empty($password_confirm) || empty($email) || empty($studentid) || empty($first_name) || empty($last_name) || empty($role)) {
	$retArr["exitcode"] = 8;
	appendMsg("Some of the fields were left empty.\n");
	echo json_encode($retArr);
	return;
//		header("Refresh:0");
}

// ================================== Call to python ==================================
/**
 * We only care about the python program's exit code.
 */
$output = null; $exitCode = null;
$command = escapeshellcmd('python3 ' . __ROOT_DIR__ . 'authentication/register_user.py '
	. ' --username '           . escapeshellarg($username)
	. ' --password '           . escapeshellarg($password)
	. ' --confirm_password '   . escapeshellarg($password_confirm)
	. ' --email '              . escapeshellarg($email)
	. ' --student_id '         . escapeshellarg($studentid)
	. ' --first_name '         . escapeshellarg($first_name)
	. ' --last_name '          . escapeshellarg($last_name)
	. ' --role '               . escapeshellarg($role))
	. ' 2>&1';
if (__DEBUG__) appendMsg("Command: $command\n");
exec($command, $output, $exitCode);

if (__DEBUG__) appendMsg("The output was: \n");
if (__DEBUG__) appendMsg((print_r($output, true)));
if (__DEBUG__) appendMsg("The exit code was: $exitCode\n");


$retArr["exitcode"] = $exitCode;
echo json_encode($retArr);
exit();

// Success
if ($exitCode == 0) {
	$retArr["exitcode"] = 0;
	echo json_encode($retArr);
	exit();
}
// Credential Entry
else if ($exitCode == 1 || $exitCode == 2 || $exitCode == 3) {
	$retArr["exitcode"] = 1;
	echo json_encode($retArr);
	exit();
}

// Passwords don't match
else if ($exitCode == 4) {
	$retArr["exitcode"] = 4;
	echo json_encode($retArr);
	exit();
}

// Could not grant your requested role
else if ($exitCode == 5 || $exitCode == 6) {
	$retArr["exitcode"] = 5;
	echo json_encode($retArr);
	exit();
}

// Generic error
else if ($exitCode == 7) {
	$retArr["exitcode"] = 7;
	echo json_encode($retArr);
	exit();
}


?>