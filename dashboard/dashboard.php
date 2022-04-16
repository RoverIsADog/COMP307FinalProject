<?php
session_start();

# __ROOT_DIR__ = /var/www/html/dashboard/
require_once(__DIR__ . "/rootpath.php");
require_once(__ROOT_DIR__ . "/utils/errors.php");

// echo print_r($_SESSION) . "<br>\n";
// echo "Username is " . $_SESSION["username"] . "<br>\n";
// echo "Ticket is " . $_SESSION["ticket"] . "<br>\n";
// $CURRENT_SECTION = "admin";
// $CURRENT_PAGE = "";

/*
INPUTS (Already defined variables):
	$CURRENT_SECTION
		String name of the current section: {"profile", "rate", "admin", "management, "sysop"}
	$CURRENT_SECTION
*/

// Trying to access dashboard.php directly: redirect to profile
if (!isset($CURRENT_SECTION)) {
	header("Location: profile.php");
}

// Get the requested page
if (key_exists("page", $_GET)) {
	$CURRENT_PAGE = $_GET["page"];
}
else {
	$CURRENT_PAGE = "";
}

// Loading master page record
$jsonStr = file_get_contents(__ROOT_DIR__ . "existing_sections.json");
$json = json_decode($jsonStr, true);

// Checking for authentication
$isAuth = true;
require(__ROOT_DIR__ . "authentication/authenticate.php"); // <-- MICHEAL'S CODE
if (!$isAuth) { // Exit if not authorized.
	echo "You do not have authorization to view this page!";
	exit();
}

// Permissions setting
$is_student = true; $is_ta = true; $is_prof = true; $is_admin = true; $is_sysop = true;
require(__ROOT_DIR__ . "authentication/get_user_roles.php"); // <-- MICHEAL'S CODE

// Create list of permissions for this user
$userPermissions = array();
if ($is_student) array_push($userPermissions, "student");
if ($is_ta) array_push($userPermissions, "ta");
if ($is_prof) array_push($userPermissions, "prof");
if ($is_admin) array_push($userPermissions, "admin");
if ($is_sysop) array_push($userPermissions, "sysop");

// ==================================================== PHP END ====================================================
?>

<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="template.css">
	<link rel="stylesheet" type="text/css" href="header.css">
	<link rel="stylesheet" type="text/css" href="sidebar.css">
	<link rel="stylesheet" type="text/css" href="content-box.css">
	<link rel="stylesheet" type="text/css" href="content-elements.css">
	<script type="text/javascript" src="dashboard.js"></script>
	<script src="jquery-3.6.0.min.js"></script>
	<?php
	// ==================================================== PHP START ====================================================
	// Loading dependencies
	require_once(__ROOT_DIR__ . "utils/dependency_loader.php");
	importDependencies($json, $CURRENT_SECTION, $CURRENT_PAGE);
	// ==================================================== PHP END ====================================================
	?>

</head>

<body style="font-family: Arial, Helvetica, sans-serif; margin: 0;">
<!-- Header -->
<header id="header">
	<div id="header-container"> <!-- Flexbox to contain the header items -->
		<div class="header-box" id="hamburger-box" onclick="javascript:toggleNav()">
			<div id="hamburger-container">
				<div></div><div></div><div></div>
			</div>
		</div>
		<a class="header-box" id="birdbox" href="https://www.cs.mcgill.ca/">
			<img id="bird" src="pictures/bird.png">
		</a>
		<div class="header-box" id="whitebarbox"></div>
		<a class="header-box header-text-box" id="sitenamebox" href="profile.php">TA Management Dashboard</a>
		<div class="header-box" id="header-filler-box" style="flex-grow: 1"></div>
		<a class="header-box header-text-box" id="logoutbox" href="authentication/logout.php">Logout</a>
	</div>
</header>

<!-- Anything below the header -->
<div id="page-container">
	<!--  Sidebar related -->
	<div id="sidebar-hitbox"></div> <!-- =/= sidebar itself -->
	<div id="sidebar" class="sidebar-closed">
		<?php
		// ==================================================== PHP START ====================================================

		// Generating the profile and options on the sidebar
		require( __ROOT_DIR__ . "sidebar/sidebar_loader.php");

		// ==================================================== PHP END ====================================================
		?>

	</div>

	<!-- Container for the content box -->
	<div id="content-area">
		<!-- Content box itself -->
		<div class="content-box">
			<?php
			if (!empty($CURRENT_PAGE) || !empty($CURRENT_SECTION) || !empty($json) || !empty($userPermissions)) {
				echo "Variable unset error<br>\n";
			}
			// ==================================================== PHP START ====================================================

			echo "About to call content_loader with CURRENT_SECTION: $CURRENT_SECTION<br>\n";
			echo "About to call content_loader with CURRENT_PAGE: $CURRENT_PAGE<br>\n";
		
			echo "Trying to generate $CURRENT_SECTION / $CURRENT_PAGE<br>\n";
		
			echo "You have permissions: <br>\n";
			echo print_r($userPermissions, true) . "<br>\n";
		
			/* ==================================== Section processing ==================================== */
		
			// The requested section does not exists
			if (!key_exists($CURRENT_SECTION, $json)) {
				notFound();
				return;
			}
		
			$selectedSection = $json[$CURRENT_SECTION];
		
			echo "The requested page requires permissions: <br>\n";
			echo print_r($selectedSection["allowedRoles"], true) . "<br>\n";
		
		
			// Check section permissions
			if (sizeof(array_intersect($userPermissions, $selectedSection["allowedRoles"])) == 0) {
				forbidden();
				return;
			}

			// Section security checks done, load section with designated section loader
			echo "Building section $CURRENT_SECTION with " . __ROOT_DIR__ . $json[$CURRENT_SECTION]["sectionFolder"] . "/section_loader.php <br>\n";
			require(__ROOT_DIR__ . $json[$CURRENT_SECTION]["sectionFolder"] . "/section_loader.php"); // <--- Inside each section's folder

			// ==================================================== PHP END ====================================================
			?>
		</div>
	</div>
</div>
</body>