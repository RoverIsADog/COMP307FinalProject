const addForm = document.getElementById("add-prof-course-form");

addForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting form...");
	try {

		function callbackFunc() {
			console.log(asyncRequest.responseText);
			// window.location.replace("sysop.php?page=manual_import_prof_course");
		}

		console.log("Import command sent!");
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "sysop/manual-add-prof-course/manual_import_prof_course.php");
		asyncRequest.send(new FormData(addForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}
});