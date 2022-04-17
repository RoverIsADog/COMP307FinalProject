## Page generation plan for edit_user
1. Use `edit_user_utils.php` to call `get_all_users.py` and get a list of all users and their information in CSV form.
2. Use this table to create the user dropdown.
3. Save this list into session `["edit_user_userslist"]` (there are no memory limits for php storage, although this is admittedle inefficient (we could just requery the database with the given ID)).

## AJAX 1
1. Upon choosing a user in the dropdown, AJAX call to `populate_info.php` with the chosen index as `$_GET['dropdown_index']` (for input validation).

## AJAX 2
1. Upon clicking "submit changes", JS makes an AJAX call to `submit_changes.php` with the form's content, then passes on the arguments to the python script.
  * The studentid of the user to be modified can be gotten from `$_SESSION["edit_user_utils.php"]`

## AJAX 3
1. Upon clicking "delete user", JS makes an AJAX call to `delete_user.php` with the value of the user dropdown.
  * The studentid of the user to be modified can be gotten from `$_SESSION["edit_user_utils.php"]`


* Upon clicking submit, make an AJAX call to `add_user.php`, validate data, and send to `add_user.py` for processing.
* Display whatever message `add_user.php` prints in an alert, then refresh the page.

## Important variables
* `#add-user-form`: Name of the form
### Session user list fields (self explanatory)
* `["edit_user_userslist"]`: Session entry for the list. The following are fields
  * `["username"] `
  * `["student_id"]`
  * `["firstname"]`
  * `["lastname"]`
  * `["email"]`
  * `["role"]`
  * `["is_admin"]`
  * `["is_sysop"]`
### Form fields
* `user-studentid`: String
* `user-username`: String
* `user-password`: Password (string)
* `user-firstname`: String
* `user-lastname`: String
* `user-email`: Email field
* `permission-role`: Radio for selecting the desired permissions. It has possible values: `student`, `ta`, `prof`.
* `permission-admin`: Checkbox
* `permission-sysop`: Checkbox