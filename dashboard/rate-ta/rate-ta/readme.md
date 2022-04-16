## Generation plan for rate_ta
1. Use `get_courses.php` to get a list of `course_number,term_month_year` for this user.
2. Save this list in session `["rate_ta_courseslist"]`.
3. Build the page using this data: value=index in list, text=formatted(coursenum, term).
  * Using the value as the index in the table since it is smaller and most importantly it does not expose the TA's studentid to the user.
## Async Execution Plan for rate_ta
1. Upon choosing a course-term option, async call to `get_tas.php`. Arguments are `dropdown_index=n`,where n represents the index inside `$_SESSION["rate_ta_courseslist"]` (input validation).
2. `get_tas.php` calls `get_tas.py` and reads its output.
3. `get_tas.php` formats the output into select choices and returns from async call.
4. `populateTAsDropdown()` inserts content into `rate-courses-dropdown-container`

## User Chooses a TA
1. Call `selectedTA()` to make the rating and text field visible.

## List of important Variables
### `PHP $_SESSION`
* `rate_ta_courseslist`: Stores a list of `index` -> csv-line `courseID,termMonthYear`
  * Represents courses dropdown elements that should be available to user.
  * Relevant to current user.
* `rate_ta_taslist`: Stores the list of `index` -> csv-line `studentID,ta_name`
  * Represent TAs dropdown elements that should be available to user.
  * Relevant to current user, given selection of course/term. Only gotten after course/term selected.
### AJAX
* `dropdown_index` (POST): Stores the index of the course/term dropdown element selected by the user. __CROSS REFERENCE WITH `rate_ta_courseslist`__.
* Each fields of the form for the call to `add_rating.php`.