<?php
	session_start();
	if (!empty($_POST["ReceiptNumber"])) {
		$mysql = new mysqli("localhost","root","","summative");
		$receiptNumber = $_POST["ReceiptNumber"];
		$verify = $mysql->query("SELECT * FROM CustomerInfo WHERE orderID=".$_POST["ReceiptNumber"]." AND firstName='".$_POST["FirstName"]."' AND lastName='".$_POST["LastName"]."' AND bday='".$_POST["bday"]."'");
		//$check = $result->fetch_object();
		if ($check = $verify->fetch_object()) {
			$_SESSION["receiptNumber"] = $receiptNumber;
			header ("Location: returnOptions.php");
			exit();
		} else {
			header ("Location: returnPage.php");
			exit();
		}
		
		$mysql->query("DELETE FROM Cart");
		$mysql->close();	
	} else if (!empty($_POST["returnItems"])) {
		$refundAmount = 0;
		$mysql = new mysqli("localhost","root","","summative");
		for ($i = 0; $i < count($_POST["returnItems"]); $i++) {
			$result = $mysql->query("SELECT * FROM order_".$_SESSION['receiptNumber'] ." WHERE productID =".$_POST["returnItems"][$i]);
			$returnItem = $result->fetch_object();
			$result = $mysql->query("SELECT stock, price FROM inventory WHERE productID=".$returnItem->productID);
			$product = $result->fetch_object();
			$newStock = $product->stock + $_POST["returnItemsQuantity"][$returnItem->productID][0];
			$refundAmount += $product->price * $_POST["returnItemsQuantity"][$returnItem->productID][0];
			$mysql->query("UPDATE Inventory SET stock=".$newStock ." WHERE productID=".$returnItem->productID);
			if ($_POST["returnItemsQuantity"][$returnItem->productID][0] == $returnItem->quantity) {
				$mysql->query("DELETE FROM order_".$_SESSION['receiptNumber'] ." WHERE productID=".$returnItem->productID);
			} else {
				$newQuantity = $returnItem->quantity - $_POST["returnItemsQuantity"][$returnItem->productID][0];
				$mysql->query("UPDATE order_".$_SESSION['receiptNumber'] ." SET quantity=".$newQuantity ." WHERE productID=".$returnItem->productID);
			}
		}
		$verify = $mysql->query("SELECT * FROM order_".$_SESSION['receiptNumber']);
		if (!$check = $verify->fetch_object()) {
			$mysql->query("DROP TABLE order_".$_SESSION["receiptNumber"]);
			$mysql->query("DELETE FROM CustomerInfo WHERE orderID=".$_SESSION["receiptNumber"]);
		}
		$_SESSION["receiptNumber"] = "";
		$_SESSION["refundAmount"] = $refundAmount;
		$mysql->close();	
		header ("Location: itemsReturned.php");
		exit();
	} else if (isset($_POST["return"])) {
		header ("Location: returnOptions.php");
	} else {
		header ("Location: returnPage.php");
	}
?>