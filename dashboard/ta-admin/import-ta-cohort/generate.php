<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

?>

<form id="import-form">
	<h2>Are you sure you want to import the files?</h2>
	<!-- Left as a form this way, we can specify file locations here, if needed. -->
		
	<div class="button-container"><button class="button positive-button" type="submit" value="import">Import</button></div>
</form>
