<!-- /////////// BOX NAVIGATION FORMAT ///////////
<div class="box-nav">
	<img class="box-nav-back" src="pictures/backarrow.svg">
	<div class="box-nav-text">
		<div class="box-nav-path">Sysop Tasks / <b>Manually Add a Prof and Course</b></div>
		<div class="bold"></div>
		<div class="box-nav-description">
			<div class="box-nav-description-text">View TA Information</div>
		</div>
	</div>
</div>
-->
<div class="box-nav">
	<a class="box-nav-back-container" href="#">
		<img class="box-nav-back" src="pictures/backarrow.svg">
	</a>
	<div class="box-nav-text">
		<div class="box-nav-path">Sysop Tasks / <b>Manually Add a Prof and Course</b></div>
		<div class="box-nav-description">
			<div class="box-nav-description-text">View TA Information</div>
		</div>
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
	</form>
</div>

<?php
require(__DIR__ . "rootpath.php");
/* Loads the box content according to the guidelines.

INPUTS:
From parent PHP:
		$is_student = true;
		$is_ta = true;
		$is_prof = true;
		$is_admin = true;
		$is_sysop = true;
		$CURRENT_SECTION: string; {"profile", "rate", "admin", "management, "sysop"}
		$CURRENT_PAGE: m/......

EFFECTS/OUTPUTS:
		This function should create and output the relevant box content based on the
		current section, requested bage (GET_["Page"]), and the user's permissions.


This function will delegate the creation of individual pages to the php and python
files relevant to each. It merely calls them.
*/


/* /////////// BOX NAVIGATION FORMAT ///////////
<div class="box-navigation">
	<img class="box-navigation-back" src="pictures/backarrow.svg">
	<div class="box-navigation-text">
		<div class="box-navigation-path">%CATEGORY / %<span class="bold">%SECTION%</span></div>
		<div class="box-navigation-description">%Description%</div>
	</div>   
<div>
*/

$headerTemplate = '
<div class="box-nav">
	<img class="box-nav-back" src="pictures/backarrow.svg">
	<div class="box-nav-text">
		<div class="box-nav-path">%s / <b>%s</b></div>
		<div class="box-nav-description">
			<div class="box-nav-description-text">View TA Information</div>
		</div>
	</div>
</div>
'




?>