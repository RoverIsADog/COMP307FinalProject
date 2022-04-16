<?php
session_start();
require_once(__DIR__ . "/../../rootpath.php");
require_once(__DIR__ . "/get_courses.php");
echo "Generating the rate_ta page. <br>\n";

$student_id = $_SESSION["student_id"];
$username = $_SESSION["username"];
$student_id = $_SESSION["ticket"];
?>


<form action="" id="rate-ta-form">

	<?php
	// ==================================================== PHP START ====================================================
	/**
	 * Build the course/term select dropdown that will be initially visible.
	 */

	// Get courses using python
	$coursesList = getCourses();

	if ($coursesList == null) {
		echo "<h1>An error occured...</h1>\n";
	}

	// echo print_r($coursesList);

	// Store the available choices to compare to output.
	$_SESSION["rate_ta_courseslist"] = $coursesList;
	
	error_log ( "List of courses for generation: \n", 3, __ROOT_DIR__ . "output.log");
	error_log( print_r($coursesList, true) , 3, __ROOT_DIR__ . "output.log");
	//echo print_r($_SESSION["rate_ta_courseslist"]);
	
	$selectContainer = '
	<!-- Course Select -->
	<div id="rate-ta-dropdown-container">
		<select id="rate-ta-dropdown" name="ta-select-dropdown" onchange="selectedCourseTerm(this.value)">
			<option value="NONE" selected disabled>Please select a course and term</option>
			%s
		</select>
	</div>
	';

	$inputTemplate = '<option value="%s">%s [%s]</option>' . "\n";
	$selectOptions = "";

	/* For each line, create an input with:
		value: index in the array;
		display: course_id [term_month_year]
	*/
	foreach ($coursesList as $optionNum => $entry) {
		$curLine = str_getcsv($entry);
		$selectOptions = $selectOptions . sprintf($inputTemplate, $optionNum, $curLine[0], $curLine[1]);
	}

	echo sprintf($selectContainer, $selectOptions);

	// ==================================================== PHP END ====================================================
	?>


	<!-- Courses select, POPULATED ASYNCHRONOUSLY -->
	<div id="rate-courses-dropdown-container" style="width: 100%;" onchange="selectedTA(this.value)"></div>

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
		<textarea type="text" name="ratecomments" wrap="physical" class="spanning-textbox"></textarea>
	</div>

	<button id="rate-submit-button" class="button positive-button" type="submit" style="display: none;">Submit</button>
				
</form>
