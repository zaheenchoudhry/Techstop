<?php
	session_start();
	if (!empty($_POST['option'])) {
		$_SESSION['menuOption'] = $_POST["option"];
	}
	header ("Location: browse.php");
?>