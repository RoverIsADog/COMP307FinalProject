<?php
/*
Defines a variable that will always point to the root directory.
*/
define("__ROOT_DIR__", realpath(__DIR__) . "/");
define("__DEBUG__", true);
session_save_path(__DIR__ . "/.session-storage");
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>