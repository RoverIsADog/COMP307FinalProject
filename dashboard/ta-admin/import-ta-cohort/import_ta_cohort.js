const reviewForm = document.getElementById("import-form");

reviewForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting form...");
	try {

		function callbackFunc() {
			alert(asyncRequest.responseText);
			window.location.replace("admin.php?page=import_ta_cohort");

		}

		console.log("Import command sent!");
		var asyncRequest = new XMLHttpRequest(); // We dont actually care about state changes
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "ta-admin/import-ta-cohort/import_ta_cohort.php");
		asyncRequest.send(new FormData(reviewForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});