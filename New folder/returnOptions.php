<?php
	session_start();
	if (empty($_SESSION["receiptNumber"])) {
		header ("Location: returnPage.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TechStop - Return Items</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="return.css" />
		<?php
			require "header.php";
		?>
		<main>
		<form action='refundAmount.php' method='post' onchange="submit()" target="refundAmount">
			<?php
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT firstName, lastName FROM CustomerInfo WHERE orderID=".$_SESSION["receiptNumber"]);
				$info = $result->fetch_object();
				echo "<p>Welcome back ".$info->firstName ." ".$info->lastName .", plese select the products you wish to return.</p>";
				$return = $mysql->query("SELECT * FROM order_".$_SESSION["receiptNumber"]);
				while ($returnItem = $return->fetch_object()) {
					echo "<input type='checkbox' name='returnItems[]' value='".$returnItem->productID ."'>";
					echo "<section>";
					$result = $mysql->query("SELECT * FROM Inventory WHERE productID=".$returnItem->productID);
					$product = $result->fetch_object();
					echo "<img src='ProductImages\\".$product->image ."'>";
					echo "<div>";
					echo "<h1>".$product->productName ."</h1>";
					echo "<h2>Price: $".$product->price ."</h2>";
					echo "<h5>Quantity: ".$returnItem->quantity ."</h5>";
					echo "</div>";
					echo "<div class='quantity'>";
					echo "<p>Quantity To Return:</p>";
					echo "<input type='number' name='returnItemsQuantity[".$returnItem->productID ."][]' min='1' max='".$returnItem->quantity ."' value='1'>";
					echo "</div>";
					echo "</section><br>";
				}
				$mysql->close();
			?>
			<input type="submit" id="returnProducts" name="return" formaction="return.php" formtarget="_top">
			<label for="returnProducts">
				Return Items
			</label>
			</form>
			<iframe src="refundAmount.php" name="refundAmount" scrolling="no"></iframe>
		</main>
		<hr>
		<?php
			require "footer.html";
		?>
	</body>
</html>