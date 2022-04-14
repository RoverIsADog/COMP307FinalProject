<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
# __ROOT_DIR__ = /var/www/html/comp307final/
require("rootpath.php");

/*
INPUTS:
	$CURRENT_SECTION
		String name of the current section: {"profile", "rate", "admin", "management, "sysop"}
*/
/* Trying to access dashboard.php directly: redirect to profile */
if (!isset($CURRENT_SECTION)) {
	header("Location: profile.php");
}

$CURRENT_PAGE = $_GET["page"];

$isAuth = true;
include(__ROOT_DIR__ . "register_login/authenticate.php"); // <-- MICHEAL'S CODE

// Login check. Anything beyond here won't run if this fails since we exit.
if (!$isAuth) {
	echo "You do not have authorization to view this page!";
	exit();
}

// Permissions setting
$is_student = false;
$is_ta = false;
$is_prof = false;
$is_admin = false;
$is_sysop = true;
include(__ROOT_DIR__ . "register_login/get_user_roles.php");
?>

<head>
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="template.css">
	<link rel="stylesheet" type="text/css" href="header.css">
	<link rel="stylesheet" type="text/css" href="sidebar.css">
	<link rel="stylesheet" type="text/css" href="content-box.css">
	<link rel="stylesheet" type="text/css" href="content-elements.css">
	<script type="text/javascript" src="template.js"></script>
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
		<a class="header-box" id="sitenamebox" href="profile.php">TA Management Dashboard</a>
		<div class="header-box" id="header-filler-box" style="flex-grow: 1"></div>
	</div>
</header>

<!-- Anything below the header -->
<div id="page-container">
	<!-- ////////////////////////////// ANYTHING SIDEBAR RELATED ////////////////////////////// -->
	<div id="sidebar-hitbox"></div> <!-- Only here to make site smooth -->
	<div id="sidebar" class="sidebar-closed">
		<!-- PHP Generating the profile and options on the sidebar -->
		<?php
		include( __ROOT_DIR__ . "sidebar/sidebar_loader.php");
		?>

		<!-- Permanent sidebar elements -->
		<div style="height: 100%;"></div>
		<div id="copyright" style="display:flex; padding: 5px 0; flex-shrink: 0; min-width: 240px;">
			<div style="padding: 0 15px;">Copyright 2022</div>
			<a href="https://support.microsoft.com/en-us/office/insert-icons-in-microsoft-office-e2459f17-3996-4795-996e-b9a13486fa79" style="text-decoration: none; color: white;">Attributions</a>
		</div>
	</div>

	<!-- ////////////////////////////// THE CONTENT BOX ////////////////////////////// -->
	<div id="content-area">
		<div class="content-box">
			<?php
			include(__ROOT_DIR__ . "content_loader.php");
			?>
		</div>
	</div>
</div>
</body>