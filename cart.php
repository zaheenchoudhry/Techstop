<!DOCTYPE html>
<html>
	<head>
		<title>TechStop - Cart</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="cart.css" />
		<?php
			require "header.php";
		?>
		<main>
		<div id="title">
			<h2>Cart</h2>
			<img src="Icons/darkCart.png" alt="">
		</div>
			<?php
			$mysql = new mysqli("localhost","root","","summative");
			$verify = $mysql->query("SELECT * FROM Cart");
			if (!$check = $verify->fetch_object()) {
				echo "<h3>Cart Is Empty</h3>";
			} else {
				$totalCost = 0;
				$cart = $mysql->query("SELECT * FROM Cart");
				while ($cartItem = $cart->fetch_object()) {
					echo "<section>";
					$result = $mysql->query("SELECT * FROM Inventory WHERE productID=".$cartItem->productID);
					$product = $result->fetch_object();
					echo "<img src='ProductImages/".$product->image ."'>";
					echo "<div>";
					echo "<h1>".$product->productName ."</h1>";
					if ($product->originalPrice > 0) {
						echo "<h2>On Sale: <span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></h2>";
					} else {
						echo "<h2>Price: $".$product->price ."</h2>";
					}
					$totalCost += $product->price * $cartItem->quantity;
					echo "<h5>Quantity: ".$cartItem->quantity ."</h5>";
					echo "</div>";
					echo "<div>";
					echo "<form action='removeFromCart.php' method='post' target='_top'>";
					echo "<input type='submit' name='remove' id='".$cartItem->productID ."' value='".$cartItem->productID ."'>";
					echo "<label for='".$cartItem->productID ."'>";
					echo "<img src='Icons/removeFromCart.png'>";
					echo "<h4>Remove From Cart</h4>";
					echo "</label>";
					echo "</form>";
					echo "</div>";
					echo "</section>";
				}
				echo "<form action='checkOut.php' method='post'>";
				echo "<input type='submit' name='checkout' id='checkOut'>";
				echo "<label id='checkout' for='checkOut'>";
				echo "Proceed To Checkout";
				echo "</label>";
				echo "</form>";
				$totalCostFormatted = number_format($totalCost, 2);
				echo "<h3>Total Cost: $".$totalCostFormatted ."</h3>";
			}
			$mysql->close();
			?>
			
		</main>
		<hr>
		<?php
		require "footer.html";
		?>
	</body>
</html>