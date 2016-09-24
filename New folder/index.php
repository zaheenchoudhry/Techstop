<!DOCTYPE html>
<html>
	<head>
		<title>TechStop</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="homepage.css" />
		<link rel="stylesheet" type="text/css" href="productlist.css" />
		<?php
		require "header.php";
		?>
		<div id="headBanner">
			<div id="bgBack">
				<div id="bgCover">
					<div id="banContHolder">
						<div id="headItemCont">
							<div id="logoHolder">
								<p id="logTop">The</p>
								<hr>
								<p id="logBottom">TechStop</p>
							</div>
							<div id="slogan">
								<hr class="vHr">
								<hr class="hHr">
								<hr class="vHr">
								<p>For all your technological needs</p>
								<hr class="vHr">
								<hr class="hHr">
								<hr class="vHr">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="categoryLinksSection">
			<div id="circleButCont">
				<div id="circleBut">
					<div><p>TS</p></div>
				</div>
			</div>
			<div id="categoryLinks">
				<div class='category'>
					<a href='#featuredItems'>
						<div class="circle" id="circleA"><div><p>Featured Products</p></div></div>
					</a>
				</div>
				<div class='category'>
					<a href='#saleItems'>
						<div class="circle" id="circleB" style="background: rgba(0, 0, 0, 0.3) url('Icons/SaleTag.png') no-repeat center;"><div><p>Products On Sale</p></div></div>
					</a>
				</div>
				<div class='category'>
					<a href='#futureItems'>
						<div class="circle" id="circleC"><div><p>Future Products</p></div></div>
					</a>
				</div>
			</div>
		</div>
		<hr>
		<div id="sliderDiv">
			<div id="logoCont">
				<img class="AppleLogoImg" src="BrandLogos/Apple.png" alt="Apple Logo" height="100" width="100">
			</div>
			<div id="sliderContainer">
				<div id="iPhone5SSlider">
					<img src="DisplayImages/iphone5s.png" alt="iPhone5S" height="350">
					<form action="productSelected.php" method="post">
						<input type="submit" name="products" id="iPhone5S" value="1002">
						<label for="iPhone5S">View</label>
					</form>
					<p>A chip with 64-bit architecture. A fingerprint identity sensor. A better, faster camera. And an operating system built 
					specifically for 64-bit. Any one of these features in a smartphone would make it ahead of its time.</p>
				</div>
				<div id="slider">
					<div id="iPhone5CSlider">
						<img src="DisplayImages/iphone5c.png" alt="iPhone5C" height="350">
						<form action="productSelected.php" method="post">
							<input type="submit" name="products" id="iPhone5C" value="1043">
							<label for="iPhone5C">View</label>
						</form>
						<p>Colour is more than just a hue. It expresses a feeling. Makes a statement. Declares an allegiance. Colour reveals your personality. 
						iPhone 5c, in five anything-but-shy colours, does just that. It’s not just for lovers of colour. It’s for the colourful.</p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div id="featuredItems">
			<h4 class="styleH4">Featured Items</h4>
			<hr>
			<div class="products">
				<?php	
					$mysql = new mysqli("localhost","root","","summative");
					$result = $mysql->query("SELECT * FROM inventory ORDER BY stock DESC LIMIT 8");
					$i = 0;
					while($product = $result->fetch_object()) {
						echo "<div class='product'>";
						echo "<img src='ProductImages/".$product->image ."' alt=''>";
						if ($product->originalPrice > 0) {
						echo "<h1><span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></p>";
						} else {
							echo "<p class='price'>$".$product->price ."</p>";
						}
						echo "<h3>".$product->productName ."</h3>";
						echo "<form action='productSelected.php' method='post'>";
						echo "<input type='submit' name='products' id='".$product->productID ."' value='".$product->productID ."'>";
						echo "<label for='".$product->productID ."'>View</label>";
						echo "</form>";
						echo "</div>";
						if ($i != 3 && $i != 7) {
							echo "<hr>";
						}
						$i++;
					}
					$mysql->close();
				?>
			</div>
		</div>
		<hr>
		<div id="appleDiv">
			<div id="appleDivContentHolder">
				<img class="AppleLogoImg" src="BrandLogos/Apple.png" alt="Apple Logo" height="100" width="100">
				<img id="MacBookDisplayImg" src="DisplayImages/MacBookGray.png" alt="MacBook Air" height="330" width="600">
				<div id="appleDivP">
					<h3><b>MacBook Pro</b></h3>
					<br>
					<p>MacBook Pro with Retina display changes the entire notebook experience. What you see onscreen is unbelievably sharp. And now it’s even faster with the latest-generation Intel processors and high-performance graphics. So if you can imagine it, you can create it.</p>
					<br>
					<br>
					<form action="productSelected.php" method="post">
						<input type="submit" name="products" id="MacBookPro" value="1054">
						<label class="viewButton" for="MacBookPro">View</label>
					</form>
				</div>
			</div>
		</div>
		<hr>
		<div id="saleItems">
			<h4 class="styleH4">Items on Sale!</h4>
			<hr>
			<div class="products">
				<?php	
					$mysql = new mysqli("localhost","root","","summative");
					$result = $mysql->query("SELECT * FROM inventory WHERE originalPrice > 0 ORDER BY stock DESC LIMIT 8");
					$i = 0;
					while($product = $result->fetch_object()) {
						echo "<div class='product'>";
						echo "<img src='ProductImages/".$product->image ."' alt=''>";
						echo "<p class='price'><span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></p>";
						echo "<h3>".$product->productName ."</h3>";
						echo "<form action='productSelected.php' method='post'>";
						echo "<input type='submit' name='products' id='".$product->productID ."' value='".$product->productID ."'>";
						echo "<label for='".$product->productID ."'>View</label>";
						echo "</form>";
						echo "</div>";
						if ($i != 3 && $i != 7) {
							echo "<hr>";
						}
						$i++;
					}
					$mysql->close();
				?>
			</div>
		</div>
		<hr>
		<div id="appleDiv2">
			<div id="appleDivContentHolder2">
				<img class="AppleLogoImg" src="BrandLogos/Apple.png" alt="Apple Logo" height="100" width="100">
				<img id="iPadAirDisplayImg" src="DisplayImages/ipadAir.png" alt="iPad Air" height="600" width="600">
				<div id="appleDivP2">
					<h3><b>iPad Air</b></h3>
					<br>
					<p>The new iPad Air is unbelievably thin and light. And yet it’s so much more powerful and capable. With the A7 chip, advanced wireless, and great apps for productivity and creativity, iPad Air lets you do more than you ever imagined. In more places than you ever imagined.</p>
					<br>
					<br>
					<form action="productSelected.php" method="post">
						<input type="submit" name="products" id="iPadAir" value="1000">
						<label class="viewButton" for="iPadAir">View</label>
					</form>
				</div>
			</div>
		</div>
		<hr>
		<div id="futureItems">
			<h4 class="styleH4">Future Products</h4>
			<hr>
			<div class="products">
				<?php	
					$mysql = new mysqli("localhost","root","","summative");
					$result = $mysql->query("SELECT * FROM inventory WHERE productID > 9000 ORDER BY RAND() LIMIT 8");
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
						echo "</div>";
						if ($i != 3 && $i != 7) {
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
		require "footer.html";
		?>
	</body>
</html>