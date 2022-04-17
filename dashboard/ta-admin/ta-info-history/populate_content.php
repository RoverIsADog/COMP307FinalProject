<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// ================================== Session integrity check ==================================
$tasList = null;
if (isset($_SESSION["ta_info_history_taslist"])) $tasList = $_SESSION["ta_info_history_taslist"];
else {
	genericError();
	echo "Session corrupted\n";
	return;
}

$username = "defaultUsername";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else {
	genericError();
	echo "Username not in session\n";
	// return;
}

$ticketID = "defaultTicket";
if (isset($_SESSION["ticket"])) $ticketID = $_SESSION["ticket"];
else {
	genericError();
	echo "Ticket not in session\n";
	// return;
}

// ================================== Get TA choice ==================================
$chosenTANum = "";
if (isset($_GET["dropdown_index"])) $chosenTANum = $_GET["dropdown_index"];
else {
	echo "An error has occured\n";
	return;
}

// ================================== Input security check ==================================
if (!key_exists($chosenTANum, $tasList)) {
	doesNotExist();
	return;
}
$chosenTAID = $tasList[$chosenTANum][0]; // [1] is name

// ================================== Templates ==================================

$oneColTableContainer = '
<table>
	<tr><td class="column-name">%s</td></tr>
	%s
</table>
';
$oneColTableEntry = '<tr><td>%s</td></tr>';

$unbalancedTwoColTableContainer = '
<table>
		<tr>
			<th class="column-name" style="width: 10em;">%s</th>
			<th class="column-name">%s</th>
		</tr>
		%s
</table>
';

$balancedTwoColTableContainer = '
<table>
		<tr>
			<th class="column-name">%s</th>
			<th class="column-name">%s</th>
		</tr>
		%s
</table>
';

$fourColTableContainer = '
<table>
		<tr>
			<th class="column-name">%s</th>
			<th class="column-name">%s</th>
			<th class="column-name">%s</th>
			<th class="column-name">%s</th>
		</tr>
		%s
</table>
';

$unbalancedTwoColTableEntry = '
<tr>
	<th style="text-align: center;">%s</th>
	<th>%s</th>
</tr>
'; // NOT UNIVERSAL (only here, all 1st columns are centered)
$balancedTwoColTableEntry = '
<tr>
	<th style="text-align: center;">%s</th>
	<th style="text-align: center;">%s</th>
</tr>
';
$fourColTableEntry = '
<tr>
	<th style="text-align: center;">%s</th>
	<th style="text-align: center;">%s</th>
	<th style="text-align: center;">%s</th>
	<th>%s</th>
</tr>
';

// ================================== Wishlist Membership ==================================
// Execute python command (return list of prof names)
echo '<h1>Wishlisted by</h1>';
$command = "python3 " . __DIR__ . "/get_wishlist.py "
. " --username " . $username
. " --ticket_id " . $ticketID
. " --student_id " . $chosenTAID;
if (__DEBUG__) echo "Getting wishlist membership: $command<br>\n";
$output = null; $exitCode = null;
exec(escapeshellcmd($command), $output, $exitCode);
if ($exitCode != "0") {
	echo "Error loading wishlist<br>\n";
}
else {
	// No wishlist membership
	if (sizeof($output) == 0) {
		echo "<b>Not in any wishlist<b><br>\n";
	}
	// Display wishlist in a table
	else {
		$tableEntries = "";
		foreach($output as $idx => $entry) {
			$tmp = str_getcsv($entry);
			$tableEntries = $tableEntries . sprintf($oneColTableEntry, $tmp[0]);
		}
		echo sprintf($oneColTableContainer, "Professor Name", $tableEntries);
	}
}

// ================================== Current Assignment Details ==================================
// Execute python command (return list of {coursenum,term})
echo '<h1>Assigned To</h1>';
$command = "python3 " . __DIR__ . "/ta_assigned_courses.py "
. " --username " . $username
. " --ticket_id " . $ticketID
. " --student_id" . $chosenTAID;
if (__DEBUG__) echo "Getting Course assignment information: $command<br>\n";
$output = null; $exitCode = null;
exec(escapeshellcmd($command), $output, $exitCode);
if ($exitCode != "0") {
	echo "Error loading course assignmentn<br>\n";
}
else {
	// Not assigned to any course
	if (sizeof($output) == 0) {
		echo "<b>Not Assigned to any Course<b><br>\n";
	}
	// Display course and term information
	else {
		$tableEntries = "";
		foreach($output as $idx => $entry) {
			$tmp = str_getcsv($entry);
			$tableEntries = $tableEntries . sprintf($balancedTwoColTableEntry, $tmp[0], $tmp[1]);
		}
		echo sprintf($balancedTwoColTableContainer, "Course Number", "Term/Month/Year", $tableEntries);
	}
}

// ================================== Average details ==================================
// Execute python command (return list of {coursenum,term})
$command = "python3 " . __DIR__ . "/ta_review_avg.py "
. " --username " . $username
. " --ticket_id " . $ticketID
. " --student_id" . $chosenTAID;
if (__DEBUG__) echo "Getting ratings and average: $command<br>\n";
$output = null; $exitCode = null;
exec(escapeshellcmd($command), $output, $exitCode);
if ($exitCode != "0") {
	echo "Error loading ratings<br>\n";
}
else {
	// No reviews yet
	if (sizeof($output) == 0) {
		echo "<h1>No reviews yet<h1><br>\n";
	}
	// Display wishlist in a table
	else {
		$tableEntries = "";
		//for ($i = 0; $i < sizeof($output) - 1; $i++) {
		//	$
		//}
		foreach($output as $idx => $entry) {
			if ($idx == sizeof($output) - 1) break; // Last line is CSV
			$tmp = str_getcsv($entry);
			$tableEntries = $tableEntries . sprintf($unbalancedTwoColTableEntry, $tmp[0], $tmp[1]);
		}
		// Finally printing
		echo sprintf("<h1>Average Rating: %s</h1>", $output[sizeof($output) - 1]); // Average
		echo sprintf($unbalancedTwoColTableContainer, "Review Score", "Comments", $tableEntries);
	}
}

// ================================== Professor Performance Logs ==================================
// Execute python command (return list of {profName,coursenum,term,note})
echo '<h1>Professor Performance Logs</h1>';
$command = "python3 " . __DIR__ . "/get_ta_logs.py "
. " --username " . $username
. " --ticket_id " . $ticketID
. " --student_id" . $chosenTAID;
if (__DEBUG__) echo "Getting prof performance logs: $command<br>\n";
$output = null; $exitCode = null;
exec(escapeshellcmd($command), $output, $exitCode);
if ($exitCode != "0") {
	echo "Error loading prof performance logs<br>\n";
}
else {
	// Does not have any performance logs
	if (sizeof($output) == 0) {
		echo "<b>No performance logs yet.<b><br>\n";
	}
	// Display every log and information
	else {
		$tableEntries = "";
		foreach($output as $idx => $entry) {
			$tmp = str_getcsv($entry);
			$tableEntries = $tableEntries . sprintf($fourColTableEntry, $tmp[0], $tmp[1], $tmp[2], $tmp[3]);
		}
		echo sprintf($fourColTableContainer, "Professor", "Course Number", "Term/Month/Year", "Notes", $tableEntries);
	}
}


?>