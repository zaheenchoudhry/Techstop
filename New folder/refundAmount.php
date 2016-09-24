<html>
	<head>
		<title>Website</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="header.css" />
	</head>
	<body>
		<?php
			if (!empty($_POST["returnItems"])) {
				$refundAmount = 0;
				$mysql = new mysqli("localhost","root","","summative");
				for ($i = 0; $i < count($_POST["returnItems"]); $i++) {
					$result = $mysql->query("SELECT price FROM Inventory WHERE productID=".$_POST["returnItems"][$i]);
					$product = $result->fetch_object();
					$refundAmount += $product->price * $_POST["returnItemsQuantity"][$_POST["returnItems"][$i]][0];
				}
				$refundAmountFormatted = number_format($refundAmount, 2);
				echo "<h3 style='color:red;text-align:center;font-size:30px;'>Refund Amount: $".$refundAmountFormatted."</h3>";
				$mysql->close();
			} else {
				echo "<h3 style='color:red;text-align:center;font-size:30px;'>Refund Amount: $0.00</h3>";
			}
		?>
	</body>
</html>