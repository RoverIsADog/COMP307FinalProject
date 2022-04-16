<?php
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// DEBUG
// if (__DEBUG__) echo "The content of the POST request is: <br>\n";
// if (__DEBUG__) print_r($_POST) . "<br>\n";
// if (__DEBUG__) echo "<br>\n<br>\n<br>\n";
// if (__DEBUG__) echo "The content of the session is: <br>\n";
// if (__DEBUG__) print_r($_SESSION) . "<br>\n";

// Session integrity check
$coursesList = null;
if (isset($_SESSION["rate_ta_courseslist"])) $coursesList = $_SESSION["rate_ta_courseslist"];
else {
	genericError();
	echo "Session corrupted 1\n";
	return;
}

$tasList = null;
if (isset($_SESSION["rate_ta_taslist"])) $tasList = $_SESSION["rate_ta_taslist"];
else {
	genericError();
	echo "Session corrupted 2\n";
	return;
}

$username = "defaultUsername";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else {
	genericError();
	echo "Password not in session\n";
	// return;
}

$ticketID = "defaultTicket";
if (isset($_SESSION["ticket"])) $ticketID = $_SESSION["ticket"];
else {
	genericError();
	echo "Ticket not in session\n";
	// return;
}

// Get form content
$chosenCourseNum = "";
if (isset($_POST["rate-courses-dropdown"])) {
	$chosenCourseNum = $_POST["rate-courses-dropdown"];
}
$chosenTANum = "";
if (isset($_POST["ta-select-dropdown"])) {
	$chosenTANum = $_POST["ta-select-dropdown"];
}
$numberStars = "";
if (isset($_POST["numberstars"])) {
	$numberStars = $_POST["numberstars"];
}
$comments = "";
if (isset($_POST["ratecomments"])) {
	$comments = $_POST["ratecomments"];
}

// Input Security Check
if (!key_exists($chosenCourseNum, $coursesList) || !key_exists($chosenTANum, $tasList)) {
	doesNotExist();
	return;
}

// Inputs exist
if ($chosenCourseNum == "" || $chosenTANum == "" || $numberStars == "") {
	echo "Please enter values for all required fields\n";
	return;
}

// Formatting python inputs
$chosenTAStudentID = str_getcsv($tasList[$chosenTANum])[0];
$tmp = str_getcsv($coursesList[$chosenCourseNum]);
$chosenCourseID = $tmp[0];
$chosenTerm = $tmp[1];


// Run the command. Output: list of csv lines of studentid,taname
$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/add_rating.py "
. " --username " . "\"$username\""
. " --ticket_id " . "\"$ticketID\""

. ' --course_num ' . "\"$chosenCourseID\""
. ' --term_month_year ' . "\"$chosenTerm\""
. ' --ta_id ' . "\"$chosenTAStudentID\""
. ' --score ' . "\"$numberStars\""
. ' --comment ' . "\"$comments\"";
exec(escapeshellcmd($command) , $output, $retval);
// if (__DEBUG__) echo $command . "<br>\n";

if ($retval != 0) {
	genericError();
	echo "Some error prevented your rating from being submitted\n";
	return;
}

echo "Your review has been recorded.";

?>