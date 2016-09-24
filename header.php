	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="header.css" />
	<link rel="shortcut icon" href="DisplayImages/logo2.ico">
</head>
<body>
<header>
	<form action='selected.php' id="menuOption" method='post'></form>
	<input type="radio" id="close" name="viewAll">
	<input type="radio" id="openDepartments" name="viewAll">
	<div id="departmentsAll">
		<p class="closeCategoriesAll"><label for="close"><b>✕</b></label></p>
		<h2>Departments</h2>
		<div class="content">
			<?php	
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT DISTINCT department 
					FROM inventory 
					ORDER BY department");
				while($department = $result->fetch_object()){
					echo "<label><input type='submit' form='menuOption' name='option' value='department=\"".$department->department ."\"'/>";
					echo "<div class='options'>";
					echo "<img src='DepartmentIcons/".$department->department .".png' alt=''>";
					echo "<p>".$department->department ."</p>";
					echo "</div>";
					echo "</label>";
				}
				$mysql->close();
			?>
		</div>
		<p class="openSideMenu">☰</p>
		<div class="categoriesAllNav">
			<h3>Categories</h3>
			<label for="openDepartments">Departments</label><br>
			<label for="openBrands">Brands</label>
		</div>
	</div>
	<input type="radio" id="openBrands" name="viewAll">
	<div id="brandsAll">
		<p class="closeCategoriesAll"><label for="close"><b>✕</b></label></p>
		<h2>Brands</h2>
		<div class="content">
			<?php	
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT DISTINCT brand 
					FROM inventory
					ORDER BY brand");
				while($brand = $result->fetch_object()){
					echo "<label><input type='submit' form='menuOption' name='option' value='brand=\"".$brand->brand ."\"'>";
					echo "<div class='options'>";
					echo "<img src='BrandLogos/".$brand->brand .".png' alt='".$brand->brand ."'>";
					echo "</div>";
					echo "</label>";
				}
				$mysql->close();
			?>
		</div>
		<p class="openSideMenu">☰</p>
		<div class="categoriesAllNav">
			<h3>Categories</h3>
			<label for="openDepartments">Departments</label><br>
			<label for="openBrands">Brands</label>
		</div>
	</div>
	<input type="radio" id="openTerms" name="viewAll">
	<div id="terms">
		<p class="closeCategoriesAll"><label for="close"><b>✕</b></label></p>
		<h1>Terms & Conditions</h1>
		<div class="content">
			<h2>Personal Information:</h2>
			<p>By using this website, we have the right to sell all of your personal information to people who will spam your email and wake you up in the middle of the night 
			trying to sell you windows and doors. Also using your credit card on this site may lead to several fraudulent charges, none of which we will take responsibility for.</p>
			<br>
			<h2>Purchases:</h2>
			<p>Purchases made on this site may or may not be fake. Either way, you will be charged without the option of a refund or exchange. 
			Should your purchased items not get delivered, please do not contact us as we have no interest in helping you.</p>
			<br>
			<h2>Security:</h2>
			<p>All personal information entered on this website (including sensitive data such as credit card numbers) is saved as plain text and is never encrypted.</p>
			<br>
			<h2>Thank you for visiting our site!</h2>
		</div>
	</div>
	<input type="radio" id="openReturn" name="viewAll">
	<div id="return">
		<p class="closeCategoriesAll"><label for="close"><b>✕</b></label></p>
		<h1>Return</h1>
		<div class="content">
			<h3>To return any items purchased from this website, please enter your name, date of birth and your 8 digit receipt number below.</h3>
			<h3>You will have the option to select the specific items you wish to return on the next page.</h3>
			<br>
			<form action="return.php" method='post'>
				First Name: <input type="text" name="FirstName" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name" required><br><br>
				Last Name: <input type="text" name="LastName" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name" required><br><br>
				Date of Birth: <input type="date" name="bday" required><br><br>
				Receipt Number: <input type="text" name="ReceiptNumber" maxlength="8" pattern="[0-9]{8}" title="Enter a valid 8 digit Receipt Number" required>
				<input type="submit" name="goToReturns" id="goToReturns">
				<label for="goToReturns">
					Proceed to Return
				</label>
			</form>
		</div>
	</div>
	<input type="radio" id="openFeedback" name="viewAll">
	<div id="feedback">
		<p class="closeCategoriesAll"><label for="close"><b>✕</b></label></p>
		<h1>Feedback</h1>
		<div class="content">
			<iframe name="feedbackSubmitted" scrolling="no"></iframe>
			<form action="submitFeedback.php" method='post' target="feedbackSubmitted">
				Name: <input type="text" name="Name" placeholder="Optional"><br><br>
				Contact email: <input type="email" name="email" placeholder="Optional"><br><br>
				Your Feedback: <br>
				<textarea rows="5" cols="50" name="feedback" required></textarea><br><br>
				<input type="submit" name="sendFeedback" id="sendFeedback">
				<label for="sendFeedback">
					Send Feedback
				</label>
			</form>
		</div>
	</div>
	<a href="cart.php">
		<div id="cart">
			<img src="Icons/cart.png" alt="Cart" height="45">
		</div>
	</a>
	<div id="searchBar">
		<form action="search.php" method="post">
			<div id="searchBarA">
				<input type="image" src="Icons/search.png" alt="Search" name="submitSearch">
			</div>
			<div id="searchBarB">
				<input type="search" name="search" placeholder="Search" required>
			</div>
		</form>
	</div>	
	<a href="index.php"><h1>TechStop</h1></a>
	<nav>
		<p>☰ Menu</p>
	</nav>
	<div id="dropDownMenu">
		<div id="departmentsTab">
			<h3>Departments</h3>
		</div>
		<div id="brandsTab">
			<h3>Brands</h3>
		</div>
		<div id="departments">
			<?php	
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT department, COUNT(*) cnt FROM inventory GROUP BY department ORDER BY COUNT(*) DESC LIMIT 9");
				while($department = $result->fetch_object()) {
					echo "<label><input type='submit' form='menuOption' name='option' value='department=\"".$department->department ."\"'>";
					echo "<div class='options'>";
					echo "<img src='DepartmentIcons/".$department->department .".png' alt=''>";
					echo "<p>".$department->department ."</p>";
					echo "</div>";
					echo "</label>";
				}
				$mysql->close();
			?>
			<label for="openDepartments">
				<div class="options">
					<p class="menuText">View All Departments</p>
				</div>
			</label>
		</div>
		<div id="brands">
			<?php	
				$mysql = new mysqli("localhost","root","","summative");
				$result = $mysql->query("SELECT brand, COUNT(*) cnt FROM inventory GROUP BY brand ORDER BY COUNT(*) DESC LIMIT 9");
				while($brand = $result->fetch_object()){
					echo "<label><input type='submit' form='menuOption' name='option' value='brand=\"".$brand->brand ."\"'>";
					echo "<div class='options'>";
					echo "<img src='BrandLogos/".$brand->brand .".png' alt='".$brand->brand ."'>";
					echo "</div>";
					echo "</label>";
				}
				$mysql->close();
			?>
			<label for="openBrands">
				<div class='viewAllOptions'>
					<img src="BrandLogos/AllBrands.png" alt="">
					<p class="menuText">View All Brands</p>
				</div>
			</label>
		</div>
	</div>
</header>