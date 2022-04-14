<?php
    exec($command , $output, $retval);
    if ($retval == -2) {
        echo "<div class=\"header1\">An error occured...<\div>";
    }

?>