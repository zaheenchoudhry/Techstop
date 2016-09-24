<html>
	<head>
		<title>Website</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="header.css" />
		<link rel="stylesheet" type="text/css" href="productlist.css" />
	</head>
	<body>
		<?php
			session_start();
			if ((!empty($_SESSION['menuOption']) && $_SESSION['menuOption'] != "") || !empty($_POST["departmentFilters"]) || !empty($_POST["brandFilters"])) {
				$brandConditions = "";
				$departmentConditions = "";
				if (!empty($_POST["departmentFilters"])) {
					$departmentConditions = "(";
					for($i = 0; $i < count($_POST["departmentFilters"]); $i++) {
						$departmentConditions .= $_POST["departmentFilters"][$i];
						if($i + 1 < count($_POST["departmentFilters"])) {
							$departmentConditions .= " OR ";
						} else {
							$departmentConditions .= ")";
						}
					}
				}
				if (!empty($_POST["brandFilters"])) {
					if (!empty($_POST["departmentFilters"])) {
						$brandConditions = " AND (";
					} else {
						$brandConditions = "(";
					}
					for($i = 0; $i < count($_POST["brandFilters"]); $i++) {
						$brandConditions .= $_POST["brandFilters"][$i];
						if($i + 1 < count($_POST["brandFilters"])) {
							$brandConditions .= " OR ";
						} else {
							$brandConditions .= ")";
						}
					}
				}
				if ($_SESSION['menuOption'] != "") {
					$departmentConditions .= $_SESSION['menuOption'];
					$_SESSION['menuOption'] = "";
				}
				if(isset($_POST['order'])){
					$orderCondition = $_POST['order'];
				} else {
					$orderCondition = "productName";
				}
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT * FROM inventory WHERE ".$departmentConditions.$brandConditions."ORDER BY ".$orderCondition);
				while($product = $result->fetch_object()){
					echo "<div class='product'>";
					echo "<img class='productImage' src='ProductImages\\".$product->image ."'>";
					if ($product->originalPrice > 0) {
						echo "<p class='price'><span class='oldPrice'><del>$".$product->originalPrice ."</del></span><span class='sale'> $".$product->price ."</span></h1>";
					} else {
						echo "<p class='price'>$".$product->price ."</p>";
					}
					echo "<h3 class='productName'>".$product->productName ."</h3>";
					echo "<form action='productSelected.php' method='post' target='_top'>";
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
				$mysql->close();
			}
		?>
	</body>
</html>