<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// echo "<h1>HELLO!</h1>"

// if (__DEBUG__) echo "The state of the session is: <br>\n";
// if (__DEBUG__) echo (print_r($_SESSION, true));

// ================================== Session integrity check ==================================

$tasList = null;
if (isset($_SESSION["remove_ta_from_course_taslist"])) $tasList = $_SESSION["remove_ta_from_course_taslist"];
else {
	genericError();
	echo "Session corrupted 1\n";
	return;
}

$coursesList = null;
if (isset($_SESSION["remove_ta_from_course_courseslist"])) $coursesList = $_SESSION["remove_ta_from_course_courseslist"];
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
if (__DEBUG__) echo "<b>The POST is: </b><br>\n";
if (__DEBUG__) print_r($_POST);

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

// ================================== Input validation ==================================
// Input exists
if ($chosenTANum == "" || $chosenCourseNum == "") {
	echo "Please enter values for all required fields.\n";
	return;
}
// Input Security Check
if (!key_exists($chosenCourseNum, $coursesList) || !key_exists($chosenTANum, $tasList)) {
	doesNotExist();
	return;
}

// ================================== Sending to Python ==================================
$taID = $tasList[$chosenTANum][0];
$taName = $tasList[$chosenTANum][1];
$termMonthYear = $coursesList[$chosenCourseNum][1]; // [0]: courseid, [1]: term
$courseID = $coursesList[$chosenCourseNum][0];

$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/remove_ta_assignment.py "
. " --username " . "\"$username\""
. " --ticket_id " . "\"$ticketID\""

. ' --student_id ' . "\"$taID\""
. ' --term_month_year ' . "\"$termMonthYear\""
. ' --course_num ' . "\"$courseID\"";
if (__DEBUG__) echo "Submitting task to python: " . $command . "<br>\n";
exec(escapeshellcmd($command) , $output, $retval);

if ($retval != 0) {
	genericError();
	return;
}

// ================================== Finally, done ==================================

echo("The student has been removed from the course.");

?>