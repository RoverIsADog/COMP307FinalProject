const loginButton = document.getElementById("login-button");
const loginForm = document.getElementById("login-form");

loginButton.addEventListener("click", (e) => {
	e.preventDefault(); // Don't refresh page
	console.log("Submitting LOGIN form...");

	// Try to avoid doing to the backend by also checking locally
	let userField = document.getElementById("username");
	let passField = document.getElementById("password");
	if (userField.value === "" || passField.value === "") {
		alert("Please enter both username and password1.");
		return;
	}


	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			output = JSON.parse(asyncRequest.responseText);
			console.log(output);
			console.log(output.message);
			// No problems, ticket created and saved
			if (output.exitcode === "0") {
				window.location.replace("../profile.php");
			}
			else if (output.exitcode === "1") {
				alert("Please enter both username and password.");
			}
			else if (output.exitcode === "2") {
				alert("No matching username or password.");
			}
			else {
				alert("An exception occured.");
			}
		}

		console.log("Login initiated!");
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onload = callbackFunc
		asyncRequest.open("POST", "login.php");
		asyncRequest.send(new FormData(loginForm));
	}
	catch (exception) {
		alert("Error while submitting the rating.");
	}

});