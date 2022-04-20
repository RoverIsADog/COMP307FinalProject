/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information.
 * @see get_tas.php
 * @param {string} selectedTA 
 */
function selectedTA(selectedTANum) {
	let x = document.getElementById("hidable-fields");
	x.style.display = "block";
}

const logForm = document.getElementById("add-log-form");

logForm.addEventListener("submit", (e) => {
	e.preventDefault();
	console.log("Submitting log form...");

	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			console.log(request.responseText);
			alert(request.responseText);
			// window.location.replace("management.php?page=add_performance_log")
		}

		console.log("log form submitted!");
		var request = new XMLHttpRequest();
		request.onload = callbackFunc;
		request.open("POST", "ta-management/add-performance-log/add_performance_log.php");
		let fd = new FormData(logForm);
		console.log(fd);
		request.send(fd);
	}
	catch (exception) {
		alert("Error while submitting the request");
	}

});
