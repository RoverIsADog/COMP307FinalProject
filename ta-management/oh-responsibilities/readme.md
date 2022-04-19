### Page generation plan for oh_responsibilities
* Start by verifying that there is a course/term selected. Print error if not.
* Use `get_instructors.py` to build a list where each index contains `["student_id"]` and `["name"]` of an instructor. Save this into `["oh_responsibilities_instructorlist"]` for later input validation.
* Leave `#editable-elements-container` to be populated upon selection.

### AJAX 1
* Upon selecting an instructor, AJAX call to `populate_fields.php` with `$_GET["dropdown_index"]` as the index value of the chosen instructor.
* Perform input validation.
* Use `get_instructor_info.py` to retrieve all information on the selected instructor, and populate the form fields.

### AJAX 2
* Upon clicking update, AJAX call to `update_instructor_info.php` and use python to update and replace the instructor's current data entirely.