<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__DIR__ . "/oh_responsibilities_utils.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



?>

<div class="content-box-element labeled-field-container">
	<div class="labeled-field-label">Job Details</div>
	<input class="labeled-field-field" type="text" name="instructor-job">
</div>

<h1>Office Hours</h1>
<div class="content-box-element">Times in unchecked days will be ignored</div>

<div class="content-box-element oh-container">

	<label class="oh-day-container">
		<div class="oh-day-label">
			<input class="input-checkbox" type="checkbox" id="have-oh-monday" name="have-oh-monday">
			<div>Monday</div>
		</div>
		<div class="oh-day-field">
			<input class="input-time" type="time" name="oh-monday">
			<span style="padding: 0 0.5em;"> to </span>
			<input class="input-time" type="time" name="oh-monday">
		</div>
	</label>

	<label class="oh-day-container">
		<div class="oh-day-label">
			<input class="input-checkbox" type="checkbox" id="have-oh-tuesday" name="have-oh-tuesday">
			<div>Tuesday</div>
		</div>
		<div class="oh-day-field">
			<input class="input-time" type="time" name="oh-tuesday">
			<span style="padding: 0 0.5em;"> to </span>
			<input class="input-time" type="time" name="oh-tuesday">
		</div>
	</label>

	<label class="oh-day-container">
		<div class="oh-day-label">
			<input class="input-checkbox" type="checkbox" id="have-oh-wednesday" name="have-oh-wednesday">
			<div>Wednesday</div>
		</div>
		<div class="oh-day-field">
			<input class="input-time" type="time" name="oh-wednesday">
			<span style="padding: 0 0.5em;"> to </span>
			<input class="input-time" type="time" name="oh-wednesday">
		</div>
	</label>

	<label class="oh-day-container">
		<div class="oh-day-label">
			<input class="input-checkbox" type="checkbox" id="have-oh-thursday" name="have-oh-thursday">
			<div>Thursday</div>
		</div>
		<div class="oh-day-field">
			<input class="input-time" type="time" name="oh-thursday">
			<span style="padding: 0 0.5em;"> to </span>
			<input class="input-time" type="time" name="oh-thursday">
		</div>
	</label>

	<label class="oh-day-container">
		<div class="oh-day-label">
			<input class="input-checkbox" type="checkbox" id="have-oh-friday" name="have-oh-friday">
			<div>Friday</div>
		</div>
		<div class="oh-day-field">
			<input class="input-time" type="time" name="oh-friday">
			<span style="padding: 0 0.5em;"> to </span>
			<input class="input-time" type="time" name="oh-friday">
		</div>
	</label>

</div>

<h1>Notes</h1>

<textarea class="spanning-textbox" type="text" name="notes" wrap="physical"></textarea>

<div class="content-box-element">
	<button class="button positive-button" id="update" type="submit" value="update">Update</button>
</div>