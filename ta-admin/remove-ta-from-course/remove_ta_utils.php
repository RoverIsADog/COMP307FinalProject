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
 */

 /**
	* Returns a list of every TA in the system. Assumes that the username
	* is already in the system.
  */
function getAllTAs():?array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = escapeshellcmd("python3 " . __DIR__ . "/get_all_tas.py"); // No arguments
	if (__DEBUG__) echo "Getting all TAs: $command<br>\n";
	exec($command, $output, $exitCode);
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

/**
 * Returns a list of every TA in the system. Assumes that the username
 * is already in the system.
 */
function getAllCoursesForTA(string $taID):?array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = escapeshellcmd("python3 " . __DIR__ . "/get_all_courses_for_a_ta.py "
		. ' --student_id ' . escapeshellarg($taID));
	if (__DEBUG__) echo "Getting all courses for TA $taID: $command<br>\n";
	exec($command, $output, $exitCode);
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