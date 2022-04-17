<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * This file is meant to assist with page generation and act as PHP weapper
 * for get_courses.py. Returns a list of csv-formatted strings containing:
 * courseID,Term
 * 
 * This file assumes the following are set:
 * 	$_SESSION["username]
 */

//getCourses();

/**
 * Given a username, get all courses this user is
 * registered to. Assumes that username is currently
 * in the session.
 * @return returns a list of {id} => {course,term}, null if some error.
 */
function getCourses():?array {
	$username = "";
	if (isset($_SESSION["username"])) $username = $_SESSION["username"];
	else {
		genericError();
		echo "The username is not in the session (get_courses.php)<br>\n";
	}
	// Pass relevannt arguments into python and execute.
	$command = "python3 " . __DIR__ . "/get_courses.py "
		. " --username " . escapeshellarg($username); // USERNAME REQUIRED
	if (__DEBUG__) echo "Getting courses: $command<br>\n";
	exec(escapeshellcmd($command), $output, $exitCode);
	if ($exitCode != "0") {
		genericError();
		exit();
	}

	// Formats data
	//error_log( print_r($output) . "<br>\n" ,3 , __ROOT_DIR__ . "output.log");

	// Formats data
	return $output;
}

?>