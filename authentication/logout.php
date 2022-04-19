<?php
if (!isset($_SESSION)) session_start();

# __ROOT_DIR__ = /var/www/html/dashboard/
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "/utils/errors.php");

$username = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__ROOT_DIR__ . "utils/cookies_utils.php");
deleteAllCookies();
session_destroy();

// Remove all tickets for this user
if ($username != "") {
	$output = null; $exitCode = null;
	$command = escapeshellcmd('python3 ' . __ROOT_DIR__ . 'authentication/logout.py '
		. ' --username ' . escapeshellarg($username))
		. ' 2>&1';
	if (__DEBUG__) echo "Command: $command<br>\n";
	exec($command, $output, $exitCode);
}

header("Location:index.html");
?>