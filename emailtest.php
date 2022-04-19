<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$msg = "This is a new email \n Hello!";

mail("yetongzhou1@gmail.com", "New mail", $msg);

echo "Mail sent!\n";

?>