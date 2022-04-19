<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * This file is intended to be called from javascript with no purpose
 * other than to set the current user's selected course (for management)
 * and to validate said choice.
 * It then stores the course/term inside the session for easy retrieval by
 * pages inside of management.
 * Finally, it builds the menu, like the normal menubuilder will do.
*/

// ================================== Session integrity check ==================================

if (__DEBUG__) echo "The current state of the session is: <br>\n";
if (__DEBUG__) echo print_r($_SESSION, true) . "<br>\n";

$coursesList = null;
if (isset($_SESSION["management_courseslist"])) $coursesList = $_SESSION["management_courseslist"];
else {
	genericError();
	echo "Session corrupted 2\n";
	return;
}

// ================================== Get content ==================================

$chosenCourseNum = "";
if (isset($_GET["dropdown_index"])) $chosenCourseNum = $_GET["dropdown_index"];
else {
	doesNotExist();
	echo "The selected course is not valid.";
}

if (__DEBUG__) echo "The chosen index is: $chosenCourseNum\n";

// ================================== Input validation ==================================
// Inputs exits
if ($chosenCourseNum == "" || $coursesList == null) {
	genericError();
	return;
}
// Inputs exits
if (!key_exists($chosenCourseNum, $coursesList)) {
	doesNotExist();
	return;
}

// ================================== Saving to session ==================================
// Saving courseNum and termMonthYear to session so that we don't need to get it in every page.
$_SESSION["management_chosen_course"] = $coursesList[$chosenCourseNum]["course_num"];
$_SESSION["management_chosen_term"] = $coursesList[$chosenCourseNum]["term_month_year"];

// DONE
?>