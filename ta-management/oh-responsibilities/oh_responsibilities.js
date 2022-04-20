/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information.
 * @see get_tas.php
 * @param {string} selectedTA 
 */
 function selectedInstructor(selectedInstr) {
	console.log("Course-term option selected: " + selectedInstr);
	// Prepare PHP call
	fileString ="ta-management/oh-responsibilities/populate_fields.php?dropdown_index=" + selectedInstr;
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
				var x = document.getElementById("editable-elements-container");
				x.innerHTML = asyncRequest.responseText;
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


const ohForm = document.getElementById("oh-responsibilities-form");

ohForm.addEventListener("submit", (e) => {
	e.preventDefault();
	console.log("Submitting OH change form...");

	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			console.log(request.responseText);
			alert(request.responseText);
			//window.location.replace("management.php?page=oh_responsibilities")
		}

		console.log("OH modification form submitted!");
		var request = new XMLHttpRequest();
		request.onload = callbackFunc;
		request.open("POST", "ta-management/oh-responsibilities/update_instructor_info.php");
		let fd = new FormData(ohForm);
		console.log(fd);
		request.send(fd);
	}
	catch (exception) {
		alert("Error while submitting the request");
	}

});