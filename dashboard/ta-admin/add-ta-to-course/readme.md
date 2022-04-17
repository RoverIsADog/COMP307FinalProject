## Generation plan for add_ta_to_course
1. Get all TAs and all courses using `add_ta_utils.php` (calls `get_all_courses.py` and `get_all_tas.py`).
  * `get_all_courses.py`: Format into a list of lists: `{index} => { [0]:courseID, [1]: term }`
  * `get_all_tas.py`: Format into a list of lists: `{index} => { [0]:studentID, [1]: taName }`
2. Use these to create the two dropdowns. Save both into the session for input validation.

## AJAX
1. `dropdown_index_ta`: Index of option chosen (cross reference with `["add_ta_to_course_taslist"]`)
2. `dropdown_index_course`: Index of option chosen (cross reference with `["add_ta_to_course_courseslist"]`)

## List of important variables
* `add_ta_to_course_taslist`: Index of studentid,name for every TA that is returned to the user.
* `add_ta_to_course_courseslist`:  Index of courseid,term that is returned to the user.
* `#ta-select`: ID of the dropdown for TAs
* `#course-select`: ID of the dropdown for Courses
* `#assigned-hours`: ID of the assigned hours field









