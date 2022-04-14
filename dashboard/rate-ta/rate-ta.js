/**
 * Triggered upon selecting a value in the course-term dropdown. Creates an async
 * call to the backend for the requested information with the following
 * structure: GET {"username", "ticket", "chosenta"}
 * @see rate_getcourses.php
 * @param {string} selectedTA 
 */
function selectedTA(selectedCourseTerm) {
    // Gather information requried for the query.
    var username=sessionStorage.getItem("username");
    var ticket=sessionStorage.getItem("ticket");
    var courseTermArr = selectedCourseTerm.split(",");
    // Prepare PHP call
    fileString = "rate-ta/get_tas.php?" +
        "username=" + username +
        "&ticketid=" + ticket + 
        "&chosenCourse=" + courseTermArr[0] +
        "&chosenTerm=" + courseTermArr[1];
    try {
        // Create the async request
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = populateCoursesDropdown; // callback
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