## Generation plan for ta_info_history
1. Use `get_all_tas.php` to get a list (each TA) of list (studentID,term_month_year).
2. Save this lsit in session `["ta_info_history_taslist"]`.
3. Use this list to build the page.

## AJAX Execution Plan
1. Upon choosing a TA option, async call to `populate_content.php`. Arguments are `dropdown_index`, where n is the index inside `["ta_info_history_taslist"]` (input validation).
2. Using this information, `populate_content` calls to the appropriate python files and creates the required tables.

## List of important variables
### `PHP $_SESSION`
* `ta_info_history_taslist`: Stores a list of list: `index -> ( [0]:taID, [1]:taName )`
  * Represents all choosable TAs.
