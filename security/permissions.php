<?php
// Use __ROOT_DIR__ to refer to root directory from here
require(__DIR__ . "/../rootpath.php");

/* PERMISSIONS CHECKING AND SETTING
Since this is running on the server, the boolean variables below will never
be accessible to the user.

INPUTS:
From parent PHP:
    $is_student = false;
    $is_ta = false;
    $is_prof = false;
    $is_admin = false;
    $is_sysop = false;

EFFECTS/OUTPUTS:
    This function should set the value of the input booleans. Only one of the 
    input booleans should be true. No output.
*/


//echo "permissions.php ran! <br>";

?>