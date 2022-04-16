<?php
require_once(__DIR__ . "/../rootpath.php");
/* Loads the box content according to the guidelines.

INPUTS:
From parent PHP:
		array $userpermissions: List of permissions the current user has.
		array $json: Associative list parsed from existing_sections.json.
		string $CURRENT_SECTION; {"profile", "rate", "admin", "management, "sysop"}
		string $CURRENT_PAGE: ... See existing_sections.json ...

EFFECTS/OUTPUTS:
		This function should create and output the relevant box content based on the
		current section, requested page, and the user's permissions.


This function will delegate the creation of individual pages to the php and python
files relevant to each. It merely calls them.
*/

/* TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING */

// $jsonStr = file_get_contents(__ROOT_DIR__ . "existing_sections.json");
// $json = json_decode($jsonStr, true);
// 
// $CURRENT_SECTION = "rate";
// $CURRENT_PAGE = "rate_ta";
// 
// $is_student = true;
// $is_ta = false;
// $is_prof = true;
// $is_admin = true;
// $is_sysop = false;
// 
// // Create list of permissions for this user
// $userPermissions = array();
// if ($is_student) array_push($userPermissions, "student");
// if ($is_ta) array_push($userPermissions, "ta");
// if ($is_prof) array_push($userPermissions, "prof");
// if ($is_admin) array_push($userPermissions, "admin");
// if ($is_sysop) array_push($userPermissions, "sysop");

/* TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING */

generateContentBox($CURRENT_SECTION, $CURRENT_PAGE);

function generateContentBox(string $sectionID, string $pageID) {
}





/**
 * Generates the navigation section of the content box. Page and section checks
 * must be done before calling this function.
 * @param sectionID ID of the current section.
 * @param pageID ID of the current page.
 */
function generateNavigation(string $sectionID, string $pageID) {
	global $json;
	if (__DEBUG__) echo "Generating the navigation bar for $pageID inside $sectionID<br>\n";

	$navTemplate = '
	<div class="box-nav">
		<a class="box-nav-back-container" href="%s">
			<img class="box-nav-back" src="pictures/backarrow.svg">
		</a>
		<div class="box-nav-text">
			<div class="box-nav-path">%s / <b>%s</b></div>
			<div class="box-nav-description">
				<div class="box-nav-description-text">%s</div>
			</div>
		</div>
	</div>';
	$currentPage = $json[$sectionID]['pages'][$pageID];
	echo sprintf($navTemplate, $sectionID.'.php', $json[$sectionID]['sectionString'], $currentPage['pageString'], $currentPage['pageDescription']);

}
?>