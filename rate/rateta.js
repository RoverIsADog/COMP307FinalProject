/**
 * Triggered upon selecting a value in the TA dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"username", "ticket", "chosenta"}
 * @see rate_getcourses.php
 * @param {string} selectedTA 
 */
function selectedTA(selectedTA) {
    // Gather information requried for the query.
    var username=sessionStorage.getItem("username");
    var ticket=sessionStorage.getItem("ticket");
    fileString = "rate/rate_getcourses.php?" +
        "chosenta=" + selectedTA + "&username="
        + username + "&ticket=" + ticket;
    try {
        // Create the async request
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = populateCoursesDropdown;
        asyncRequest.open("GET", fileString, true);
        asyncRequest.send(null);
    }
    catch (exception) {
        alert("Error while retrieving course information for this TA");
    }    
}

/**
 * Callback function to replace the content of the courses dropdown when
 * the async call returns.
 */
function populateCoursesDropdown() {
    if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
        var x = document.getElementById("rate-courses-dropdown-container");
        x.innerHTML = asyncRequest.responseText;
    }
}

/**
 * Upon selecting a value in the courses list, finally display the rating,
 * comments and submit buttons.
 * @param {string} value 
 */
function selectedTerm(value) {
    var stars = document.getElementById("rate-star-container");
    var comments = document.getElementById("rate-comment-container");
    var button = document.getElementById("rate-submit-button");
    stars.style.display = "block";
    comments.style.display = "block";
    button.style.display = "block";
}