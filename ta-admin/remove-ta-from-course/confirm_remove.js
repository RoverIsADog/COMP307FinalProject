/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"chosenCourse", "chosenTerm"}
 * @see get_tas.php
 * @param {string} selectedTA 
 */
 function selectedTA(selectedTaIdx) {
	console.log("Course-term option selected: " + selectedTaIdx);
	// Prepare PHP call
	fileString ="ta-admin/remove-ta-from-course/build_course_dropdown.php?dropdown_index=" + selectedTaIdx;
	try {
		/**
		 * Callback function to replace the content of the courses dropdown when
		 * the async call returns.
		 */
		 function populateTAsDropdown() {
			if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
				var x = document.getElementById("course-dropdown-container");
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
selectedTA
/**
 * Upon selecting a value in the courses list, finally display the rating,
 * comments and submit buttons.
 * @param {string} value 
 */
function selectedCourseTerm(selectedCourseTerm) {
	console.log("TA option selected: " + selectedCourseTerm);
	let stars = document.getElementById("rate-star-container");
	let comments = document.getElementById("rate-comment-container");
	let button = document.getElementById("rate-submit-button");
	stars.style.display = "block";
	comments.style.display = "block";
	button.style.display = "block";
}

const reviewForm = document.getElementById("remove-ta-form");

reviewForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting form...");
	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			console.log(asyncRequest.responseText);
			alert(asyncRequest.responseText);
			window.location.replace("admin.php?page=remove_ta_from_course");
		}

		console.log("Removal form submitted!");
		var asyncRequest = new XMLHttpRequest(); // We dont actually care about state changes
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "ta-admin/remove-ta-from-course/confirm_remove.php");
		asyncRequest.send(new FormData(reviewForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});