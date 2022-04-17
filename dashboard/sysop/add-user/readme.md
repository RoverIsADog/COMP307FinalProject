## Page generation plan for add_user
This page has no contents dynamically generated. Simply print out the required fields.

## AJAX
* Upon clicking submit, make an AJAX call to `add_user.php`, validate data, and send to `add_user.py` for processing.
* Display whatever message `add_user.php` prints in an alert, then refresh the page.

## Important variables
* `#add-user-form`: Name of the form
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