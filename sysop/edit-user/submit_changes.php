<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// ================================== Session integrity check ==================================

$usersList = null;
if (isset($_SESSION["edit_user_userslist"])) $usersList = $_SESSION["edit_user_userslist"];
else {
	genericError();
	echo "User list not in session\n";
	// return;
}

// ================================== Get form content ==================================
if (__DEBUG__) echo "Content of POST is: \n";
if (__DEBUG__) print_r($_POST);

$selectedUserNum = "";
if (isset($_POST["user-select"])) {
	$selectedUserNum = $_POST["user-select"];
	if (__DEBUG__) echo "New studentid is: $selectedUserNum\n";
}
$newFullName = "";
if (isset($_POST["user-fullname"])) {
	$newFullName = $_POST["user-fullname"];
	if (__DEBUG__) echo "New fullname is: $newFullName\n";
}
$newEmail = "";
if (isset($_POST["user-email"])) {
	$newEmail = $_POST["user-email"];
	if (__DEBUG__) echo "New email is: $newEmail\n";
}
$newRole = "";
if (isset($_POST["user-role"])) {
	$newRole = $_POST["user-role"];
	if (__DEBUG__) echo "New role is: $newRole\n";
}
$newIsAdmin = "0";
if (isset($_POST["permission-admin"])) {
	$newIsAdmin = "1";
}
if (__DEBUG__) echo "The user is an admin: $newIsAdmin\n";
$newIsSysop = "0";
if (isset($_POST["permission-sysop"])) {
	$newIsSysop = "1";
}
if (__DEBUG__) echo "The user is a sysop: $newIsSysop\n";

// ================================== Inputs validation ==================================
// Input exists (except admin/sysop)
if ($newFullName == "" || $newEmail == "" || $newRole == "") {
	echo "Please enter values for all required fields.\n";
	return;
}
// Input are correct format (email format, role exists)
if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
	inputValueError("The email is incorrectly formatted");
	return;
}
if (!($newRole=="student"||$newRole=="ta"||$newRole=="prof")) {
	doesNotExist("The selected role is invalid");
	return;
}
// Input Security Check
if (!key_exists($selectedUserNum, $usersList)) {
	doesNotExist();
	return;
}

// ================================== Preparing to send to Python ==================================
$userStudentID = $usersList[$selectedUserNum]["student_id"];

// ================================== Preparing to send to Python ==================================
$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/submit_change.py "

. ' --student_id '     . escapeshellarg($userStudentID)
. ' --name '           . escapeshellarg($newFullName)
. ' --email '          . escapeshellarg($newEmail)
. ' --role '           . escapeshellarg($newRole)
. ' --is_admin '       . escapeshellarg($newIsAdmin)
. ' --is_sysop '       . escapeshellarg($newIsSysop));
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "The changes were not saved.\n";
	return;
}

// ================================== Finally, done ==================================

echo("The user has been modified.\n");

?>
