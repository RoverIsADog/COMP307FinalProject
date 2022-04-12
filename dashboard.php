<!DOCTYPE html>

<?php
# __ROOT_DIR__ = /var/www/html/comp307final/
require("rootpath.php");

/*
INPUTS:
	$current_section
		String name of the current section: {"profile", "rate", "admin", "management, "sysop"}
*/

$loggedIn = true;
include(__ROOT_DIR__ . "security/authenticate.php"); // <-- MICHEAL'S CODE

// Login check. Anything beyond here won't run if this fails since we exit.
if (!$loggedIn) {
	echo "You must be logged in to view this page!";
	exit();
}

// Permissions setting
$is_student = false;
$is_ta = false;
$is_prof = false;
$is_admin = false;
$is_sysop = true;
include(__ROOT_DIR__ . "security/permissions.php");
?>

<head>
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="template.css">
  <link rel="stylesheet" type="text/css" href="header.css">
  <link rel="stylesheet" type="text/css" href="sidebar.css">
  <link rel="stylesheet" type="text/css" href="content.css">
	<script type="text/javascript" src="template.js"></script>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; margin: 0;">
<!-- Header (Nothing customized here) -->
<header id="header">
	<div id="header-container"> <!-- Flexbox to contain the header items -->
		<div class="header-box" id="hamburger-box" onclick="javascript:toggleNav()">
			<div id="hamburger-container">
				<div></div><div></div><div></div>
			</div>
		</div>
		<div class="header-box" id="birdbox"><img id="bird" src="pictures/bird.png"></div>
		<div class="header-box" id="whitebarbox"></div>
		<a class="header-box" id="sitenamebox" href="#">TA Management Dashboard</a>
		<div class="header-box" id="header-filler-box" style="flex-grow: 1"></div>
		<div class="header-box" id="header-course-box">
			PLACEHOLDER <br> COMP 307
		</div>
	</div>
</header>

<!-- Sidebar and content flexbox -->
<div id="page-container">
	<div id="sidebar-hitbox"></div> <!-- Only here to make site smooth -->

	<div class="sidebar-closed" id="sidebar">
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

	<div id="content-area">
		<div class="content-box">
				<!-- /////////// BOX NAVIGATION FORMAT ///////////
					<div class="box-navigation">
						<img class="box-navigation-back" src="pictures/backarrow.svg">
						<div class="box-navigation-text">
							<div class="box-navigation-path">%CATEGORY / %<span class="bold">%SECTION%</span></div>
							<div class="box-navigation-description">%Description%</div>
						</div>   
					</div>
				-->
			<div class="box-navigation">
				<img class="box-navigation-back" src="pictures/backarrow.svg">
				<div class="box-navigation-text">
					<div class="box-navigation-path">Sysop Tasks / <span class="bold">Manually Add a Prof and Course</span></div>
					<div class="box-navigation-description">View TA Information</div>
				</div>   
			</div>
			
			<!-- ///////////////////////////// CONTENT (JUST PRINT INTO HERE) ///////////////////////////// -->
			<div class="box-content">
				<form action="mini4.php" method="post">
					<div class="star-selection">
						<input type="radio" name="rating" value="1">
						<input type="radio" name="rating" value="2">
						<input type="radio" name="rating" value="3">
						<input type="radio" name="rating" value="4">
						<input type="radio" name="rating" value="5">
					</div>
					<select name="book" id="book-select">
							<option value="King Lear">King Lear</option>
							<option value="The Count of Monte Cristo">The Count of Monte Cristo</option>
							<option value="The Giver">The Giver</option>
							<option value="Anil's Ghost">Anil's Ghost</option>
							<option value="Nineteen Eighty-Four">Nineteen Eighty-Four</option>
							<option value="Do Android Dream of Electric Sheep?">Do Android Dream of Electric Sheep?</option>
							<option value="Heart of Darkness">Heart of Darkness</option>
					</select>
	
					<h2>Operating System</h2>
					Which operating system do you use? <br>
					<input type="radio" name="os" value="Windows"> Windows
					<input type="radio" name="os" value="Mac"> Mac OS X
					<input type="radio" name="os" value="Linux"> Linux
					<input type="radio" name="os" value="Other"> Other
	
					<br><br>
	
					<button class="button positive-button" type="submit">Register</button>

			</div>
		</div>
	</div>

</div>
</body>