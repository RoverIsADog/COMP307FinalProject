<?php
require(__DIR__ . "/../rootpath.php");

// $is_student = false;
// $is_ta = false;
// $is_prof = false;
// $is_admin = false;
// $is_sysop = true;
// $CURRENT_PAGE = "rate_ta";
// $CURRENT_SECTION = "rate";

/* Loads the sidebar according to the guidelines.
This method prints content into the sidebar container (id=sidebar).

RELEVANT INPUTS:
From parent PHP:
	$is_student;
	$is_ta;
	$is_prof;
	$is_admin;
	$is_sysop;

	$CURRENT_SECTION; {"profile", "rate", "admin", "management, "sysop"}
	$CURRENT_PAGE:
		SECTION rate -> {rate_ta}
		SECTION admin -> {import_ta_cohort, ta_info_history, course_ta_records, add_ta_to_course, remove_ta_from_course}
		SECTION management -> {oh_responsibilities, add_performance_log, wishlist}
		SECTION sysop -> {edit_user, import_prof_course, manual_add_prof}
		Consult pageinfo.csv for more information.

EFFECTS/OUTPUTS:
	This function should create and output the relevant sidebar elements depending
	on the permissions. This function has no effects.
*/

// ////////////////////////////////// GENERATING PROFILE //////////////////////////////////

if (!isset($CURRENT_PAGE) || !isset($CURRENT_SECTION)) {
	echo "Variable error <br>\n";
	return;
}

$sidebarProfileTemplate = '
<a class="sidebar-item%s" id="sidebar-user" href=profile.php>
	<div class="sidebar-item-tick"></div>
	<img id="sidebar-user-img" src="%s">
	<div id="sidebar-user-text">
		<div id="username">%s</div>
		<div id="userrole">%s</div>
	</div>
</a>
';

// Get user profile pic path, username, role
$profilePicPath = 'pictures/id_full_white.svg'; // DO NOT PUT __ROOT_DIR__ HERE
$username = "John Doe";
// Successive ifs to get highest.
$userrole = "Undefined Role";
if ($is_student) $userrole = "Student";
if ($is_ta) $userrole = "Teaching Assistant";
if ($is_prof) $userrole = "Professor";
if ($is_admin) $userrole = "TA Administrator";
if ($is_sysop) $userrole = "System Administrator";

$selected = "";
if ($CURRENT_SECTION == "profile") {
	$selected = " sidebar-current";
}

echo sprintf($sidebarProfileTemplate, $selected, $profilePicPath, $username, $userrole);

// ////////////////////////////////// GENERATING OPTIONS //////////////////////////////////

/**
 * Class representing a sidebar option and all of its elements. Its purpose is to
 * to generate the HTML of the element itself. Instances of this class should be
 * indexed by section for easy retrieval.
 */
class SidebarOption {
	public string $section; // rate
	public string $div_id; // sidebar-rate
	public string $option_name; // "Rate a TA"
	public string $img_src; // "pictures/stars.svg"
	public string $link; // "rate.php"
	
	/** Constructor for a sidebar option class. Takes all properties as argument. */
	public function __construct(string $section, string $div_id, string $option_name, string $img_src, string $link) {
		$this->section = $section;
		$this->div_id = $div_id;
		$this->option_name = $option_name;
		$this->img_src = $img_src;
		$this->link = $link;
	}

	/** Debugging. Prints content of object. */
	public function __toString() {
		return sprintf("SectionID = %s, div_id = %s, Text = %s, Img = %s, Link = %s\n", $this->section, $this->div_id, $this->option_name, $this->img_src, $this->link);
	}

	/**
	 * Generates a string containing the HTML code of this element, following
	 * the predetermined format.
	 */
	public function generate() {

		$sidebarOptionTemplate = '
		<a class="sidebar-item%s" id="sidebar-%s" href="%s">
			<div class="sidebar-item-tick"></div>
			<img class="sidebar-item-svg" src="%s">
			<div class="sidebar-item-text" href="$LINK$">%s</div>
		</a>
		';

		// Sets the current field.
		global $CURRENT_SECTION;
		$selected = "";
		if ($CURRENT_SECTION == $this->section) {
			$selected = " sidebar-current";
		}
		
		return sprintf($sidebarOptionTemplate, $selected, $this->div_id, $this->link, $this->img_src, $this->option_name);
	}
}

/** Index of every imported sidebar options, indexed by section id. */
$index = array();

// Adapted from https://www.php.net/manual/en/function.fgetcsv.php
$handle = fopen(__ROOT_DIR__."sidebar/sidebar_option.csv", "r") or die("Error while loading sidebar");
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	// data = section,div_id,option_name,img_src,reference
	$sidebarOption = new SidebarOption($data[0], $data[1], $data[2], $data[3], $data[4]);
	$index[$data[0]] = $sidebarOption;
}
fclose($handle);

// Only students have access to Rate a TA
if ($is_student) {
	echo $index["rate"]->generate();
}
// Only TA's and above have access to management
if ($is_ta || $is_prof || $is_admin || $is_sysop) {
	echo $index["management"]->generate();
}
// Only admins and above have access to administration
if ($is_admin || $is_sysop) {
	echo $index["admin"]->generate();
}
// Only sysops have access to sysop tasks
if ($is_sysop) {
	echo $index["sysop"]->generate();
}

/* ////////////////////// SIDEBAR PROFILE GENERATION FORMAT \\\\\\\\\\\\\\\\\\\\\\
<a class="sidebar-item" id="sidebar-user" href=profile.php>
	<div class="sidebar-item-tick"></div>
	<img id="sidebar-user-img" src="pictures/profilepic.jpg">
	<div id="sidebar-user-text">
		<div id="username">John Doe</div>
		<div id="userrole">System Administrator</div>
	</div>
</a>
Note: If there are no profile pictures (most likely), src="pictures/id_full_white.svg"
*/

/* ////////////////////// SIDEBAR OPTIONS GENERATION FORMAT \\\\\\\\\\\\\\\\\\\\\\
<a class="sidebar-item %__SELECTED__%" id="sidebar-%__NAME__%" href="%__LINK__%">
	<div class="sidebar-item-tick"></div>
	<img class="sidebar-item-svg" src="pictures/%__ICON__%.svg">
	<div class="sidebar-item-text" href="$LINK$">$__TEXT__$</div>
</a>
Note: Replace __SELECTED__ with sidebar-current as appropriate.
*/

?>

<!-- Permanent sidebar elements -->
<div style="height: 100%;"></div>
<div id="copyright" style="display:flex; padding: 5px 0; flex-shrink: 0; min-width: 240px;">
	<div style="padding: 0 15px;">Copyright 2022</div>
	<a href="https://support.microsoft.com/en-us/office/insert-icons-in-microsoft-office-e2459f17-3996-4795-996e-b9a13486fa79" style="text-decoration: none; color: white;">Attributions</a>
</div>