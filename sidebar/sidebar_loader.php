<!-- Currently not generating the user TODO remove this-->
<a class="sidebar-item" id="sidebar-user" href="profile.php"> <!-- User Profile -->
	<div class="sidebar-item-tick"></div>
	<img id="sidebar-user-img" src="pictures/id_full_white.svg">
	<div id="sidebar-user-text">
		<div id="username">John Doe</div>
		<div id="userrole">System Administrator</div>
	</div>
</a>

<?php
require(__DIR__ . "/../rootpath.php");
/* Loads the sidebar according to the guidelines.

INPUTS:
From parent PHP:
		$is_student = true;
		$is_ta = true;
		$is_prof = true;
		$is_admin = true;
		$is_sysop = true;

EFFECTS/OUTPUTS:
		This function should create and output the relevant sidebar elements depending
		on the permissions. This function has no effects.
*/

function displayFile($filePath) {
	$file = fopen($filePath, "r") or die("An error has occured, please contact a system administrator.");
	while (!feof($file)) {
		$line = fgets($file);
		echo $line;
	}
	fclose($file);
}

/* ////////////////////// SIDEBAR PROFILE GENERATION FORMAT //////////////////////
<div class="sidebar-item" id="sidebar-user">
	<div class="sidebar-item-tick"></div>
	<img id="sidebar-user-img" src="pictures/profilepic.jpg">
	<div id="sidebar-user-text">
		<div id="username">John Doe</div>
		<div id="userrole">System Administrator</div>
	</div>
</div>
Note: If there are no profile pictures (most likely), src="pictures/id_full_white.svg"
*/

// Put code to generate profile here.

/* ////////////////////// SIDEBAR OPTIONS GENERATION FORMAT //////////////////////
<a class="sidebar-item" id="sidebar-$NAME$" href="$LINK$">
	<div class="sidebar-item-tick"></div>
	<img class="sidebar-item-svg" src="pictures/$ICON$.svg">
	<div class="sidebar-item-text" href="$LINK$">$TEXT$</div>
</a>
*/

// Only students have access to Rate a TA
if ($is_student) {
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_rate.html");
}
// Only TA's and above have access to management
if ($is_ta || $is_prof || $is_admin || $is_sysop) {
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_management.html");
}
// Only admins and above have access to administration
if ($is_admin || $is_sysop) {
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_admin.html");
}
// Only sysops have access to sysop tasks
if ($is_sysop) {
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_sysop.html");
}

?>