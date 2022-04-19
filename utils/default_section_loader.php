<?php
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__ROOT_DIR__ . "utils/nav_generator.php");

if (!isset($CURRENT_PAGE) || !isset($CURRENT_SECTION) || !isset($json) || !isset($userPermissions)) {
	echo "Variable unset error<br>\n";
}

// $CURRENT_SECTION = "admin";
// $CURRENT_PAGE = "";

if (__DEBUG__) echo "/// Entering default_section_loader<br>";

// ==================================== Page processing ====================================
// No page specified, go to menu
if ($CURRENT_PAGE == "") {
	require(__ROOT_DIR__ . "utils/menu_generator.php");
  if (__DEBUG__) echo "Building the menu <br>";
	buildMenu($json, $CURRENT_SECTION);
	return;
}

// Page specified does not exist
if (!key_exists($CURRENT_PAGE, $selectedSection['pages'])) {
	notFound();
	return;
}

$selectedPage = $selectedSection['pages'][$CURRENT_PAGE];

// Page specified exists, but no permission
if (sizeof(array_intersect($userPermissions, $selectedPage["allowedRoles"])) == 0) {
	forbidden();
	return;
}

// Finally, generate page

generateNavigation($CURRENT_SECTION, $CURRENT_PAGE);

echo '<div class="box-content">'; // Only let page generate be responsible for the box-content

$dest = __ROOT_DIR__ . $json[$CURRENT_SECTION]['sectionFolder'] . "/" . $json[$CURRENT_SECTION]["pages"][$CURRENT_PAGE]["pageFolder"] . "/generate.php";
if (__DEBUG__) echo "Moving on to $dest<br>\n";
require($dest);

echo '</div>'; // Done


?>