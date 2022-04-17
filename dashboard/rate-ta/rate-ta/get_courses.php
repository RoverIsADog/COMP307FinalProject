<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

/**
 * This file is meant to assist with page generation and act as PHP weapper
 * for get_courses.py. Returns a list of csv-formatted strings containing:
 * courseID,Term
 * 
 * This file assumes the following are set:
 * 	$_SESSION["username]
 * 	$_SESSION["ticket]
 */

//getCourses();

/**
 * Given a studentID and ticket, get all courses this user is
 * registered to. Assumes that student, ticket are currently
 * in the session.
 * @return returns a list of {id} => {course,term}, null if some error.
 */
function getCourses():?array {
	// Pass relevannt arguments into python and execute.
	$command = "python3 " . __DIR__ . "/get_courses.py "
	. " --username " . $_SESSION["username"]
	. " --ticket_id " . $_SESSION["ticket"];
	if (__DEBUG__) echo "Getting courses: $command<br>\n";
	exec(escapeshellcmd($command), $output, $exitCode);
	if ($exitCode != "0") return null;

	// Formats data
	//error_log( print_r($output) . "<br>\n" ,3 , __ROOT_DIR__ . "output.log");

	// Formats data
	return $output;
}

?>