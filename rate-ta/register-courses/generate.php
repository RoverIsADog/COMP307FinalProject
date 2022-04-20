<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Getting the courses ==================================
$output = null; $retval = null;
$command = escapeshellcmd("python3 " .  __DIR__ . "/get_tas.py "
. ' --course_num '             . escapeshellarg($chosenCourse)
. ' --term_month_year '        . escapeshellarg($chosenTerm))
. ' 2>&1';

if (__DEBUG__) echo "Submitting task to python: $command\n";
exec($command , $output, $retval);

if ($retval != 0) {
	genericError();
	echo "Python script failure";
	return;
}

if (__DEBUG__) echo "Python output: <br>\n";
if (__DEBUG__) echo nl2br(print_r($output, true));

?>