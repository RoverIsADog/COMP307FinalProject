<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// This section behaves almost normally, but loads a custom menu
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

echo "Hello!";

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

$instructorsList = null;
if (isset($_SESSION["oh_responsibilities_instructorlist"])) $instructorsList = $_SESSION["oh_responsibilities_instructorlist"];
else {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	exit();
}

// ================================== Input validation ==================================
// Inputs exits
if ($chosenCourse == "" || $chosenTerm == "" || $instructorsList == null) {
	genericError("(populate_fields.php) Some fields were missing <br>\n");
	return;
}
// Input Security Check
if (!key_exists($_POST["instructor-select"], $instructorsList)) {
	doesNotExist();
	return;
}

// ================================== Preparing to call python ==================================
$studentID = $instructorsList[$_POST["instructor-select"]]["student_id"];
$instructorJob = $_POST["instructor-job"];

$mondayStart = isset($_POST["have-oh-monday"]) ? $_POST["oh-monday-start"] : "";
$mondayEnd = isset($_POST["have-oh-monday"]) ? $_POST["oh-monday-end"] : "";

$tuesdayStart = isset($_POST["have-oh-tuesday"]) ? $_POST["oh-tuesday-start"] : "";
$tuesdayEnd = isset($_POST["have-oh-tuesday"]) ? $_POST["oh-tuesday-end"] : "";

$wednesdayStart = isset($_POST["have-oh-wednesday"]) ? $_POST["oh-wednesday-start"] : "";
$wednesdayEnd = isset($_POST["have-oh-wednesday"]) ? $_POST["oh-wednesday-end"] : "";

$thursdayStart = isset($_POST["have-oh-thursday"]) ? $_POST["oh-thursday-start"] : "";
$thursdayEnd = isset($_POST["have-oh-thursday"]) ? $_POST["oh-thursday-end"] : "";

$fridayStart = isset($_POST["have-oh-friday"]) ? $_POST["oh-friday-start"] : "";
$fridayEnd = isset($_POST["have-oh-friday"]) ? $_POST["oh-friday-end"] : "";

$notes = $_POST["notes"];

$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/update_instructor_info.py "

. ' --student_id '        . escapeshellarg($studentID)
. ' --course_num '        . escapeshellarg($chosenCourse)
. ' --term_month_year '   . escapeshellarg($chosenTerm)
. ' --job '               . escapeshellarg($instructorJob)
. ' --monday_start '      . escapeshellarg($mondayStart)
. ' --monday_end '        . escapeshellarg($mondayEnd)
. ' --tuesday_start '     . escapeshellarg($tuesdayStart)
. ' --tuesday_end '       . escapeshellarg($tuesdayEnd)
. ' --wednesday_start '   . escapeshellarg($wednesdayStart)
. ' --wednesday_end '     . escapeshellarg($wednesdayEnd)
. ' --thursday_start '    . escapeshellarg($thursdayStart)
. ' --thursday_end '      . escapeshellarg($thursdayEnd)
. ' --friday_start '      . escapeshellarg($fridayStart)
. ' --friday_end '        . escapeshellarg($fridayEnd)
. ' --notes '             . escapeshellarg($notes))
. ' 2>&1';
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "Python script failure";
	return;
}

// ================================== Done ==================================

echo "The instructor's information was updated.";

?>