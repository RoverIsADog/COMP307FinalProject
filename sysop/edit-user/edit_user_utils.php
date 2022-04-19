<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Returns a list of every user in the system. Assumes that the username
 * is already in the session.
 * For each index, there is an array of the fields of each user.
 */
function getAllUsers():array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = escapeshellcmd("python3 " . __DIR__ . "/get_all_users_and_info.py");
	if (__DEBUG__) echo "Getting all users: $command<br>\n";
	exec($command, $output, $exitCode);
	if ($exitCode != "0") {
		genericError();
		exit();
	}

	$ret = array();

	// Appending to respective index since there are many fields
	foreach ($output as $idx => $csvEntry) {
		$curUserArr = str_getcsv($csvEntry);
		
		$ret[$idx] = array();
		$ret[$idx]["username"] = $curUserArr[0];
		$ret[$idx]["student_id"] = $curUserArr[1];
		$ret[$idx]["firstname"]  = $curUserArr[2];
		$ret[$idx]["lastname"] = $curUserArr[3];
		$ret[$idx]["email"] = $curUserArr[4];
		$ret[$idx]["role"] = $curUserArr[5];
		$ret[$idx]["is_admin"] = $curUserArr[6];
		$ret[$idx]["is_sysop"] = $curUserArr[7];

	}

	// Formats data
	return $ret;
}

?>