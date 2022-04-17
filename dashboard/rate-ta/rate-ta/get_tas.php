<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/**
 * THIS FILE IS NOT PART OF THE CONTENT GENERATION SCRIPT.
 * Given a value (index in localstorage.rate_ta_courseslist), verify
 * that the value is allowed, then build the dropdown for TAs
 * corresponding to that course.
 * 
 * Relevant inputs:
 * Session->"rate_ta_courseslist" : csv string of course_num,term_month_year
 * 
 */

if(__DEBUG__) echo "get_tas.php ran!<br>\n";

// Get user's dropdown choice and validate for security.
if (!key_exists("dropdown_index", $_GET)) {
	genericError();
	return;
}
$optionNum = $_GET["dropdown_index"];

if (!key_exists("rate_ta_courseslist", $_SESSION) || !key_exists($optionNum, $_SESSION["rate_ta_courseslist"])) {
	if(__DEBUG__) echo "get_tas.php SESSION ERROR. Not in session. \n";
	doesNotExist();
	return;
}

// DEBUG
// if(__DEBUG__) echo "<b>The current state of the session is:</b><br>\n";
// if(__DEBUG__) echo print_r($_SESSION) . "<br>\n";
if(__DEBUG__) echo "<b>The current state of the rate_ta_courseslist is:</b><br>\n";
if(__DEBUG__) echo print_r($_SESSION["rate_ta_courseslist"]) . "<br>\n";
if(__DEBUG__) echo "<b>The current state of dropdown_index is:</b><br>\n";
if(__DEBUG__) echo $optionNum. "<br>\n";

$chosenOption = str_getcsv($_SESSION["rate_ta_courseslist"][$optionNum]);

// Run the command. Output: list of csv lines of studentid,taname
$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/get_tas.py "
	. "--course_num"      . escapeshellarg($chosenOption[0])
	. "--term_month_year" . escapeshellarg($chosenOption[1]);
if (__DEBUG__) echo "Getting every TA for course: $command <br>\n";
exec(escapeshellcmd($command) , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "Error retrieving TAs for the given course<br>\n";
	exit();
}

// Storing possible values for security & input validation
$_SESSION["rate_ta_taslist"] = $output;

// Container for the select
$selectFrame = '
<select id="rate-ta-dropdown" name="ta-select-dropdown" onchange="selectedTA(this.value)">
<option value="NONE" selected disabled>Please select a TA for the course</option>
%s
</select>
';

// Template for an individual choice
$selectChoice = '<option value="%s">%s</option>';
$allSelects = "";

if(__DEBUG__) echo "The output of get_tas.py is: <br>\n";
if(__DEBUG__) echo print_r($output) . "<br>\n";

// Create the list of options
foreach ($output as $optionNum => $entry) {
	$curLine = str_getcsv($entry);
	$allSelects = $allSelects . sprintf($selectChoice, $optionNum, $curLine[1]);
}

// Insert list of options into the container
echo sprintf($selectFrame, $allSelects);

?>