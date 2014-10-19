<?php
	include_once 'dbinfo.php';   // As functions.php is not included
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	error_reporting(0);
?>