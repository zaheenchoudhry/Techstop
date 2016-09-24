<html>
	<head>
		<title>TechStop</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="header.css" />
		<link rel="stylesheet" type="text/css" href="addToCart.css" />
	</head>
	<body>
		<?php
			session_start();
			if (!empty($_POST["quantity"])) {
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT * FROM Cart WHERE productID=".$_SESSION['product']);
				$verify = $result->fetch_object();
				if(!empty($verify)) {
					$mysql->query("UPDATE Cart SET quantity=".($verify->quantity + $_POST['quantity'])." WHERE productID=".$_SESSION['product']);
				} else {
					$mysql->query("INSERT INTO Cart(productID, quantity) VALUES(".$_SESSION['product'] .", ".$_POST['quantity'] .")");
				}
				$mysql->close();
				echo "<div id='added'>";
				echo "<p>✔ Added To Cart</p>";
				echo "</div>";
			} else if ($_SESSION['inventoryLimit'] == 0) {
				echo "<div id='outOfStock'>";
				echo "<p>✘ Out of Stock</p>";
				echo "</div>";
			} else {
				if ($_SESSION['product'] < 9000) {
					$max = "max='".$_SESSION['inventoryLimit'] ."'";
				} else {
					$max = "";
				}
				echo "<form action='addToCart.php' method='post'>";
				echo "<h3>Quantity: </h3><input type='number' name='quantity' min='1' ".$max." value='1'>";
				echo "<input type='submit' id='submit'>";
				if ($_SESSION['product'] > 9000) {
					echo "<label for='submit'><div id='preOrder'>";
					echo "<p>Pre-Order <img src='Icons\addToCart.png'></p>";
				} else {
					echo "<label for='submit'><div id='add'>";
					echo "<p>Add To Cart <img src='Icons\addToCart.png'></p>";
				}
				echo "</div></label>";
				if ($_SESSION['product'] < 9000) {
					$mysql = new mysqli("localhost","root","","summative");
					$result = $mysql->query("SELECT stock FROM Inventory WHERE productID=".$_SESSION['product']);
					$stock = $result->fetch_object();
					echo "<br><br><p style='margin-left:150px;'>".$stock->stock ." units available</p>";
					$mysql->close();
				}
				echo "</form>";
			}
			?>
	</body>
</html>