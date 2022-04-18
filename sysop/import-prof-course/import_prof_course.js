const reviewForm = document.getElementById("import-form");

reviewForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting form...");
	try {

		function callbackFunc() {
			alert(request.responseText);
			window.location.replace("sysop.php?page=import_prof_course");

		}

		console.log("Import command sent!");
		var request = new XMLHttpRequest(); // We dont actually care about state changes
		request.onload = callbackFunc
		request.open("POST", "sysop/import-prof-course/import_prof_course.php");
		request.send(new FormData(reviewForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});