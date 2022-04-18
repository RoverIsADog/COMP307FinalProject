The button was left inside of a form that is never used. This is so that we can easily adapt
the code to allow the user entering the path.

Upon clicking the button, a POST request is sent to `import_prof_course.php`, which lets `import_prof_course.php`
load and process the file.

`import_prof_course.php` only returns a string concerning success or failure that will be displayed to the user.
