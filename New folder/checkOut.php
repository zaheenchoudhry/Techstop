<?php
	session_start();
	$mysql = new mysqli("localhost","root","","summative");
	$verify = $mysql->query("SELECT * FROM Cart");
	if (!empty($_POST['checkout']) && $check = $verify->fetch_object()) {
		$cart = $mysql->query("SELECT DISTINCT productID FROM Cart");
		while ($cartItem = $cart->fetch_object()) {
			if ($cartItem->productID < 9000) {
				$result = $mysql->query("SELECT stock FROM Inventory WHERE productID='".$cartItem->productID ."'");
				$stock = $result->fetch_object();
				if ($cartItem->quantity > $stock->stock) {
					$_SESSION["checkoutError"] = true;
					$mysql->close();
					header ("Location: checkOutIssues.php");
					exit();
				}
			}
		}
		if (!empty($_POST['FirstName'])) {
			do {
				$receiptNumber = mt_rand(10000000,99999999);
				$mysql = new mysqli("localhost","root","","summative");
				$verify = $mysql->query("SELECT * FROM order_".$receiptNumber);
			} while (!empty($verify));
			$mysql->query("CREATE TABLE order_".$receiptNumber ." (
				productID SMALLINT NOT NULL,
				quantity SMALLINT NOT NULL,
				PRIMARY KEY(productID)
			)");
			$cart = $mysql->query("SELECT * FROM Cart");
			while ($cartItem = $cart->fetch_object()) {
				$result = $mysql->query("SELECT * FROM Inventory WHERE productID=".$cartItem->productID);
				$product = $result->fetch_object();
				$newStock = $product->stock - $cartItem->quantity;
				$mysql->query("INSERT INTO order_".$receiptNumber ."(productID, quantity) VALUES(".$cartItem->productID .", ".$cartItem->quantity .")");
				$mysql->query("UPDATE Inventory SET stock='".$newStock ."' WHERE productID='".$cartItem->productID ."'");
			}
			$mysql->query("DELETE FROM Cart");
			$mysql->query("INSERT INTO CustomerInfo (orderID, firstName, middleName, lastName, email, tel, bday, address, city, province, postalCode, creditCard, secCode, expires) 
			VALUES(".$receiptNumber .", '".$_POST['FirstName'] ."', '".$_POST['MiddleName'] ."', '".$_POST['LastName'] ."', '".$_POST['email'] ."', '".$_POST['Phone'] ."', '".$_POST['bday'] ."', '".$_POST['Street'] ."', '".$_POST['City'] ."', '".$_POST['province'] ."', '".$_POST['PostalCode'] ."', '".$_POST['CreditCardNumber'] ."', '".$_POST['SecurityCode'] ."', '".$_POST['ExpireMonth'] ."-00')");
			$mysql->close();
			$_SESSION["receiptNumber"] = $receiptNumber;
			header ("Location: checkedOut.php");
		} else {
			header ("Location: checkOutPage.php");
		}
	} else {
		$mysql->close();
		header ("Location: cart.php");
	}
?>
