<!DOCTYPE html>

<html>
	<head>
		<title>TechStop - Browse</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="browse.css" />
		<script>
		function autoResize(iframe){
			document.getElementById(iframe).height = "900px";
			document.getElementById(iframe).height = (document.getElementById(iframe).contentWindow.document.body.scrollHeight) + "px";
		}
		</script>
		<?php
			session_start();
			require "header.php";
		?>
		
		<aside>
			<form action='productlist.php' method='post' target="products">
			<?php
				echo "<div id='sort'>";
				echo "<p>Sort:</p>";
				echo "<select name='order' onChange='this.form.submit()'>";
				echo "<option value='productName'>A - Z</option>";
				echo "<option value='productName DESC'>Z - A</option>";
				echo "<option value='price'>Low - High</option>";
				echo "<option value='price DESC'>High - Low</option>";
				echo "</select>";
				echo "</div>";
				echo "<h2>Departments</h2>";
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT DISTINCT department FROM inventory ORDER BY department");
				while($row = $result->fetch_object()){
					echo "<label>";
					echo "<input type='checkbox' name='departmentFilters[]' value='department=\"".$row->department ."\"' onClick='this.form.submit()'";
					if (!empty($_SESSION['menuOption']) && ("department=\"". $row->department ."\"") == $_SESSION['menuOption']) {
						echo " checked";
					}
					echo "/> ".$row->department;
					echo "</label><br>";
				}
				echo "<h2>Brands</h2>";
				$result = $mysql->query("SELECT DISTINCT brand FROM inventory ORDER BY brand");
				while($row = $result->fetch_object()){
					echo "<label>";
					echo "<input type='checkbox' name='brandFilters[]' value='brand=\"".$row->brand ."\"' onClick='this.form.submit()'";
					if (!empty($_SESSION['menuOption']) && ("brand=\"". $row->brand ."\"") == $_SESSION['menuOption']) {
						echo " checked";
					}
					echo "/> ".$row->brand;
					echo "</label><br>";
				}
				$mysql->close();
			?>
			</form>
		</aside>
		<main>
			<iframe src="productlist.php" scrolling="no" name="products" id="products" onLoad="autoResize('products');"></iframe>
		</main>
	</body>
</html>