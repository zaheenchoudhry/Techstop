<?php
	session_start();
	if (empty($_SESSION["refundAmount"])) {
		header ("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TechStop - Items Returned</title>
		<meta name="viewport" content="width=1024" />
		<link rel="stylesheet" type="text/css" href="checkOut.css" />
		<?php
		require "header.php";
		?>
		<main>
		<h1>The Selected Items Were Successfully Returned</h1>
		<h2>You have been refunded &#36;<?php echo $_SESSION["refundAmount"];?>.</h2>
			<a href='index.php'>
				<p>Return To Home</p>
			</a>
		</main>
		<?php
		$_SESSION["refundAmount"] = null;
		require "footer.html";
		?>
	</body>
</html>