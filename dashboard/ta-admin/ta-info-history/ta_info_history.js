/**
 * Triggered upon selecting a value in the TA dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"chosenCourse", "chosenTerm"}
 * @see get_tas.php
 * @param {string} selectedTA 
 */
 function selectedCourseTerm(selectedTA) {
	console.log("Course-term option selected: " + selectedTA);
	// Prepare PHP call
	fileString ="ta-admin/ta-info-history/populate_content.php?dropdown_index=" + selectedTA;
	try {
		/**
		 * Callback function to replace the content of the courses dropdown when
		 * the async call returns.
		 */
		 function populateInfo() {
			if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
				var x = document.getElementById("ta-info-container");
				x.innerHTML = asyncRequest.responseText;
			}
		}

		// Create the async request
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onreadystatechange = populateInfo; // callback
		asyncRequest.open("GET", fileString, true);
		asyncRequest.send(null);
	}
	catch (exception) {
		alert("Error while retrieving TAs for this course");
	}
}