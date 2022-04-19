/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information.
 * @see get_tas.php
 * @param {string} selectedTA 
 */
 function selectedCourseTerm(selectedCourseTerm) {
	console.log("Course-term option selected: " + selectedCourseTerm);
	// Prepare PHP call
	fileString ="ta-management/save_course_choice.php?dropdown_index=" + selectedCourseTerm;
	try {
		/**
		 * Callback function to replace the content of the courses dropdown when
		 * the async call returns.
		 */
		 function populateMenu() {
			if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
				// Display output (for debugging)
				console.log(asyncRequest.responseText);

				// Unhide menu
				var x = document.getElementById("management-menu-container");
				x.style.display = "block";
			}
		}

		// Create the async request
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onreadystatechange = populateMenu; // callback
		asyncRequest.open("GET", fileString, true);
		asyncRequest.send(null);
	}
	catch (exception) {
		alert("Error while retrieving courses.");
	}
}