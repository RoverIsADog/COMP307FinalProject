<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (__DEBUG__) echo "The content of POST is: \n";
if (__DEBUG__) nl2br(print_r($_GET));

// ================================== Session integrity check ==================================
$usersList = null;
if (isset($_SESSION["edit_user_userslist"])) $usersList = $_SESSION["edit_user_userslist"];
else {
	genericError();
	echo "Session corrupted 2\n";
	return;
}

// ================================== Get content ==================================
$chosenUserNum = "";
if (isset($_GET["dropdown_index"])) {
	$chosenUserNum = $_GET["dropdown_index"];
	if (__DEBUG__) echo "Chosen user number is: $chosenUserNum\n";
}

// ================================== Inputs validation ==================================
// Inputs exits
if ($chosenUserNum == "") {
	genericError();
	return;
}
// Input Security Check
if (!key_exists($chosenUserNum, $usersList)) {
	doesNotExist();
	return;
}

// ================================== Preparing to send to Python ==================================
$userStudentID = $usersList[$chosenUserNum]["student_id"];

$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/submit_changes.py "
. ' --student_id '     . escapeshellarg($userStudentID));
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "The user was not removed.\n";
	return;
}

// ================================== Finally, done ==================================

echo("The user has been deleted.\n");


?>