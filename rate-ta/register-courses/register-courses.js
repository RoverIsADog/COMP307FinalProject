const reviewForm = document.getElementById("register-courses-form");

reviewForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting registration form...");
	try {

		function callbackFunc() {
			alert(asyncRequest.responseText);
			window.location.replace("rate.php?page=register_course");

		}

		console.log("Import command sent!");
		var asyncRequest = new XMLHttpRequest(); // We dont actually care about state changes
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "rate-ta/register-courses/add_registered_course.php");
		asyncRequest.send(new FormData(reviewForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});