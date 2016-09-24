<?php
	session_start();
	if (empty($_SESSION['product'])) {
		header ("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TechStop</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="product.css" />
		<link rel="stylesheet" type="text/css" href="productlist.css" />
		<?php
			require "header.php";
		?>
		<main>
		<div id="productHolder">
		<?php
			$mysql = new mysqli("localhost","root","","summative");
			$result = $mysql->query("SELECT * FROM inventory WHERE productID=".$_SESSION['product']);
			$product = $result->fetch_object();
			$_SESSION['relatedCategory'] = $product->department;
			$_SESSION['relatedBrand'] = $product->brand;
			echo "<h1>".$product->productName ."</h1>";
			echo "<img src='ProductImages/".$product->image ."' alt=''>";
			echo "<div>";
			echo "<h3>Description</h3>";
			echo "<p>".$product->description ."</p>";
			if ($product->originalPrice > 0) {
				echo "<h2>On Sale: <span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></h2>";
			} else {
				echo "<h2>Price: $".$product->price ."</h2>";
			}
			echo "<iframe src='addToCart.php' scrolling='no'></iframe>";
			echo "</div>";
			$_SESSION['inventoryLimit'] = $product->stock;
		?>
			</div>
		<div class="relatedHolder" id="relatedHolderA">
			<h4>Related Products</h4>
			<hr>
			<div class="products">
				<?php	
					$mysql = new mysqli("localhost","root","","summative");
					$result = $mysql->query("SELECT * FROM inventory WHERE department='".$_SESSION['relatedCategory']."' AND productID!=".$_SESSION['product']." ORDER BY RAND() LIMIT 4");
					$i = 0;
					while($product = $result->fetch_object()) {
						echo "<div class='product'>";
						echo "<img src='ProductImages/".$product->image ."' alt=''>";
						if ($product->originalPrice > 0) {
							echo "<p class='price'><span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></p>";
						} else {
							echo "<p class='price'>$".$product->price ."</p>";
						}
						echo "<h3>".$product->productName ."</h3>";
						echo "<form action='productSelected.php' method='post'>";
						echo "<input type='submit' name='products' id='".$product->productID ."' value='".$product->productID ."'>";
						echo "<label for='".$product->productID ."'>View</label>";
						echo "</form>";
						if($product->productID > 9000) {
							echo "<p class='preOrder'>✔ Pre-Order Only</p>";
						} else if ($product->stock > 0) {
							echo "<p class='inStock'>✔ In Stock</p>";
						} else {
							echo "<p class='outOfStock'>✘ Out of Stock</p>";
						}
						echo "</div>";
						if ($i != 3) {
							echo "<hr>";
						}
						$i++;
					}
					$mysql->close();
				?>
			</div>
		</div>
		<hr>
		<?php	
			$mysql = new mysqli("localhost","root","","summative");
			$result = $mysql->query("SELECT * FROM inventory WHERE brand='".$_SESSION['relatedBrand']."' AND productID!='".$_SESSION['product']."' ORDER BY RAND() LIMIT 4");
			$i = 0;
			echo "<div class='relatedHolder' id='relatedHolderB'>";
			echo "<h4>Other Products by ".$_SESSION['relatedBrand']."</h4>";
			echo "<hr>";
			echo "<div class='products'>";
			while($product = $result->fetch_object()) {
				echo "<div class='product'>";
				echo "<img src='ProductImages/".$product->image ."' alt=''>";
				if ($product->originalPrice > 0) {
					echo "<p class='price'><span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></p>";
				} else {
					echo "<p class='price'>$".$product->price ."</p>";
				}
				echo "<h3>".$product->productName ."</h3>";
				echo "<form action='productSelected.php' method='post'>";
				echo "<input type='submit' name='products' id='".$product->productID ."' value='".$product->productID ."'>";
				echo "<label for='".$product->productID ."'>View</label>";
				echo "</form>";
				if($product->productID > 9000) {
					echo "<p class='preOrder'>✔ Pre-Order Only</p>";
				} else if ($product->stock > 0) {
					echo "<p class='inStock'>✔ In Stock</p>";
				} else {
					echo "<p class='outOfStock'>✘ Out of Stock</p>";
				}
				echo "</div>";
				if ($i != 3) {
					echo "<hr>";
				}
				$i++;
			}
			echo "</div>";
			echo "</div>";
			$mysql->close();
		?>
		</main>
		<?php
			require "footer.html";
		?>
	</body>
</html>