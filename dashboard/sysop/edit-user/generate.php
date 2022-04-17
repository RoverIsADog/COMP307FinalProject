<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__DIR__ . "/edit_user_utils.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Getting users ==================================

$usersList = getAllUsers();

// if (__DEBUG__) echo "The imported users are: <br>\n";
// if (__DEBUG__) echo nl2br(print_r($usersList, true));

if ($usersList == null || sizeof($usersList) == 0) {
	echo "<h1>There are no users in the system!</h1>\n";
	return;
}


// ================================== Printing table ==================================
echo '<form id="edit-user-form">';
$usersDropdownFrame = '
<select class="content-box-element" name="user-select" id="user-select" onchange="selectedUser(this.value)">
	<option value="" selected disabled>Please select a User</option>
	%s
</select>
';
$usersDropdownEntryTemplate = '<option value="%s">%s (%s)</option>';

$usersDropdownEntries = "";
foreach ($usersList as $idx => $user) {
	$usersDropdownEntries = $usersDropdownEntries . sprintf($usersDropdownEntryTemplate, $idx, $user["username"], $user["student_id"]);
}
echo sprintf($usersDropdownFrame, $usersDropdownEntries);

$_SESSION["edit_user_userslist"] = $usersList;

?>

	<div id="editable-fields"></div>
	
	<div class="content-box-element" id="buttons" style="display: none">
	<button class="button positive-button" id="modify-button" type="submit" value="modify">Submit Changes</button>
	<button class="button negative-button" id="delete-button" type="submit" value="delete">Delete User</button>
</div>

</form>