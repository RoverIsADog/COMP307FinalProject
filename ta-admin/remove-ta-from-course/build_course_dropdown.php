

<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__DIR__ . "/remove_ta_utils.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Get Inputs and Validations ==================================

$tasList = ""; // Get list of tas that was saved
if (isset($_SESSION["remove_ta_from_course_taslist"])) $tasList = $_SESSION["remove_ta_from_course_taslist"];
else {
	genericError();
	echo "Session corrupted";
}

$chosenTANum = "";
if (isset($_GET["dropdown_index"])) $chosenTANum = $_GET["dropdown_index"];
else {
	genericError();
	echo "Session corrupted";
}

if (__DEBUG__) echo "<b>The GET request is currently: </b><br>\n";
if (__DEBUG__) echo nl2br(print_r($_GET), true);

// Input exists
if ($chosenTANum == "") {
	echo "Please enter values for all required fields.\n";
	return;
}
// Input Security Check
if (!key_exists($chosenTANum, $tasList)) {
	doesNotExist();
	return;
}

require_once(__DIR__ . "/remove_ta_utils.php");
$coursesList = getAllCoursesForTA($tasList[$chosenTANum][0]);

if (__DEBUG__) echo "<b>The courseslist is: </b><br>\n";
if (__DEBUG__) echo print_r($coursesList);

// ================================== Print into select ==================================
echo '<h1>Select course to remove TA from</h1>';
$coursesDropdownFrame = '
<select class="content-box-element" name="course-select" id="course-select">
	<option value="NONE" selected disabled>Please select a Course</option>
	%s
</select>
';
$coursesDropdownEntryTemplate = '<option value="%s">%s [%s]</option>';

$coursesDropdownEntries = "";
foreach ($coursesList as $idx => $val) {
	$coursesDropdownEntries = $coursesDropdownEntries . sprintf($coursesDropdownEntryTemplate, $idx, $val[0], $val[1]); // [0]: courseid, [1]: term
}
echo sprintf($coursesDropdownFrame, $coursesDropdownEntries);

// Store into session for validation
$_SESSION["remove_ta_from_course_courseslist"] = $coursesList;

?>

<div class="content-box-element">
	<button class="button negative-button" id="submit" type="submit" value="submit">Remove</button>
</div>