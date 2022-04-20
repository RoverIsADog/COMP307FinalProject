<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// This section behaves almost normally, but loads a custom menu
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

if (__DEBUG__) echo "The content of POST is: <br>\n";
if (__DEBUG__) echo nl2br(print_r($_POST, true));
// ================================== Session integrity check ==================================
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
if (isset($_SESSION["add_performance_log_taslist"])) $tasList = $_SESSION["add_performance_log_taslist"];
else {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	exit();
}

$username = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else {
	genericError();
	echo "Session corrupted\n";
	exit();
}

// ================================== Input validation ==================================
// Inputs exits
if ($username == "" || $chosenCourse == "" || $chosenTerm == "" || $tasList == null) {
	genericError("(add_performance_log.php) Some fields were missing <br>\n");
	return;
}
// Input Security Check
if (!key_exists($_POST["ta-select"], $tasList)) {
	doesNotExist();
	return;
}
$chosenTA = $tasList[$_POST["ta-select"]]["student_id"];


// ================================== Preparing to call python ==================================
$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/add_performance_log.py "
. ' --username '          . escapeshellarg($username)
. ' --student_id '        . escapeshellarg($chosenTA)
. ' --course_num '        . escapeshellarg($chosenCourse)
. ' --term_month_year '   . escapeshellarg($chosenTerm)
. ' --comment '           . escapeshellarg($_POST["comment"]))
. ' 2>&1';
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "Python script failure";
	return;
}

?>