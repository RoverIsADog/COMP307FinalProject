<?php
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

/**
 * Sets all cookies associated with the current user to expire
 * immediately.
 */
function deleteAllCookies() {
	foreach ($_COOKIE as $key => $val) {
		if ($key != "PHPSESSID") setcookie($key, $val, 1646110800, "/"); // March 1 2022
	}
}

?>