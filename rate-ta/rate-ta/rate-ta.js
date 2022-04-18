/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"chosenCourse", "chosenTerm"}
 * @see get_tas.php
 * @param {string} selectedTA 
 */
function selectedCourseTerm(selectedCourseTerm) {
	console.log("Course-term option selected: " + selectedCourseTerm);
	// Prepare PHP call
	fileString ="rate-ta/rate-ta/get_tas.php?dropdown_index=" + selectedCourseTerm;
	try {
		/**
		 * Callback function to replace the content of the courses dropdown when
		 * the async call returns.
		 */
		 function populateTAsDropdown() {
			if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
				var x = document.getElementById("rate-ta-dropdown-container");
				x.innerHTML = asyncRequest.responseText;
			}
		}

		// Create the async request
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onreadystatechange = populateTAsDropdown; // callback
		asyncRequest.open("GET", fileString, true);
		asyncRequest.send(null);
	}
	catch (exception) {
		alert("Error while retrieving courses.");
	}
}

/**
 * Upon selecting a value in the courses list, finally display the rating,
 * comments and submit buttons.
 * @param {string} value 
 */
function selectedTA(selectedTa) {
	console.log("TA option selected: " + selectedTa);
	let stars = document.getElementById("rate-star-container");
	let comments = document.getElementById("rate-comment-container");
	let button = document.getElementById("rate-submit-button");
	stars.style.display = "block";
	comments.style.display = "block";
	button.style.display = "block";
}

const reviewForm = document.getElementById("rate-ta-form");

reviewForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting form...");
	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			alert(asyncRequest.responseText);
			window.location.replace("rate.php?page=rate_ta");

		}

		console.log("TA review form submitted!");
		var asyncRequest = new XMLHttpRequest(); // We dont actually care about state changes
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "rate-ta/rate-ta/add_rating.php");
		asyncRequest.send(new FormData(reviewForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});