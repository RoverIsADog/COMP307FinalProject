<?php
/*
Defines a variable that will always point to the root directory.
*/
define("__ROOT_DIR__", realpath(__DIR__) . "/");
define("__DEBUG__", false);

// Debug
if (!isset($_SESSION) && false) {
	session_start();
}

function consoleLog($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

?>