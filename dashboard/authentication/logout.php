<?php
require_once(__DIR__ . "/../rootpath.php");

if (!isset($_SESSION)) session_start();

unset($_SESSION['ticket']);
unset($_SESSION['username']);

session_destroy();

header("Location: index.php");
?>