<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (__DEBUG__) echo "The content of POS is <br>\n";
if (__DEBUG__) echo nl2br(print_r($_POST));

// ================================== Session integrity check ==================================
$username = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else {
	genericError("(add_registered_course.php) Session corrupted");
	exit();
}

$chosenCourseNum = "";
if (isset($_POST["register-courses-dropdown"])) $chosenCourseNum = $_POST["register-courses-dropdown"];
else {
	genericError("(add_registered_course.php) Session corrupted");
	exit();
}

$coursesList = null;
if (isset($_SESSION["register_courses_courseslist"])) $coursesList = $_SESSION["register_courses_courseslist"];
else {
	genericError();
	echo "Session corrupted 1\n";
	return;
}

// ================================== Input Security Check ==================================
if (__DEBUG__) echo "The chosencoursenum is: $chosenCourseNum \n";
if (__DEBUG__) echo "The coursesList is: \n";
if (__DEBUG__) echo (print_r($coursesList, true));

if (!key_exists($chosenCourseNum, $coursesList)) {
	doesNotExist();
	return;
}

// Inputs exist
if ($chosenCourseNum == "" || $username == "") {
	echo "Please enter values for all required fields\n";
	return;
}

// ================================== Sending to python ==================================
$chosenCourseID = $coursesList[$chosenCourseNum]["course_num"];
$chosenTerm = $coursesList[$chosenCourseNum]["term_month_year"];


// Output: list of csv lines of studentid,taname
$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/add_registered_course.py "
	. ' --username '        . escapeshellarg($username)
	. ' --course_num '      . escapeshellarg($chosenCourseID)
	. ' --term_month_year ' . escapeshellarg($chosenTerm))
	. ' 2>&1';
if (__DEBUG__) echo "Registering to course: " . $command . "<br>\n";
exec($command , $output, $retval);


if ($retval != 0) {
	genericError();
	echo "Some error prevented you from registering\n";
	return;
}

// ================================== Final Output ==================================
echo "Your have been registered to $chosenCourseID [$chosenTerm].";

?>