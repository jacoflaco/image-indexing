<?php session_start();
	// unset the session and redirect to the login page
	session_unset();  
	header('location: login.php');
?>