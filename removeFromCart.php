<?php
	if (!empty($_POST['remove'])) {
		$mysql = new mysqli("localhost","root","","summative");
		$mysql->query("DELETE FROM Cart WHERE productID='".$_POST['remove'] ."'");
		$mysql->close();
		header ("Location: cart.php");
	}
?>