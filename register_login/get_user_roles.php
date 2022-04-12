<?php
// Use __ROOT_DIR__ to refer to root directory from here
require(__DIR__ . "/../rootpath.php");

/* PERMISSIONS CHECKING AND SETTING
Since this is running on the server, the boolean variables below will never
be accessible to the user.

INPUTS:
From parent PHP:
	$username
	
	$is_student = false;
	$is_prof = false;
	$is_admin = false;
	$is_sysop = false;
	$is_ta = false;

EFFECTS/OUTPUTS:
	This function should set the value of the input booleans. More than one
	variables could be true.
*/

// Python INPUT
// --username = $username

// Python OUTPUT: 5-long list of 0 or 1
/*
is_student -> $output[0]
is_prof -> $output[1]
is_admin -> $output[2]
is_sysop -> $output[3]
is_ta -> $output[4]
*/


//echo "permissions.php ran! <br>";

?>