<!DOCTYPE html>
<html>
	<head>
		<title>Checked Out</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="header.css" />
		<link rel="stylesheet" type="text/css" href="checkOut.css" />
	</head>
	<body>
		<?php
		session_start();
		require "header.php";
		?>
		<main>
			<?php
				if (!empty($_SESSION["receiptNumber"])) {
					$mysql = new mysqli("localhost","root","","summative");
					$result = $mysql->query("SELECT firstName, lastName, address, city, province, postalCode FROM CustomerInfo WHERE orderID=".$_SESSION["receiptNumber"]);
					$info = $result->fetch_object();
					
					echo "<h1>Thank You ".$info->firstName ." ".$info->lastName .", your purchase was successful!</h1><br>";
					echo "<h2>Your receipt number is: ".$_SESSION["receiptNumber"] ."</h2><br>";
					echo "<p id='address'><b>Your order will be shipped to:</b><br>";
					echo $info->address ."<br>";
					echo $info->city .", ".$info->province ."<br>";
					echo $info->postalCode ."<br>";
					echo "Canada</p>";
					$mysql->close();
					$_SESSION["receiptNumber"] = "";
				} else {
					echo "<h1>This page contains sensitive information and therefore can only be viewed once after each checkout.</h1>";
				}
			?>
			<a href='index.php'>
				<p>Return To Home</p>
			</a>
		</main>
		<?php
		require "footer.html";
		?>
	</body>
</html>