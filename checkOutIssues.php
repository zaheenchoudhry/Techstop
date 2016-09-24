<?php
	session_start();
	if (empty($_SESSION["checkoutError"]) || !$_SESSION["checkoutError"]) {
		header ("Location: cart.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TechStop - Check Out Issues</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="cart.css" />
		<?php
			require "header.php";
		?>
		<main>
			<h3>Due to stock limitations, the following changes were made to your purchase.</h3>
			<?php
			$mysql = new mysqli("localhost","root","","summative");
			$cart = $mysql->query("SELECT * FROM Cart");
			$_SESSION["checkoutError"] = false;
			$totalCost = 0;
			while ($cartItem = $cart->fetch_object()) {
				echo "<section>";
				$result = $mysql->query("SELECT * FROM Inventory WHERE productID=".$cartItem->productID);
				$product = $result->fetch_object();
				echo "<img src='ProductImages/".$product->image ."'>";
				echo "<div>";
				echo "<h1>".$product->productName ."</h1>";
				$totalCost += $product->price * $cartItem->quantity;
				if ($product->originalPrice > 0) {
					echo "<h2>On Sale: <span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></h2>";
				} else {
					echo "<h2>Price: $".$product->price ."</h2>";
				}
				echo "<h5>Quantity: ";
				$totalQuantity = 0;
				$result = $mysql->query("SELECT quantity FROM Cart WHERE productID=".$cartItem->productID);
				while ($quantities = $result->fetch_object()) {
					$totalQuantity += $quantities->quantity;
				}
				if ($totalQuantity > $product->stock) {
					echo "<span class='oldQuantity'><del>&nbsp;".$cartItem->quantity ."&nbsp;</del>&nbsp;</span>";
					if ($totalQuantity - $product->stock >= $cartItem->quantity) {
						$mysql->query("DELETE FROM Cart WHERE cartItem=".$cartItem->cartItem);
						echo "0";
					} else {
						$newQuantity = $cartItem->quantity - ($totalQuantity - $product->stock);
						$mysql->query("UPDATE Cart SET quantity=".$newQuantity ." WHERE productID=".$cartItem->productID);
						echo $newQuantity;
					}
				} else {
					echo $cartItem->quantity;
				}
				echo "</h5>";
				echo "</div>";
				echo "</section>";
			}
			$mysql->close();
			echo "<form action='checkOut.php' method='post' id='info'>";
			echo "<input type='submit' id='submitInfo' name='submit' value='Check Out'>";
			echo "</form>";
			echo "<label for='submitInfo'>";
			echo "<p>Confirm</p>";
			echo "</label>";
			$totalCostFormatted = number_format($totalCost, 2);
			echo "<h3>Updated Total Cost: $".$totalCostFormatted."</h3>";
			?>
		</main>
		<?php
			require "footer.html";
		?>
	</body>
</html>