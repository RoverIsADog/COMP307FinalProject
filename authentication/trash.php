<?php
# __ROOT_DIR__ = /var/www/html/dashboard/
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "/utils/errors.php");

$output = null; $retval = null;
$command = "python3 " .  __DIR__ . "/verify_login.py "
	. ' --username defaultsysop'
	. ' --password 1234';
if (__DEBUG__) echo "Submitting task to python: $command\n";
exec(escapeshellcmd($command) , $output, $retval);

//if ($retval != 0) {
//	genericError();
//	echo "The user has not been added.\n";
//	return;
//}

print_r($output);



?>