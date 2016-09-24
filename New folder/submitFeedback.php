<html>
	<head>
		<title>TechStop</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="header.css" />
		<link rel="stylesheet" type="text/css" href="addToCart.css" />
	</head>
	<body>
		<?php
			if (isset($_POST["sendFeedback"])) {
				mail("adrianensan@gmail.com","Feedback","hello");
				echo "<p style='font-size:25px;color:green;'><b>Thank You for your Feedback!</b></p>";
			}
		?>
		
	</body>
</html>