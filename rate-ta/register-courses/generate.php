<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Getting the courses ==================================
$output = null; $retval = null;
$command = escapeshellcmd('python3 ' .  __DIR__ . '/get_all_courses.py') . ' 2>&1';
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "Python script failure";
	return;
}

if (__DEBUG__) echo "Python output: <br>\n";
if (__DEBUG__) echo nl2br(print_r($output, true));

// Put the list into more easily accessible format
$coursesList = array();
foreach ($output as $idx => $val) {
	$tmp = str_getcsv($val);
	$coursesList[$idx] = array();
	$coursesList[$idx]["course_num"] = $tmp[0];
	$coursesList[$idx]["course_name"] = $tmp[1];
	$coursesList[$idx]["term_month_year"] = $tmp[2];
}

// Stop here if the list is empty
if (sizeof($coursesList) == 0) {
	echo "<h2>There are no courses in the system!</h2>";
	return;
}

// Store the available choices to compare to output.
$_SESSION["register_courses_courseslist"] = $coursesList;

if (__DEBUG__) echo "List of courses for generation: \n";
if (__DEBUG__) print_r($coursesList);
if (__DEBUG__) echo print_r($_SESSION["register_courses_courseslist"], true);


// ================================== Building the dropdown ==================================
echo '<form action="" id="register-courses-form">';

$selectContainer = '
<!-- Course Select -->
<div id="register-courses-dropdown-container">
	<select id="register-courses-dropdown" name="register-courses-dropdown">
		<option value="NONE" selected disabled>Please select a course and term</option>
		%s
	</select>
</div>
';
$inputTemplate = '<option value="%s">%s [%s] %s</option>' . "\n";
$selectOptions = "";
foreach ($coursesList as $optionNum => $entry) {
	$selectOptions = $selectOptions . sprintf($inputTemplate, $optionNum, $entry["course_num"], $entry["term_month_year"], $entry["course_name"]);
}

echo sprintf($selectContainer, $selectOptions);

// ================================== Building the dropdown ==================================



?>

<div class="button-container"><button class="button positive-button" type="submit" value="register">Register</button></div>

</form>