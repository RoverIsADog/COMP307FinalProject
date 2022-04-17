<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ================================== Session integrity check ==================================

$tasList = null;
if (isset($_SESSION["add_ta_to_course_taslist"])) $tasList = $_SESSION["add_ta_to_course_taslist"];
else {
	genericError();
	echo "Session corrupted 1\n";
	return;
}

$coursesList = null;
if (isset($_SESSION["add_ta_to_course_courseslist"])) $coursesList = $_SESSION["add_ta_to_course_courseslist"];
else {
	genericError();
	echo "Session corrupted 2\n";
	return;
}

$username = "defaultUsername";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else {
	genericError();
	echo "Username not in session\n";
	// return;
}

$ticketID = "defaultTicket";
if (isset($_SESSION["ticket"])) $ticketID = $_SESSION["ticket"];
else {
	genericError();
	echo "Ticket not in session\n";
	// return;
}

// ================================== Get form content ==================================
if (__DEBUG__) echo "Content of POST is: \n" . print_r($_POST);
$chosenCourseNum = "";
if (isset($_POST["ta-select"])) {
	$chosenCourseNum = $_POST["ta-select"];
	if (__DEBUG__) echo "Chosen Course number is: $chosenCourseNum\n";
}
$chosenTANum = "";
if (isset($_POST["course-select"])) {
	$chosenTANum = $_POST["course-select"];
	if (__DEBUG__) echo "Chosen TA number is: $chosenTANum\n";
}
$assignedHours = "";
if (isset($_POST["assigned-hours"])) {
	$assignedHours = $_POST["assigned-hours"];
	if (__DEBUG__) echo "Chosen assigned hours is: $assignedHours\n";
}

// ================================== Inputs validation ==================================

// Input exists
if ($chosenTANum == "" || $chosenCourseNum == "" || $assignedHours == "") {
	echo "Please enter values for all required fields.\n";
	return;
}
// Input are correct format
if (!is_numeric($assignedHours) || intval($assignedHours) < 10) {
	inputValueError();
	return;
}
// Input Security Check
if (!key_exists($chosenCourseNum, $coursesList) || !key_exists($chosenTANum, $tasList)) {
	doesNotExist();
	return;
}

// ================================== Preparing to send to Python ==================================
$taID = $tasList[$chosenTANum][0];
$taName = $tasList[$chosenTANum][1];
$termMonthYear = $coursesList[$chosenCourseNum][1]; // [0]: courseid, [1]: term
$courseID = $coursesList[$chosenCourseNum][0];



$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/add_ta_to_course.py "
. " --username " . "\"$username\""
. " --ticket_id " . "\"$ticketID\""

. ' --name ' . "\"$taName\""
. ' --student_id ' . "\"$taID\""
. ' --term_month_year ' . "\"$termMonthYear\""
. ' --course_num ' . "\"$courseID\""
. ' --assigned_hours ' . "\"$assignedHours\"";
if (__DEBUG__) echo "Submitting task to python: " . $command;
exec(escapeshellcmd($command) , $output, $retval);

if ($retval != 0) {
	genericError();
	return;
}

// ================================== Finally, done ==================================

echo("The student has been assigned to the course.");


?>