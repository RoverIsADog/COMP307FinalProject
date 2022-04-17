<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * This file is meant to assist with page generation and act as PHP weapper
 * for get_courses.py.
 * 
 * This file assumes the following are set:
 * 	$_SESSION["username]
 * 	$_SESSION["ticket]
 */

 /**
	* Returns a list of every TA in the system. Assumes that the ticket and username
	* are already in the system.
  */
function getAllTAs():?array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = "python3 " . __DIR__ . "/get_all_tas.py "
	. " --username " . $_SESSION["username"] // TODO REMOVE
	. " --ticket_id " . $_SESSION["ticket"]; // TODO REMOVE
	if (__DEBUG__) echo "Getting all TAs: $command<br>\n";
	exec(escapeshellcmd($command), $output, $exitCode);
	if ($exitCode != "0") {
		genericError();
		exit();
	}

	$ret = array();

	foreach ($output as $idx => $csvEntry) {
		$ret[$idx] = str_getcsv($csvEntry);
	}

	// Formats data
	return $ret;
}

/**
 * Returns a list of every TA in the system. Assumes that the ticket and username
 * are already in the system.
 */
function getAllCourses():?array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = "python3 " . __DIR__ . "/get_all_courses.py "
	. " --username " . $_SESSION["username"] // TODO REMOVE
	. " --ticket_id " . $_SESSION["ticket"]; // TODO REMOVE
	if (__DEBUG__) echo "Getting all courses: $command<br>\n";
	exec(escapeshellcmd($command), $output, $exitCode);
	if ($exitCode != "0") {
		genericError();
		exit();
	}

	$ret = array();

	foreach ($output as $idx => $csvEntry) {
		$ret[$idx] = str_getcsv($csvEntry);
	}
	return $ret;
}

?>