<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__ROOT_DIR__ . "authentication/encryption.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Get form content ==================================
if (__DEBUG__) echo "Content of POST is: \n";
if (__DEBUG__) print_r($_POST);

$newStudentID = "";
if (isset($_POST["user-studentid"])) {
	$newStudentID = $_POST["user-studentid"];
	if (__DEBUG__) echo "New studentid is: $newStudentID\n";
}
$newUsername = "";
if (isset($_POST["user-username"])) {
	$newUsername = $_POST["user-username"];
	if (__DEBUG__) echo "New username is: $newUsername\n";
}
$newPassword = "";
if (isset($_POST["user-password"])) {
	$newPassword = decrypt($_POST["user-password"]);
	if (__DEBUG__) echo "New password is: $newPassword\n";
}
$newFirstname = "";
if (isset($_POST["user-firstname"])) {
	$newFirstname = $_POST["user-firstname"];
	if (__DEBUG__) echo "New firstname is: $newFirstname\n";
}
$newLastname = "";
if (isset($_POST["user-lastname"])) {
	$newLastname = $_POST["user-lastname"];
	if (__DEBUG__) echo "New lastname is: $newLastname\n";
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
if ($newStudentID == "" || $newUsername == "" || $newPassword == "" || $newFirstname == "" || $newLastname == "" || $newEmail == "" || $newRole == "") {
	echo "Please enter values for all required fields.\n";
	return;
}
// Input are correct format (email format, role exists)
if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL) || !($newRole=="student"||$newRole=="ta"||$newRole=="prof")) {
	inputValueError();
	return;
}

// ================================== Preparing to send to Python ==================================
$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/add_user.py "

. ' --new_student_id ' . escapeshellarg($newStudentID)
. ' --new_username '   . escapeshellarg($newUsername)
. ' --new_password '   . escapeshellarg($newPassword)
. ' --new_firstname '  . escapeshellarg($newFirstname)
. ' --new_lastname '   . escapeshellarg($newLastname)
. ' --new_email '      . escapeshellarg($newEmail)
. ' --new_is_admin '   . escapeshellarg($newIsAdmin)
. ' --new_is_sysop '   . escapeshellarg($newIsSysop);
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec(escapeshellcmd($command) , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "The user has not been added.\n";
	return;
}

// ================================== Finally, done ==================================

echo("The user has been added.\n");

?>