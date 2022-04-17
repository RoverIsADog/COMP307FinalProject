/**
 * Triggered upon selecting a value in the user dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"selectedIndex"}
 * @see get_tas.php
 * @param {string} selectedTA 
 */
 function selectedUser(selectedUserIdx) {
	console.log("User number selected: " + selectedUserIdx);
	// Prepare PHP call
	fileString ="sysop/edit-user/populate_options.php?dropdown_index=" + selectedUserIdx;
	try {
		/**
		 * Callback function to replace the content of the courses dropdown when
		 * the async call returns.
		 */
		 function populateTAsDropdown() {
			if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
				var x = document.getElementById("editable-fields");
				x.innerHTML = asyncRequest.responseText;
				var buttons = document.getElementById("buttons");
				buttons.style.display = "block";
			}
		}

		// Create the async request
		var asyncRequest = new XMLHttpRequest();
		asyncRequest.onreadystatechange = populateTAsDropdown; // callback
		asyncRequest.open("GET", fileString, true);
		asyncRequest.send(null);
	}
	catch (exception) {
		alert("Error while retrieving courses.");
	}
}

const editForm = document.getElementById("edit-user-form");
const editButton = document.getElementById("modify-button");
const deleteButton = document.getElementById("delete-button");

editButton.addEventListener("click", (e) => {
	e.preventDefault();
	console.log("Submitting EDIT form...");

	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			alert(request.responseText);
			window.location.replace("sysop.php?page=edit_user")
		}

		// Creating request
		console.log("New edit form submitted!");
		var request = new XMLHttpRequest();
		request.onload = callbackFunc;
		request.open("POST", "sysop/edit-user/submit_changes.php");

		// Finally sending
		request.send(new FormData(editForm));
	}
	catch (exception) {
		alert("Error while submitting the request");
	}

});

deleteButton.addEventListener("click", (e) => {
	e.preventDefault();
	console.log("Submitting DELETE command...");

	try {

		/**
		 * Callback function that notifies the user of success or failure
		 * before refreshing the page.
		 */
		function callbackFunc() {
			alert(request.responseText);
			window.location.replace("sysop.php?page=edit_user")
		}

		let chosenUserNum = document.getElementById("user-select").value;
		let fileString = "sysop/edit-user/delete_user.php?dropdown_index=" + chosenUserNum;

		// Creating request
		console.log("New DELETE form submitted!");
		var request = new XMLHttpRequest();
		request.onload = callbackFunc;
		request.open("POST", fileString);

		// Finally sending
		request.send(null);
	}
	catch (exception) {
		alert("Error while submitting the request");
	}


});