The button was left inside of a form that is never used. This is so that we can easily adapt
the code to allow the user entering the path.

Upon clicking the button, a POST request is sent to `import_ta_cohort.php`, which lets `import_ta_cohort.py`
load and process the file.

`import_ta_cohort.php` only returns a string concerning success or failure that will be displayed to the user.
