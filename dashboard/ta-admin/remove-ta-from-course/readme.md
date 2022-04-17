## Generation plan for remove_ta_from_course
1. Use `remove_ta_utils.php` to call python and get all TAs in the database. Use this to build the webpage. Save this list into the session `["remove_ta_from_course_taslist"]` for input validation
2. The box `#course-dropdown-container` is left empty for later population
by an AJAX call.

## AJAX 1
1. Upon selecting a TA, send the list index of the selected TA to `build_course_dropdown` using GET["dropdown_index"].
2. Get all courses/term for that TA and build the dropdown: `#course-dropdown-container`.

## AJAX 2
1. Upon clicking submit, send form data to `confirm_remove.php` and validate inputs.
2. Display whatever message it sends as alert, then refresh the page to clear inputs. 

## Important variables
* `["remove_ta_from_course_taslist"]`: Storing the TA choices available to the user.
* `["remove_ta_from_course_courseslist"]`: Storing the course choices available to the user.
* `#course-dropdown-container`: Container for the dropdown. To be built.




