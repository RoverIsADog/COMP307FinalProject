<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script async type="text/javascript" src="rate-ta/rateta.js"></script>

<div class="content-box">
    <div class="box-navigation">
      <img class="box-navigation-back" src="pictures/backarrow.svg">
      <div class="box-navigation-text">
        <div class="box-navigation-path">Administration Tools / <span class="bold">Rate a TA</span></div>
        <div class="box-navigation-description">Select a TA to rate</div>
      </div>   
    </div>
    
    <div class="content-box">
      <!-- ///////////////////////////// CONTENT (JUST PRINT INTO HERE) ///////////////////////////// -->
      <form action="" method="post">
        <!-- TA Select -->
        <div id="rate-ta-dropdown-container">
          <select id="rate-ta-dropdown" name="ta-select-dropdown" onchange="selectedTA(this.value)" >
            <option selected disabled>Please Select a course and term</option>
            <option value="COMP307,winter2022">COMP307 [winter 2022]</option>
            <option value="COMP308,winter2023">COMP308 [winter 2023]</option>
            <option value="COMP309,winter2024">COMP309 [winter 2024]</option>
            <option value="COMP310,winter2025">COMP310 [winter 2025]</option>
            <option value="COMP311,winter2026">COMP311 [winter 2026]</option>
          </select>
        </div>

        <!-- Courses select -->
        <div id="rate-courses-dropdown-container" style="width: 100%;" onchange="selectedTerm(this.value)">
        </div>

        <!-- Start Rating -->
				<div id="rate-star-container" class="star-select" style="display: none;">
          <div class="heading2">How would you rate this TA?</div>
					<input type="radio" name="numberstars" value="1" id="star1">1
					<input type="radio" name="numberstars" value="2" id="star2">2
					<input type="radio" name="numberstars" value="3" id="star3">3
					<input type="radio" name="numberstars" value="4" id="star4">4
					<input type="radio" name="numberstars" value="5" id="star5">5
				</div>

        <!-- Content box -->
        <div id="rate-comment-container" style="display: none;">
          <div class="">Comments (optional)</div>
          <textarea type="text" name="ratecomments" wrap="physical" class="spanning-textbox"></textarea>
        </div>

        <button id="rate-submit-button" class="button positive-button" type="submit" style="display: none;">Submit</button>
				
			</form>

      <!-- ///////////////////////////// CONTENT (JUST PRINT INTO HERE) ///////////////////////////// -->
    </div>
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
		$current_section: string; {"profile", "rate", "admin", "management, "sysop"}
		$current_page: m/......

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



?>