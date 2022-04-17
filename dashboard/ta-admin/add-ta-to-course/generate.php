<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/add_ta_utils.php");
$tasList = getAllTAs();
$coursesList = getAllCourses();

if (__DEBUG__) echo "The TA list is: ";
if (__DEBUG__) print_r($tasList) . "<br>\n";
if (__DEBUG__) echo "The courses list is: ";
if (__DEBUG__) print_r($coursesList) . "<br>\n";

// Print appropriate message if either no courses or no tas
if ($tasList == null || sizeof($tasList) == 0) {
	echo "<h1>There are no TAs registered in the system!</h1>";
	return;
}
if ($coursesList == null || sizeof($coursesList) == 0) {
	echo "<h1>There are no courses registered in the system!</h1>";
	return;
}

$_SESSION["add_ta_to_course_taslist"] = $tasList;
$_SESSION["add_ta_to_course_courseslist"] = $coursesList;

// Templates
$tasDropdownFrame = '
<div class="content-box-element labeled-field-container">
	<div class="labeled-field-label">TA Name</div>
	<select class="labeled-field-field" id="ta-select" name="ta-select">
		<option selected disabled>Please select a TA</option>
		%s
	</select>
</div>
';

$tasDropdownEntryTemplate = '<option value="%s">%s</option>';

// The following set are almost identical and could be combined, but are 
// kept separate in case we want to modify one in the future.
$coursesDropdownFrame = '
<div class="content-box-element labeled-field-container">
	<div class="labeled-field-label">Add TA to Course</div>
	<select class="labeled-field-field" id="course-select" name="course-select">
		<option selected disabled>Please select a course and term</option>
		%s
	</select>
</div>
';
$coursesDropdownEntryTemplate = '<option value="%s">%s</option>';

echo '<form id="add-ta-to-course-form" >';

// Actually building the dropdowns
$tasDropdownEntries = "";
foreach ($tasList as $idx => $ta) {
	$tasDropdownEntries = $tasDropdownEntries . sprintf($tasDropdownEntryTemplate, $idx, $ta[1]); //[0]: studentid, [1]: name
}
echo sprintf($tasDropdownFrame, $tasDropdownEntries);

// Actually building the dropdowns
$coursesDropdownEntries = "";
foreach ($coursesList as $idx => $course) {
	$coursesDropdownEntries = $coursesDropdownEntries . sprintf($coursesDropdownEntryTemplate, $idx, $course[1]); //[0]: studentid, [1]: name
}
echo sprintf($coursesDropdownFrame, $coursesDropdownEntries);

?>

<div class="content-box-element labeled-field-container">
	<div class="labeled-field-label">Assigned Hours</div>
	<input class="labeled-field-field" type="number" min="0" min="10" name="assigned-hours" id="assigned-hours" required>
</div>

<div class="content-box-element">
	<button class="button positive-button" id="submit" type="submit" value="submit">Submit</button>
</div>


</form>
