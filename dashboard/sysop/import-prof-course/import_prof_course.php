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
$command = "python3 " .  __DIR__ . "/import_ta_cohort.py "
. ' --course_quota_path ' . escapeshellarg(__ROOT_DIR__ . "data/profcourse.csv"); // Hardcoded for now
exec(escapeshellcmd($command) , $output, $retval);
if ($retval != 0) {
	genericError();
}

echo "The files were successfully imported\n";

?>