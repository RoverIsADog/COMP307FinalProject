<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

/**
 * This file is meant to assist with page generation and act as PHP weapper
 * for get_courses.py.
 * 
 * This file assumes the following are set:
 * 	$_SESSION["username]
 * 	$_SESSION["ticket]
 */

// $out = getAllTAs();
// print_r($out);

/**
 * Given a studentID and ticket, get all courses this user is
 * registered to. Assumes that student, ticket are currently
 * in the session.
 * Returns a list (A) of lists (B).
 * List B contains: [0] : taID, [1] : taName
 * @return returns a an array of arrays: {id} => {course,term}, null if some error.
 */
function getAllTAs():?array {
	// Pass relevannt arguments into python and execute.
	$command = "python3 " . __DIR__ . "/get_all_tas.py "
	. " --username " . $_SESSION["username"]
	. " --ticket_id " . $_SESSION["ticket"];
	if (__DEBUG__) echo "Getting all TAs: $command<br>\n";
	exec(escapeshellcmd($command), $output, $exitCode);
	if ($exitCode != "0") return null;

	$ret = array();

	foreach ($output as $idx => $csvEntry) {
		$ret[$idx] = str_getcsv($csvEntry);
	} 

	// Formats data
	//error_log( print_r($output) . "<br>\n" ,3 , __ROOT_DIR__ . "output.log");

	// Formats data
	return $ret;
}

?>