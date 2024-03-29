<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__DIR__ . "/get_courses.php");
if (__DEBUG__) echo "Generating the rate_ta page. <br>\n";
?>


<form action="" id="rate-ta-form">

	<?php
	// ==================================================== PHP START ====================================================
	/**
	 * Build the course/term select dropdown that will be initially visible.
	 */

	// Get courses using python
	$coursesList = getCourses();

	if (__DEBUG__) echo "Gotten list: <br>\n" . print_r($coursesList, true) . "<br>\n";

	// Stop here if the list is empty
	if (sizeof($coursesList) == 0) {
		echo "<h2>You are not registered to any courses</h2>";
		return;
	}

	// Store the available choices to compare to output.
	$_SESSION["rate_ta_courseslist"] = $coursesList;
	
	if (__DEBUG__) echo "List of courses for generation: \n";
	if (__DEBUG__) print_r($coursesList);
	if (__DEBUG__) echo print_r($_SESSION["rate_ta_courseslist"], true);
	
	$selectContainer = '
	<!-- Course Select -->
	<div id="rate-courses-dropdown-container">
		<select id="rate-courses-dropdown" name="rate-courses-dropdown" onchange="selectedCourseTerm(this.value)">
			<option value="NONE" selected disabled>Please select a course and term</option>
			%s
		</select>
	</div>
	';

	$inputTemplate = '<option value="%s">%s [%s]</option>' . "\n";
	
	/* For each line, create an input with:
	value: index in the array;
	display: course_id [term_month_year]
	*/
	$selectOptions = "";
	foreach ($coursesList as $optionNum => $entry) {
		$curLine = str_getcsv($entry);
		$selectOptions = $selectOptions . sprintf($inputTemplate, $optionNum, $curLine[0], $curLine[1]);
	}

	echo sprintf($selectContainer, $selectOptions);

	// ==================================================== PHP END ====================================================
	?>


	<!-- Courses select, POPULATED ASYNCHRONOUSLY -->
	<div id="rate-ta-dropdown-container" style="width: 100%;"></div>

	<!-- Start Rating, HIDDEN UNTIL COURSE CHOSEN -->
	<div id="rate-star-container" class="star-select" style="display: none;">
		<h2>How would you rate this TA?</h2>
		<input type="radio" name="numberstars" value="1" id="star1">1
		<input type="radio" name="numberstars" value="2" id="star2">2
		<input type="radio" name="numberstars" value="3" id="star3">3
		<input type="radio" name="numberstars" value="4" id="star4">4
		<input type="radio" name="numberstars" value="5" id="star5">5
	</div>

	<!-- Comment box -->
	<div id="rate-comment-container" style="display: none;">
		<div class="">Comments (optional)</div>
		<textarea type="text" name="ratecomments" id="ratecomments" wrap="physical" class="spanning-textbox"></textarea>
	</div>

	<button id="rate-submit-button" class="button positive-button" type="submit" style="display: none;">Submit</button>
				
</form>
