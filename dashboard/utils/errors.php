<?php

/**
 * Prints a 404 error message.
 */
function notFound() {
	echo "<h1>404 NOT FOUND. Requested page was not found.</h1><br>\n";
}

/**
 * Prints a 403 error message.
 */
function forbidden() {
	echo "<h1>403 FORBIDDEN. You do not have access to the requested page.</h1><br>\n";
}

function doesNotExist() {
	echo "<h1>406 NOT ACCEPTABLE. The value selected does not exist.</h1><br>\n";
}

function genericError() {
	echo "<h1>500 INTERNAL SERVER ERROR.</h1><br>\n";
}

?>