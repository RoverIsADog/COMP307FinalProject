<!DOCTYPE html>

<head>
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="template.css">
  <link rel="stylesheet" type="text/css" href="header.css">
  <link rel="stylesheet" type="text/css" href="sidebar.css">
  <link rel="stylesheet" type="text/css" href="content.css">
	<script type="text/javascript" src="template.js"></script>
</head>

<?php

$loggedin=false;
if (!$loggedin) {
    echo invalid;
    exit;
}

$hasPermission=false;
if (!$hasPermission) {
    echo invalid;
    exit;
}

// Print the rest of the page...


?>
