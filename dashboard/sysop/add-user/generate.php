<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<p>
	<h2>
		Note: TA and Prof roles can only be assigned if an entry with the same STUDENTID exists in the
		database. To add a professor or TA not in the system, please import them first.
	</h2>
</p>
<form id="add-user-form">
	<div id="editable-fields" class="">
		<!-- student_id,firstname,lastname,email,is_student,is_prof,is_admin,is_sysop,is_ta -->
		<div class="content-box-element labeled-field-container">
			<div class="labeled-field-label">Student ID</div>
			<input class="labeled-field-field" type="text" name="user-studentid" required>
		</div>
		<div class="content-box-element labeled-field-container">
			<div class="labeled-field-label">Username</div>
			<input class="labeled-field-field" type="text" name="user-username" required>
		</div>
		<div class="content-box-element labeled-field-container">
			<div class="labeled-field-label">Password</div>
			<input class="labeled-field-field" type="password" name="user-password" required>
		</div>
		
		<div class="content-box-element labeled-field-container">
			<div class="labeled-field-label">First Name</div>
			<input class="labeled-field-field" type="text" name="user-firstname" required>
		</div>
	
		<div class="content-box-element labeled-field-container">
			<div class="labeled-field-label">Last Name</div>
			<input class="labeled-field-field" type="text" name="user-lastname" required>
		</div>
		<div class="content-box-element labeled-field-container">
			<div class="labeled-field-label">Email</div>
			<input class="labeled-field-field" type="email" name="user-email" required>
		</div>
	
		<h1>Assigned Roles</h1>
		<div class="textbox-set-container content-box-element">
		
			<label class="textbox-set-element content-box-element" for="permission-student">
				<input class="input-checkbox" type="radio" id="permission-student" name="user-role" value="student" required>
				<div>Student</div>
			</label>
		
			<label class="textbox-set-element content-box-element" for="permission-ta">
				<input class="input-checkbox" type="radio" id="permission-ta" name="user-role" value="ta" required>
				<div>Teaching Assistant</div>
			</label>
		
			<label class="textbox-set-element content-box-element" for="permission-prof">
				<input class="input-checkbox" type="radio" id="permission-prof" name="user-role" value="prof" required>
				<div>Professor</div>
			</label>
		
			<label class="textbox-set-element content-box-element" for="permission-admin">
				<input class="input-checkbox" type="checkbox" id="permission-admin" name="permission-admin">
				<div>Administrator</div>
			</label>
		
			<label class="textbox-set-element content-box-element" for="permission-sysop">
				<input class="input-checkbox" type="checkbox" id="permission-sysop" name="permission-sysop">
				<div>System Operator</div>
			</label>
		
		</div>
	
		<div class="content-box-element">
			<button class="button positive-button" id="submit" type="submit" value="submit">Add User</button>
		</div>
	</div>
</form>