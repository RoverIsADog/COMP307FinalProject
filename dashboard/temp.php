<?php
# __ROOT_DIR__ = /var/www/html/dashboard/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION)) {
	echo "The session is stored in: <br>";
	echo session_status();
	echo session_save_path();
}
else {
	session_save_path(__DIR__ . "/.session-storage");
	session_start();
	echo "Session started!";
}
?>