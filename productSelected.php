<?php
	session_start();
	if (!empty($_POST['products'])) {
		$_SESSION['product'] = $_POST["products"];
		header ("Location: product.php");
	}
?>