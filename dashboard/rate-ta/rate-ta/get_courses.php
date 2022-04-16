<?php
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
session_start();
/*
This file gets every course a given user is registered to.
*/

//getCourses();

/**
 * Given a studentID and ticket, get all courses this user is
 * registered to. Assumes that student, ticket are currently
 * in the session.
 * @param student_id Student id of the user.
 * @param ticket_id Ticket id of the user.
 * @return returns a list of {course} => {term}, null if some error.
 */
function getCourses():?array {
	// Pass relevannt arguments into python and execute.
	$command = "python3 " . __DIR__ . "/get_courses.py "
	. " --username " . $_SESSION["username"]
	. " --password " . $_SESSION["ticket_id"];
	if (__DEBUG__) echo "Getting courses: $command<br>\n";
	exec(escapeshellcmd($command), $output, $exitCode);
	if ($exitCode != "0") return null;

	// Formats data
	//error_log( print_r($output) . "<br>\n" ,3 , __ROOT_DIR__ . "output.log");

	// Formats data
	return $output;
}

?>