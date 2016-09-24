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
			<h1 id="invalid">The inputed information combination does not match any of our records.<br>Please Try Again</h1>
			<form action="return.php" method='post'>
				First Name: <input type="text" name="FirstName" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name" required><br><br>
				Last Name: <input type="text" name="LastName" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name" required><br><br>
				Date of Birth: <input type="date" name="bday" required><br><br>
				Receipt Number: <input type="text" name="ReceiptNumber" maxlength="8" pattern="[0-9]{8}" title="Enter a valid 8 didgit Recipt Number" required><br>
				<input type="submit" name="goToReturns" id="GoToReturns">
			</form>
			<label for="GoToReturns">
				Proceed to Return
			</label>
		</main>
		
		<?php
		require "footer.html";
		?>
	</body>
</html>