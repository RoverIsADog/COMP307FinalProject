<h1 style="color: red">WARNING</h1>
<p>
New professors will be created in the database if none matching the given name are found.
	Those professors will receive new temporary IDs until the professor claims their account by creating
	an account using the same name and choosing professor. <br>
	This means anyone pretending to be the a currently temporary professor could steal their designated
	spot on the database. <br>
</p>
<p>
	This is an acknowledged weakness as the requirements are that we <b>must</b> create temporary
	entries for professors, yet there are neither any way of verifying a user's real identity during
	account creation nor a pre-existing list of professors/TAs in the database.
</p>
<p>
	Furthermore, we have not been given any information as to the format of <b>term_month_year</b> and as
	such could not check term_month_year inputs against a format that we do not know. As a result, the current website
	accepts any and all inputs for term_month_year . Differently formatted duplicate entries are to be expected.
</p>


<form id="add-prof-course-form">

	<div class="content-box-element labeled-field-container">
		<div class="labeled-field-label">Term/Month/Year</div>
		<input class="labeled-field-field" type="text" name="term-month-year" required>
	</div>

	<div class="content-box-element labeled-field-container">
		<div class="labeled-field-label">Course Number</div>
		<input class="labeled-field-field" type="text" name="course-number" required>
	</div>

	<div class="content-box-element labeled-field-container">
		<div class="labeled-field-label">Course Name</div>
		<input class="labeled-field-field" type="text" name="course-name" required>
	</div>

	<div class="content-box-element labeled-field-container">
		<div class="labeled-field-label">Instructor Assigned</div>
		<input class="labeled-field-field" type="text" name="instructor-assigned" required>
	</div>

	<div class="content-box-element">
		<button class="button positive-button" id="submit" type="submit" value="submit">Submit</button>
	</div>

</form>