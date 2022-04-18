<?php
if (!isset($_SESSION)) session_start();

# __ROOT_DIR__ = /var/www/html/dashboard/
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "/utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION["myIdx"] = "myValue";

include_once(__DIR__ . "/consumer.php");

?>