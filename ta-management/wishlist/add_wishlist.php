<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (__DEBUG__) echo "The current POST is: <br>\n";
if (__DEBUG__) echo nl2br(print_r($_POST, true));

// ================================== Session integrity check ==================================
$username = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else {
	genericError("(current_wishlist.php) Session corrupted");
	exit();
}

$chosenCourse = "";
if (isset($_SESSION["management_chosen_course"])) $chosenCourse = $_SESSION["management_chosen_course"];
else {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	exit();
}

$chosenTerm = "";
if (isset($_SESSION["management_chosen_term"])) $chosenTerm = $_SESSION["management_chosen_term"];
else {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	exit();
}

$tasList = null;
if (isset($_SESSION["wishlist_taslist"])) $tasList = $_SESSION["wishlist_taslist"];
else {
	genericError("Session Corrupted");
	exit();
}

// ================================== Input validation ==================================
// Inputs exist
if ($username == "" || $chosenCourse == "" || $chosenTerm == "" || $tasList == null) {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	return;
}
$chosenTANum = $_POST["ta-select"];
if (!key_exists($chosenTANum, $tasList)) {
	inputValueError("The entered TA is not valid");
	exit();
}

$chosenTAID = $tasList[$chosenTANum]["student_id"];
if (__DEBUG__) "The chosen TA's ID is: <br>\n";
if (__DEBUG__) echo(print_r($chosenTAID));


// ================================== Finally, calling python ==================================
$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/add_to_wishlist.py "
. ' --username '               . escapeshellarg($username)
. ' --student_id '             . escapeshellarg($chosenTAID)
. ' --course_num '             . escapeshellarg($chosenCourse)
. ' --term_month_year '        . escapeshellarg($chosenTerm))
. ' 2>&1';
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval == 1) {
	echo '<script>alert("Did not add the comment as you are not an instructor for this course)</script>';
}
else if ($retval != 0) {
	genericError();
	echo "Python script failure";
	return;
}

if (__DEBUG__) echo "Python output: <br>\n";
if (__DEBUG__) echo nl2br(print_r($output, true));

ob_start();
header('Location: ../../management.php?page=wishlist');
ob_end_flush();
die();




