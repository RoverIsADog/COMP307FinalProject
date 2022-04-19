<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__DIR__ . "/oh_responsibilities_utils.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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


// ================================== Input validation ==================================
// Inputs exist
if ($chosenCourse == "" || $chosenTerm == "") {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	return;
}

echo "Displaying information for: <b>$chosenCourse [$chosenTerm]</b>";

// ================================== Getting the instructors ==================================
$instructorsList = getAllInstructors($chosenCourse, $chosenTerm);
if (__DEBUG__) echo "The instructors list is <br>\n";
if (__DEBUG__) echo nl2br(print_r($instructorsList, true));

if ($instructorsList == null || sizeof($instructorsList) == 0) {
	echo "<h1>There are no instructor for this course in the system!</h1>\n";
	return;
}

// ================================== Printing dropdown ==================================
$instrDropdownFrame = '
<div class="heading1"><b>Choose an Instructor</b></div>
<select class="content-box-element" name="instructor-select" id="instructor-select" onchange="selectedInstructor(this.value)">
	<option value="NONE" selected disabled>Please select an instructor</option>
	%s
</select>
';
$instrDropdownEntryTemplate = '<option value="%s">%s</option>';
$instrDropdownEntries = "";
foreach ($instructorsList as $idx => $instr) {
	$instrDropdownEntries = $instrDropdownEntries . sprintf($instrDropdownEntryTemplate, $idx, $instr["name"]);
}
echo sprintf($instrDropdownFrame, $instrDropdownEntries);

// Save for input validation
$_SESSION["oh_responsibilities_instructor_list"] = $instructorsList;

?>

<form action="#" method="post">
	<div id="editable-elements-container"></div>
</form>