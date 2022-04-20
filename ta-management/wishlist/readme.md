### Page generation plan for withlist
* Use `get_tas.py` to get a list of TAs with which to build the dropdown.
* Save this list for input validation as session `["wishlist_taslist"]`.
* Include `current_withlist.php` to generate current state of the wishlist.

## No ajax call here

## When clicking submit:
* Go to `add_wishlist.php`.
* Get the list from the session and compare with selected TA from form for validation.
* Once validated, call python to insert.
* Finally, redirect back to wishlist.