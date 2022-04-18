<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Get all the TAs ==================================
require_once(__DIR__ . "/remove_ta_utils.php");
$tasList = getAllTAs();

if (__DEBUG__) echo print_r($tasList) . "<br>\n";

if ($tasList == null || sizeof($tasList) == 0) {
	echo "<h1>There are no TAs in the database!</h1>\n";
}

// ================================== Building TA dropdown ==================================

echo '<h1>Select TA to remove</h1>';
echo '<form id="remove-ta-form" name="remove-ta-form">';
$taDropdownFrame = '
<select class="content-box-element" name="ta-select" id="ta-select" onchange="selectedTA(this.value)">
	<option value="NONE" selected disabled>Please select a TA</option>
	%s
</select>
';
$taDropdownEntryTemplate = '<option value="%s">%s</option>';

$taDropdownEntries = "";
foreach($tasList as $idx => $ta) {
	$taDropdownEntries = $taDropdownEntries . sprintf($taDropdownEntryTemplate, $idx, $ta[1]); // [0]: id, [1]: name
}

echo sprintf($taDropdownFrame, $taDropdownEntries);

// Store for input validation
$_SESSION["remove_ta_from_course_taslist"] = $tasList;

?>

<div id="course-dropdown-container"></div>

</form>