<?php
    // Interface for Rate # Rate a TA
    if (sizeof($_GET) != 3) {
        die();
    }
    
    // printf("TA studentid = %s<br>", $_GET["chosenta"]);
    // printf("Username = %s<br>", $_GET["username"]);
    // printf("Ticket = %s<br>", $_GET["ticket"]);

    $output=null;
    $retval=null;
    $command = "python3 ta_to_courses.py "
        . "--student_id " . $GET["chosenta"]
        . "--username" . $GET["username"]
        . "--ticket" . $GET["ticket"];
    echo $command;
    exec($command , $output, $retval);
    if ($retval == -2) {
        echo "<div class=\"header1\">An error occured...<\div>";
    }


    echo "<select id=\"rate-courses-dropdown\" name=\"rate-courses-dropdown\" >";
    echo "<option value=\"\" selected disabled>Please choose an option</option>";
    foreach ($output as $value) {
        $pieces = explode(",", $value);
        echo "<option value=" . $pieces[0] . ">" . $pieces[0] . " [" . $pieces[1] . "]</option>";
    }
    echo "</select>";

?>