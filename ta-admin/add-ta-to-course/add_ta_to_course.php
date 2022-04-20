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

if (__DEBUG__) echo "The TA list is: \n";
if (__DEBUG__) echo print_r($tasList);

if (__DEBUG__) echo "The Courses list is: \n";
if (__DEBUG__) echo print_r($coursesList);


// ================================== Get form content ==================================
if (__DEBUG__) echo "Content of POST is: \n" . print_r($_POST, true);
$chosenTANum = "";
if (isset($_POST["ta-select"])) {
	$chosenTANum = $_POST["ta-select"];
	if (__DEBUG__) echo "Chosen TA number is: $chosenTANum\n";
}
$chosenCourseNum = "";
if (isset($_POST["course-select"])) {
	$chosenCourseNum = $_POST["course-select"];
	if (__DEBUG__) echo "Chosen Course number is: $chosenCourseNum\n";
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
$command = escapeshellcmd("python3 " .  __DIR__ . "/add_ta_to_course.py "

. ' --name '              . escapeshellarg($taName)
. ' --student_id '        . escapeshellarg($taID)
. ' --term_month_year '   . escapeshellarg($termMonthYear)
. ' --course_num '        . escapeshellarg($courseID)
. ' --assigned_hours '    . escapeshellarg($assignedHours));
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	return;
}

// ================================== Finally, done ==================================

echo("The student has been assigned to the course.");


?>