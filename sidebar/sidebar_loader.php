<div class="sidebar-item" id="sidebar-user"> <!-- User Profile -->
	<div class="sidebar-item-tick"></div>
	<img id="sidebar-user-img" src="pictures/id_full_white.svg">
	<div id="sidebar-user-text">
		<div id="username">John Doe</div>
		<div id="userrole">System Administrator</div>
	</div>
</div>

<?php
require(__DIR__ . "/../rootpath.php");
/* Loads the sidebar according to the guidelines.
I don't care what happens in here, but after this block $loggedIn should
be set to the proper value! (T/F).

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

/* /////////// SIDEBAR PROFILE GENERATION FORMAT ///////////
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

function displayFile($filePath) {
	$file = fopen($filePath, "r") or die("An error has occured, please contact a system administrator.");
	while (!feof($file)) {
		$line = fgets($file);
		echo $line;
	}
	fclose($file);
}


/* /////////// SIDEBAR OPTIONS GENERATION FORMAT ///////////
<a class="sidebar-item" id="sidebar-$NAME$" href="$LINK$">
	<div class="sidebar-item-tick"></div>
	<img class="sidebar-item-svg" src="pictures/$ICON$.svg">
	<div class="sidebar-item-text" href="$LINK$">$TEXT$</div>
</a>
*/

// Students only have access to Rate a TA
if ($is_student) {
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_rate.html");
}
// TAs have access to Rate a TA and Management-Channel (we're not doing it, but I'll include the choice)
if ($is_ta) {
    displayFile(__ROOT_DIR__ . "sidebar/sidebar_rate.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_management.html");
}
// Profs have access to TA Management and Rate a TA
if ($is_prof) {
    displayFile(__ROOT_DIR__ . "sidebar/sidebar_rate.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_management.html");
}
// Admins have access to Rate a TA, TA Management and Ta Administration
if ($is_admin) {
    displayFile(__ROOT_DIR__ . "sidebar/sidebar_rate.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_management.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_admin.html");
}
// Sysops have access to everything
if ($is_sysop) {
    displayFile(__ROOT_DIR__ . "sidebar/sidebar_rate.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_management.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_admin.html");
	displayFile(__ROOT_DIR__ . "sidebar/sidebar_sysop.html");
}


?>