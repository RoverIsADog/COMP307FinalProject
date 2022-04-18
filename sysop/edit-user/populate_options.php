<?php
if (!isset($_SESSION)) if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================== Session integrity check ==================================
$usersList = null;
if (isset($_SESSION["edit_user_userslist"])) $usersList = $_SESSION["edit_user_userslist"];
else {
	genericError();
	echo "Session corrupted 2\n";
	return;
}

// ================================== Get content ==================================
$chosenUserNum = "";
if (isset($_GET["dropdown_index"])) {
	$chosenUserNum = $_GET["dropdown_index"];
	if (__DEBUG__) echo "Chosen user number is: $chosenUserNum\n";
}

// ================================== Inputs validation ==================================
// Inputs exits
if ($chosenUserNum == "") {
	genericError();
	return;
}
// Input Security Check
if (!key_exists($chosenUserNum, $usersList)) {
	doesNotExist();
	return;
}

// ================================== Creating Text boxes ==================================
$labeledTextfieldTemplate = '
<div class="content-box-element labeled-field-container">
	<div class="labeled-field-label">%s</div>
	<input class="labeled-field-field" type="%s" name="%s" value="%s" required>
</div>
';

echo sprintf($labeledTextfieldTemplate, "First Name", "text", "user-firstname", $usersList[$chosenUserNum]["firstname"]);
echo sprintf($labeledTextfieldTemplate, "Last Name", "text", "user-lastname", $usersList[$chosenUserNum]["lastname"]);
echo sprintf($labeledTextfieldTemplate, "Email", "text", "user-email", $usersList[$chosenUserNum]["email"]);

// ================================== Creating Roles checkboxes/ratios ==================================
echo '<h1>Assigned Roles</h1>';

$radioEntryTemplate = '
<label class="textbox-set-element content-box-element" for="%s">
	<input class="input-checkbox" type="radio" id="%s" name="%s" value="%s" required %s>
	<div>%s</div>
</label>
';

$checkboxEntryTemplate = '
<label class="textbox-set-element content-box-element" for="%s">
	<input class="input-checkbox" type="checkbox" id="%s" name="%s" %s>
	<div>%s</div>
</label>
';

// Preprocessing
$isStudent = $usersList[$chosenUserNum]["role"] == "student" ? "checked" : "";
$isTA = $usersList[$chosenUserNum]["role"] == "ta" ? "checked" : "";
$isProf = $usersList[$chosenUserNum]["role"] == "prof" ? "checked" : "";
$isAdmin = $usersList[$chosenUserNum]["is_admin"] == "1" ? "checked" : "";
$isSysop = $usersList[$chosenUserNum]["is_sysop"] == "1" ? "checked" : "";

if (__DEBUG__) echo "Is student? $isStudent <br>\n";
if (__DEBUG__) echo "Is TA? $isTA <br>\n";
if (__DEBUG__) echo "Is Prof? $isProf <br>\n";
if (__DEBUG__) echo "Is Admin? $isAdmin <br>\n";
if (__DEBUG__) echo "Is Sysop? $isSysop <br>\n";

echo '<div class="textbox-set-container content-box-element">';

// Getting roles, then checking the appropriate radiobutton
echo sprintf($radioEntryTemplate, "permission-student", "permission-student", "user-role", "student", $isStudent, "Student");
echo sprintf($radioEntryTemplate, "permission-ta", "permission-ta", "user-role", "ta", $isTA, "Teaching Assistant");
echo sprintf($radioEntryTemplate, "permission-prof", "permission-prof", "user-role", "prof", $isProf, "Professor");

// Getting admin or sysop, then checking the appropriate checkboxes
echo sprintf($checkboxEntryTemplate, "permission-admin", "permission-admin", "permission-sysop", $isAdmin, "Administrator");
echo sprintf($checkboxEntryTemplate, "permission-sysop", "permission-sysop", "permission-sysop", $isSysop, "System Operator");

echo '</div>';

?>