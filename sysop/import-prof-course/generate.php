
<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

?>


<form id="import-form">
	<h2>Are you sure you want to import the files?</h2>
	<div class="content-box-element">
		<button class="button positive-button" id="submit" type="submit" value="submit">Import</button>
	</div>
</form>