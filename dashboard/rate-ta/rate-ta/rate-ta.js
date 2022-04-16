/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"chosenCourse", "chosenTerm"}
 * @see get_tas.php
 * @param {string} selectedTA 
 */
function selectedCourseTerm(selectedCourseTerm) {
	// Gather information requried for the query.
	// Prepare PHP call
	fileString ="rate-ta/rate-ta/get_tas.php?dropdown_index=" + selectedCourseTerm;
	try {
		// Create the async request
		asyncRequest = new XMLHttpRequest();
		asyncRequest.onreadystatechange = populateTAsDropdown; // callback
		asyncRequest.open("GET", fileString, true);
		asyncRequest.send(null);
	}
	catch (exception) {
		alert("Error while retrieving course information for this TA");
	}
}

/**
 * Callback function to replace the content of the courses dropdown when
 * the async call returns.
 */
function populateTAsDropdown() {
	if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
		var x = document.getElementById("rate-courses-dropdown-container");
		x.innerHTML = asyncRequest.responseText;
	}
}

/**
 * Upon selecting a value in the courses list, finally display the rating,
 * comments and submit buttons.
 * @param {string} value 
 */
function selectedTA(value) {
	var stars = document.getElementById("rate-star-container");
	var comments = document.getElementById("rate-comment-container");
	var button = document.getElementById("rate-submit-button");
	stars.style.display = "block";
	comments.style.display = "block";
	button.style.display = "block";
}

const reviewForm = document.getElementById("rate-ta-form");

reviewForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page

	const asyncRequest = new XMLHttpRequest(); // We dont actually care about state changes
	asyncRequest.open("POST", "add_rating.php");
	


});