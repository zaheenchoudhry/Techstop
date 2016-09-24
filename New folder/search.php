<!DOCTYPE html>
<html>
	<head>
		<title>TechStop - Search</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="search.css"/>
		<?php
			require "header.php";
		?>
		<main>
			<?php
			if (!empty($_POST['search'])) {
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT * FROM inventory WHERE productName LIKE '%".$_POST['search'] ."%' OR department LIKE '%".$_POST['search'] ."%' OR brand LIKE '%".$_POST['search'] ."%' LIMIT 1");
				if ($verify = $result->fetch_object()) {
					$result = $mysql->query("SELECT * FROM inventory WHERE productName LIKE '%".$_POST['search'] ."%' OR department LIKE '%".$_POST['search'] ."%' OR brand LIKE '%".$_POST['search'] ."%' ORDER BY productName");
					echo "<h1>Showing results for search term '".$_POST['search'] ."'</h1>";
					while($product = $result->fetch_object()){
						echo "<div>";
						echo "<img src='ProductImages\\".$product->image ."'>";
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
					}
				} else {
					echo "<h1>No results for search term '".$_POST['search'] ."'</h1>";
				}
				$mysql->close();
			} else {
				echo "<h1>To search, please use the search box above</h1>";
			}
			?>
			<a href='browse.php'>
				<p id='checkout'>Browse More Products</p>
			</a>
		</main>
		<?php
			require "footer.html";
		?>
	</body>
</html>