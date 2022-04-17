<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

// ================================== Get form content ==================================
if (__DEBUG__) echo "Content of POST is: \n";
if (__DEBUG__) print_r($_POST);

$termMonthYear = "";
if (isset($_POST["term-month-year"])) {
	$termMonthYear = $_POST["term-month-year"];
	if (__DEBUG__) echo "New term/month/year is: $termMonthYear\n";
}
$courseNum = "";
if (isset($_POST["course-number"])) {
	$courseNum = $_POST["course-number"];
	if (__DEBUG__) echo "New coursenum is: $courseNum\n";
}
$courseName = "";
if (isset($_POST["course-name"])) {
	$courseName = $_POST["course-name"];
	if (__DEBUG__) echo "New coursename is: $courseName\n";
}
$instructorName = "";
if (isset($_POST["instructor-assigned"])) {
	$instructorName = $_POST["instructor-assigned"];
	if (__DEBUG__) echo "New instructor is: $instructorName\n";
}

// ================================== Inputs validation ==================================
// Input exists (except admin/sysop)
if ($termMonthYear == "" || $courseNum == "" || $courseName == "" || $instructorName == "") {
	echo "Please enter values for all required fields.\n";
	return;
}

// ================================== Preparing to send to Python ==================================
$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/manual_add_prof_course.py "
. ' --term_month_year '    . escapeshellarg($termMonthYear)
. ' --course_num '         . escapeshellarg($courseNum)
. ' --course_name '        . escapeshellarg($courseName)
. ' --instructor_name '    . escapeshellarg($instructorName);
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec(escapeshellcmd($command) , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "The course was not added.\n";
	return;
}

// ================================== Finally, done ==================================

echo("The course has been added.\n");

?>
