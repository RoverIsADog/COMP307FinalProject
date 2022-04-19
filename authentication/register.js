// const loginButton = document.getElementById("login-button");
const loginForm = document.getElementById("register-form");

loginForm.addEventListener("submit", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting REGISTER form...");

//	}
	
	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			console.log("Hello");
			console.log(asyncRequest.responseText);
			return;
			output = JSON.parse(asyncRequest.responseText);
			console.log(output.message);
			// No problems, account created and saved
			if (output.exitcode === "0") {
				alert("Before proceeding");
				window.location.replace("../profile.php");
			}
			else if (output.exitcode === "1" || output.exitcode === "2" || output.exitcode === "3") {
				alert("User already exists");
			}
			else if (output.exitcode === "4") {
				alert("The two passwords do not match.");
			}
			else if (output.exitcode === "5" || output.exitcode === "6") {
				alert("Could not grant requested role and defaulted to student. Please contact a system oprator to have your role changed.");
			}
			else if (output.exitcode === "7") {
				alert("ERROR.");
			}
			else {
				alert("An exception occured.");
			}
		}

		console.log("Register initiated!");
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "register.php");
		asyncRequest.send(new FormData(loginForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});