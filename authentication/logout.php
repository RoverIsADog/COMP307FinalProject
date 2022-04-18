<?php
if (!isset($_SESSION)) session_start();

//unset($_SESSION['ticket']);
//unset($_SESSION['username']);

# __ROOT_DIR__ = /var/www/html/dashboard/
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "/utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $_COOKIE['ticket'] = "-1";
// $_COOKIE['username'] = "-1";
// setcookie("ticket", $_COOKIE["ticket"], -999);
// setcookie("username", $_COOKIE["username"], -999);
// unset($_COOKIE['ticket']);
// unset($_COOKIE['username']);

if (isset($_SESSION["ticket"])) unset($_SESSION["ticket"]);
if (isset($_SESSION["username"])) unset($_SESSION["username"]);

$output = null; $exitCode = null;
$command = 'python3 ' . __ROOT_DIR__ . 'authentication/logout.py '
	. ' --username ' . escapeshellarg($username);
echo "Command: $command<br>\n";
exec(escapeshellcmd($command), $output, $exitCode);

header("Location:index.php");
?>