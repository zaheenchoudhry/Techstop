<!DOCTYPE html>
<html>
	<head>
		<title>Website</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="header.css" />
		<link rel="stylesheet" type="text/css" href="checkOut.css" />
	</head>
	<body>
		<?php
			require "header.php";
		?>
		
		<main>
			<form action="checkOut.php" method="post" id="info">
				<fieldset>
					<legend>Personal information:</legend>
					<p><label for="FirstName">First Name: </label><input type="text" name="FirstName" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name" required></p>
					<p><label for="MiddleName">Middle Name(s): </label><input type="text" name="MiddleName" placeholder="Optional" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name"></p>
					<p><label for="LastName">Last Name: </label><input type="text" name="LastName" pattern="[A-Za-z '!]{2,40}" title="Enter a Vaild Name" required></p>
					<p><label for="email">E-mail: </label><input type="email" name="email" required></p>
					<p><label for="Phone">Telephone: </label><input type="tel" name="Phone" maxlength="12" pattern="[0-9]{9,12}" title="Enter a Vaild Phone Number (Only Numbers)" required></p>
					<p><label for="bday">Date of Birth: </label><input type="date" name="bday" required></p>
					<br>
					<br>
				</fieldset>
				<fieldset>
					<legend>Shipping Address:</legend>
					<p><label for="Address">Address: </label><input type="text" name="Street" pattern="[0-9]{1,6}[ ]{1}[A-Za-z ']{2,50}[ ]{1}[A-Za-z.]{1,10}" title="Enter a Vaild Address (Ex. 123 Abc Rd.)" required></p>
					<p><label for="City">City: </label><input type="text" name="City" pattern="[A-Za-z ']{2,40}" title="Enter a Vaild City (Ex. Toronto)" required></p>
					<p><label>Province: </label><select name="province" required>
						<option value="" disabled>- - - Select A Province - - -</option>
						<option value="Alberta">Alberta</option>
						<option value="British Columbia">British Columbia</option>
						<option value="Manitoba">Manitoba</option>
						<option value="aNew Brunswick">New Brunswick</option>
						<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
						<option value="Nova Scotia">Nova Scotia</option>
						<option value="Ontario">Ontario</option>
						<option value="Prince Edward Island">Prince Edward Island</option>
						<option value="Quebec">Quebec</option>
						<option value="Saskatchewan">Saskatchewan</option>
					</select></p>
					<p><label for="PostalCode">Postal Code: </label><input type="text" name="PostalCode" maxlength="6" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}[0-9]{1}" title="Enter a Vaild Postal Code (Ex. A1B2C3)" required></p>
					<br>
					<br>
				</fieldset>
				<fieldset>
					<legend>Method of Payment:</legend>
					<input type="radio" id="Visa" name="cardType" required><label for="Visa"><img src="Icons/Visa.png"></label>
					<input type="radio" id="MasterCard" name="cardType" required><label for="MasterCard"><img src="Icons/MasterCard.png"></label>
					<input type="radio" id="AmericanExpress" name="cardType" required><label for="AmericanExpress"><img src="Icons/AmericanExpress.png"></label><br>
					<p><label for="CreditCardNumber">Credit Card Number: </label><input type="text" name="CreditCardNumber" size="16" maxlength="16" pattern="[0-9]{16}" title="Enter a valid 16 digit Credit Card Number" required>
					<label for="SecurityCode">Security Code: </label><input type="text" name="SecurityCode" size="3" maxlength="3" pattern="[0-9]{3}" title="Enter a valid 3 digit Security Code" required>
					</p>
					<p><label for="Expire">Expires: </label><input type="month" name="ExpireMonth" required></p>
					<br>
					<br>
				</fieldset>
				<input type="submit" id="submitInfo" name="checkout" value="Check Out">
			</form>
			<label for="submitInfo">
				<p>Checkout</p>
			</label>
		</main>
		
		<?php
		require "footer.html";
		?>
	</body>
</html>