const addForm = document.getElementById("add-ta-to-course-form");

addForm.addEventListener("submit", (e) => {
	e.preventDefault();
	console.log("Submitting form...");

	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			alert(request.responseText);
			window.location.replace("admin.php?page=add_ta_to_course")
		}

		console.log("Add ta to course form submitted!");
		var request = new XMLHttpRequest();
		request.onload = callbackFunc;
		request.open("POST", "ta-admin/add-ta-to-course/add_ta_to_course.php");
		request.send(new FormData(addForm));
	}
	catch (exception) {
		alert("Error while submitting the request");
	}

})
;