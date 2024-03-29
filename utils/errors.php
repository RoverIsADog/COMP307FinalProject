<?php

/**
 * Prints a 404 error message.
 */
function notFound(string $message = "") {
	echo "<h1>404 NOT FOUND. Requested page was not found.</h1><br>\n";
	if ($message != "") echo "<p>$message</p>";
}

/**
 * Prints a 403 error message.
 */
function forbidden(string $message = "") {
	echo "<h1>403 FORBIDDEN. You do not have access to the requested page.</h1><br>\n";
	if ($message != "") echo "<p>$message</p>";
}

function doesNotExist(string $message = "") {
	echo "<h1>406 NOT ACCEPTABLE. The value selected does not exist.</h1><br>\n";
	if ($message != "") echo "<p>$message</p>";
}

function inputValueError(string $message = "") {
	echo "<h1>400 BAD REQUEST. An input value is not correctly formatted.</h1><br>\n";
	if ($message != "") echo "<p>$message</p>";
}

function genericError(string $message = "") {
	echo "<h1>500 INTERNAL SERVER ERROR.</h1><br>\n";
	if ($message != "") echo "<p>$message</p>";
}

?>