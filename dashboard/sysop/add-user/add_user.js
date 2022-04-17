const addUserForm = document.getElementById("add-user-form");

addUserForm.addEventListener("submit", (e) => {
	e.preventDefault();
	console.log("Submitting form...");

	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			alert(request.responseText);
			window.location.replace("sysop.php?page=add_user")
		}

		// Creating request
		console.log("New user form submitted!");
		var request = new XMLHttpRequest();
		request.onload = callbackFunc;
		request.open("POST", "sysop/add-user/add_user.php");

		// Encrypting password
		let data = new FormData(addUserForm);
		let unencryptedPassword = data.get('user-password');
		data.append('user-password', encryptPassword(unencryptedPassword));
		// Finally sending
		request.send(data);
	}
	catch (exception) {
		alert("Error while submitting the request");
	}

});

/**
 * Encrypts the password. Since we are not exchanging public keys
 * between the server and user, we will not be actually be encrypting
 * the password. This function is here to enable adding this feature
 * more easily.
 * This function assumes that the server's public key is somewhere
 * inside the session or local storage.
 * @param {string} Password 
 * @returns Encrypted input using the server's public key.
 */
function encryptPassword(Password) {
	return Password;
}