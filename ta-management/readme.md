### Generation plan for section ta_management
* The generation of this section differs from the standard section generation in that the menu is different and contains a course selection dropdown.
* The logic is the same as in other sections, but the menu generation code is integrated in the file. 
* Make a call to `get_all_courses.py` for a list of courses this user is taking, and only display menu options once a course option is selected. Save this list to the session for future input validation as `["management_courseslist"]`.
  * Each index of the list consists of:
    * `[course_num]`: Course number, as returned by python
  	* `[term_month_year]`: The term/month/year, as returned by python

### AJAX
* Upon selecting a course/term, AJAX call to `save_course_choice.php`, which will do input validation and save the user's selected course/term in the session memory as `["management_chosen_course"]` and `[management_chosen_term]`.

### Important Variables
* `["management_courseslist"]`: List of every course and terms, saved into storage for input validation.
* `["management_chosen_course]`: Course ID of the course chosen by the user, for simplicity accessing from pages.
* `["management_chosen_term]`: Term/month/year of the term chosen by the user, for simplicity accessing from pages.


