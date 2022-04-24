<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// ================================== Input validation ==================================
// Inputs exist
if ($username == "" || $chosenCourse == "" || $chosenTerm == "") {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	return;
}

// ================================== Preparing to call python ==================================

$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/get_curr_wishlist.py "
. ' --username '               . escapeshellarg($username)
. ' --course_num '             . escapeshellarg($chosenCourse)
. ' --term_month_year '        . escapeshellarg($chosenTerm))
. ' 2>&1';
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "Python script failure";
	return;
}

if (__DEBUG__) echo "Python output: <br>\n";
if (__DEBUG__) echo nl2br(print_r($output, true));

// ================================== Building the table ==================================
echo '<h1>Current Wishlist</h1>';

if (sizeof($output) == 0) {
	echo "<h2>Empty</h2>";
}
else {
	$tableFrame = '
	<table>
		%s
	</table>
	';
	$tableRowTemplate = '<tr><td>%s</td></tr>';
	$tableRows = "";
	foreach($output as $idx => $val) {
		$tableRows = $tableRows . sprintf($tableRowTemplate, $val);
	}
	echo sprintf($tableRowTemplate, $tableRows);
}



?>


