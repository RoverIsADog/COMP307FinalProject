<?php
session_start();

unset($_SESSION['ticket']);
unset($_SESSION['username']);

header("Location:index.php");
?>