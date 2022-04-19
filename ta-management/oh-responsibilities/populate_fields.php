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

$instructorsList = null;
if (isset($_SESSION["oh_responsibilities_instructorlist"])) $instructorsList = $_SESSION["oh_responsibilities_instructorlist"];
else {
	inputValueError();
	echo "<h2>Please select a course and term on the previous page.</h2>\n";
	exit();
}

$chosenInstructorNum = "";
if (isset($_GET["dropdown_index"])) {
	$chosenInstructorNum = $_GET["dropdown_index"];
	if (__DEBUG__) echo "Chosen instructor number is: $chosenInstructorNum<br>\n";
}

if (__DEBUG__) echo "(populateFields) The chosen course is $chosenCourse<br>\n";
if (__DEBUG__) echo "(populateFields) The chosen course is $chosenTerm<br>\n";
if (__DEBUG__) echo "(populateFields) The instructors list for that course is: <br>\n";
if (__DEBUG__) echo nl2br(print_r($instructorsList, true));

// ================================== Inputs validation ==================================
// Inputs exits
if ($chosenCourse == "" || $chosenTerm == "" || $instructorsList == null || $chosenInstructorNum == "") {
	genericError("(populate_fields.php) Some fields were missing <br>\n");
	return;
}
// Input Security Check
if (!key_exists($chosenInstructorNum, $instructorsList)) {
	doesNotExist();
	return;
}
$chosenInstructorID = $instructorsList[$chosenInstructorNum]["student_id"];

if (__DEBUG__) echo "The chosen instructor has ID: $chosenInstructorID<br>\n";

// ================================== Getting all information ==================================
$chosenInstInfo = getAllInstructorInfo($chosenInstructorID, $chosenCourse, $chosenTerm);
if (sizeof($chosenInstInfo) == 0) {
	genericError("Trying to access information about an instructor that is not in this course: $chosenInstructorID");
	return;
}


// ================================== Creating Text boxes ==================================
$jobTitleTemplate = '
<div class="content-box-element labeled-field-container">
	<div class="labeled-field-label">Job Details</div>
	<input class="labeled-field-field" type="text" name="instructor-job" id="instructor-job" value="%s">
</div>
';
echo sprintf($jobTitleTemplate, $chosenInstInfo["job_description"]);

// ================================== Office Hours ==================================
echo '<h1>Office Hours</h1>';
echo '<div class="content-box-element">Times in unchecked days will be ignored</div>';

echo '<div class="content-box-element oh-container">';

$dayEntryTempate = '
<label class="oh-day-container">
	<div class="oh-day-label">
		<input class="input-checkbox" type="checkbox" id="have-oh-%s" name="have-oh-%s" %s>
		<div>%s</div>
	</div>
	<div class="oh-day-field">
	<input class="input-time" type="time" name="oh-%s-end" value="%s">
	<span style="padding: 0 0.5em;"> to </span>
	<input class="input-time" type="time" name="oh-%s-start" value="%s">
	</div>
</label>
';

$daysList = array(
	"monday" => "Monday",
	"tuesday" => "Tuesday",
	"wednesday" => "Wednesday",
	"thursday" => "Thursday",
	"friday" => "Friday",
);

foreach($daysList as $lower => $upper) {
	$startTime = $chosenInstInfo[$lower . "_start"];
	$endTime = $chosenInstInfo[$lower . "_end"];
	$checked = $startTime == "" && $endTime == "" ? "" : "checked";
	echo sprintf($dayEntryTempate, $lower, $lower, $checked, $upper, $lower, $endTime, $lower, $startTime);
}

echo '</div>';

// ================================== Notes ==================================

echo '<h1>Notes</h1>';
$textboxTemplate = '<textarea class="spanning-textbox" type="text" name="notes" wrap="physical" value="">%s</textarea>';
echo sprintf($textboxTemplate, $chosenInstInfo["notes"]);



?>

<div class="content-box-element">
	<button class="button positive-button" id="update" type="submit" value="update">Update</button>
</div>
