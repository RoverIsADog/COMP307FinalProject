<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Session integrity check ==================================

// Executing the command
$command = escapeshellcmd("python3 " .  __DIR__ . "/import_prof_course.py "
. ' --path ' . escapeshellarg(__ROOT_DIR__ . "data/course_plus_prof.csv")
. ' 2>&1'); // Hardcoded for now
exec($command , $output, $retval);
if ($retval != 0) {
	genericError();
}

echo "The files were successfully imported\n";

?>