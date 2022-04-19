<?php
// This section behaves almost normally, but loads a custom menu
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");
require_once(__ROOT_DIR__ . "utils/errors.php");
require_once(__ROOT_DIR__ . "utils/nav_generator.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($CURRENT_PAGE) || !isset($CURRENT_SECTION) || !isset($json) || !isset($userPermissions)) {
	echo "Variable unset error<br>\n";
}

// $CURRENT_SECTION = "admin";
// $CURRENT_PAGE = "";

if (__DEBUG__) echo "/// Entering default_section_loader<br>";

// ==================================== Page processing ====================================
// No page specified, go to menu
if ($CURRENT_PAGE == "") {
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

/**
 * Generates the menu of a section. SectionID check must be done before calling
 * this function.
 * @param sectionID ID of the section.
 */
function buildMenu(array $json, string $sectionID) {
	// ================================== Deallocate old variables ==================================
	if (isset($_SESSION["management_courseslist"])) unset($_SESSION["management_courseslist"]);
	if (isset($_SESSION["management_chosen_course"])) unset($_SESSION["management_chosen_course"]);
	if (isset($_SESSION["management_chosen_term"])) unset($_SESSION["management_chosen_term"]);

	// ================================== Session Integrity Check ==================================
	$username = "";
	if (isset($_SESSION["username"])) $username = $_SESSION["username"];
	else {
		genericError();
		echo "The username is not in the session (get_courses.php)<br>\n";
		exit();
	}

	// ================================== Generate navigation path ==================================
	$navTemplate = '
	<div class="box-nav menu-nav">
		<div class="box-nav-text">
			<div class="box-nav-path"><b>%s</b></div>
			<div class="box-nav-description">
				<div class="box-nav-description-text">Choose an Option</div>
			</div>
		</div>
	</div>
	';
	echo sprintf($navTemplate, $json[$sectionID]['sectionString']);

	// ================================== Prepare to use python ==================================
	// Getting every course for the current user using python
	$output = null; $exitCode = null;
	$command = escapeshellcmd("python3 " . __DIR__ . "/get_all_courses.py "
		. " --username " . escapeshellarg($username))
		. " 2>&1"; // USERNAME REQUIRED
	if (__DEBUG__) echo "Getting courses: $command<br>\n";
	exec($command, $output, $exitCode);

	if (__DEBUG__) echo "getcourses output: <br>\n";
	if (__DEBUG__) echo print_r($output, true)."<br>\n";

	if ($exitCode != 0) {
		genericError();
		echo "Exit code in get_all_courses.php: $exitCode<br>\n";
		exit();
	}

	if (sizeof($output) == 0) {
		echo '<h2>You are not associated with any course! Please contact a system operator.</h2>';
		exit();
	}

	$coursesList = array();
	foreach ($output as $idx => $str) {
		$tmp = str_getcsv($str);
		$coursesList[$idx] = array(
			"course_num" => $tmp[0],
			"term_month_year" => $tmp[1],
		);
	}

	// Saving for input validation later
	$_SESSION["management_courseslist"] = $coursesList;
	
	// ================================== Building the courses dropdown ==================================
	$coursesDropdownFrame = '
	<div class="box-nav-course-dropdown">
		<select id="management-courses-dropdown" name="management-courses-dropdown" onchange="selectedCourseTerm(this.value)" required>
			<option value="NONE" selected disabled>Please select a course and term</option>
			%s
		</select>
	</div>
	';
	$coursesDropdownEntries = "";
	$coursesDropdownEntryTemplate = '<option value="%s">%s [%s]</option>';
	foreach ($output as $idx => $val) {
		$tmp = str_getcsv($val);
		$coursesDropdownEntries = $coursesDropdownEntries . sprintf($coursesDropdownEntryTemplate, $idx, $tmp[0], $tmp[1]);
	}

	echo '<div class="box-content">';
	echo sprintf($coursesDropdownFrame, $coursesDropdownEntries);

	// ================================== Building the menu ==================================
	// Leave space for populating the menu on course selection
	echo '<div id="management-menu-container" style="display: none;">';

	$menuOptionTemplate = '
	<div class="content-box-element">
	  <a class="menu-entry" href="%s">%s</a>
	</div>
	';

	foreach($json[$sectionID]['pages'] as $pageID => $pageInfo) {
	  $linkTemplate = $sectionID . ".php?page=" . $pageInfo["pageID"];
	  echo sprintf($menuOptionTemplate, $linkTemplate, $pageInfo['pageString']);
	}

	echo '</div>';

	echo '</div>';
  }

?>