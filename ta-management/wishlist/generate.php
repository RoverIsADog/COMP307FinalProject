<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

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

// ================================== Getting the TAs ==================================
$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/get_tas.py "
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

// Put the list into more easily accessible format
$tasList = array();
foreach ($output as $idx => $val) {
	$tmp = str_getcsv($val);
	$tasList[$idx] = array();
	$tasList[$idx]["student_id"] = $tmp[0];
	$tasList[$idx]["name"] = $tmp[1];
}

if (__DEBUG__) echo "Readability Conversion: <br>\n";
if (__DEBUG__) echo nl2br(print_r($tasList, true));

// ================================== Build the dropdown ==================================

echo '<form action="ta-management/wishlist/add_wishlist.php" method="post" id="wishlist-form">';

$tasDropdownFrame = '
<select class="content-box-element" name="ta-select" id="ta-select">
	<option value="NONE" selected disabled>Please select a TA</option>
	%s
</select>
';
$tasDropdownEntryTemplate = '<option value="%s">%s</option>';

$tasDropdownEntries = "";
foreach ($tasList as $idx => $val) {
	$tasDropdownEntries = $tasDropdownEntries . sprintf($tasDropdownEntryTemplate, $idx, $val["name"]);
}

echo sprintf($tasDropdownFrame, $tasDropdownEntries);

// Save for input validation
$_SESSION["wishlist_taslist"] = $tasList;

?>

	<div class="content-box-element">
		<button class="button positive-button" id="submit" type="submit" value="submit">Add to Wishlist</button>
	</div>
	
</form>

<div id="current-wishlist" class="content-box-element">
	<?php
	// ================================== Building the table ==================================
	include_once(__DIR__ . "/current_wishlist.php");
	?>


</div>