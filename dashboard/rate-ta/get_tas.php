<?php
/*
This file gets every TA associated with the user, and the course and
term they chose.
*/

// Interface for Rate # Rate a TA
if (sizeof($_GET) != 4) {
    die();
}

//printf("Username = %s<br>", $_GET["username"]);
//printf("Ticket = %s<br>", $_GET["ticket"]);
//printf("Course# = %s<br>", $_GET["chosenCourse"]);
//printf("TermMonthYear = %s<br>", $_GET["chosenTerm"]);

$output=null;
$retval=null;

// PROCESS TO GET COURSE NUM AND STUFF
$command = "python3 ta_to_courses.py "
    . "--username" . $GET["username"]
    . "--ticket" . $GET["ticket"]
    . "--course_num" . $GET["chosenCourse"]
    . "--term_month_year" . $GET["chosenTerm"];
//echo $command;
exec($command , $output, $retval);

echo $output[0];


if ($retval == -2) {
    echo "<div class=\"header1\">An error occured...<\div>";
}


echo "<select id=\"rate-courses-dropdown\" name=\"rate-courses-dropdown\" >";
echo "<option value=\"\" selected disabled>Please choose an option</option>";
//foreach ($output as $value) {
//    $pieces = explode(",", $value);
//    echo "<option value=" . $pieces[0] . ">" . $pieces[0] . " [" . $pieces[1] . "]</option>";
//}

echo '<option value="123123,TA Name 1"> TA Name 1 </option>';
echo '<option value="123123,TA Name 2"> TA Name 2 </option>';
echo '<option value="123123,TA Name 3"> TA Name 3 </option>';
echo '<option value="123123,TA Name 4"> TA Name 4 </option>';
echo '<option value="123123,TA Name 5"> TA Name 5 </option>';

echo "</select>";

?>