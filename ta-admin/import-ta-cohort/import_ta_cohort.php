<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Executing the command
$command = escapeshellcmd("python3 " .  __DIR__ . "/import_ta_cohort.py "
	. ' --course_quota_path ' . escapeshellarg(__ROOT_DIR__ . "data/coursequota.csv") // Hardcoded for now
	. ' --ta_cohort_path '    . escapeshellarg(__ROOT_DIR__ . "data/tacohort.csv")); // Hardcoded for now
if (__DEBUG__) echo "Importing: $command<br>\n";
exec($command , $output, $retval);
if ($retval == -2 || $retval != 0) {
	genericError();
}

echo "The files were successfully imported\n";

?>