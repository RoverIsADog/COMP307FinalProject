<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Session integrity check ==================================

echo '<h1>Course TA Assignment</h1>';

$tableEntryTemplate = '
<tr>
	<th class="center-row">%s</th>
	<th>%s</th>
</tr>
';

$tableFrame = '
<table>
	<tr>
		<th class="column-name">Course</th>
		<th class="column-name">Assigned TAs</th>
	</tr>
	%s
</tables>
';

// ================================== Wishlist Membership ==================================
// Execute python command (return list of prof names)
$command = escapeshellcmd("python3 " . __DIR__ . "/get_all_course_ta_assignments.py"); // No inputs
if (__DEBUG__) echo "Retrieving course TA records: $command<br>\n";
$output = null; $exitCode = null;
exec($command, $output, $exitCode);
if ($exitCode != "0") {
	echo "Error retrieving information<br>\n";
}
else {
	// Database returns empty
	if (sizeof($output) == 0) {
		echo "<h2>There are not any course TA assignments.<h2><br>\n";
	}
	// Print out into table
	else {
		$tableEntries = "";
		foreach($output as $idx => $entry) {
			$tmp = str_getcsv($entry);
			$courseStr = $tmp[0] . " [" . $tmp[1] . "]";
			$tableEntries = $tableEntries . sprintf($tableEntryTemplate, $courseStr, $tmp[2]);
		}
		echo sprintf($tableFrame, $tableEntries);
	}
}

?>