<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the ta_info_history page. <br>\n";

// Get all TAs in the dropdown
require(__DIR__ . "/get_all_tas.php");
$taslist = getAllTAs();

if (sizeof($taslist) == 0) {
	echo "<h2>There are no TAs in the database!</h2>";
	return;
}

// Build the dropdown

$taDropdownContainer = '
<select name="ta-select" id="ta-select" onchange="selectedCourseTerm(this.value)">
	<option value="NONE" selected disabled>Please select a TA</option>
	%s
</select>
';
$taDropdownOption = '<option value="%s">%s</option>';

$optionsStr = "";
// Recall, list of list containing info
foreach ($taslist as $idx => $val) {
	$optionsStr = $optionsStr . sprintf($taDropdownOption, $idx, $val[1]);
}

$_SESSION["ta_info_history_taslist"] = $taslist; // Saving for input validation
echo sprintf($taDropdownContainer, $optionsStr);

?>

<div id="ta-info-container"></div>

