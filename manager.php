<?php
	$mysql = new mysqli("localhost","root","");
	$mysql->query("CREATE DATABASE summative");
	$mysql = new mysqli("localhost","root","","summative");
	$mysql->query("CREATE TABLE Inventory (
		productID SMALLINT NOT NULL,
		productName CHAR(100) NOT NULL,
		department CHAR(25) NOT NULL,
		brand CHAR(25) NOT NULL,
		description VARCHAR(800) NOT NULL DEFAULT 'No Description',
		price DECIMAL(7,2) NOT NULL,
		image CHAR(50) NOT NULL DEFAULT 'noimage.png',
		stock SMALLINT NOT NULL DEFAULT -1,
		originalPrice DECIMAL(7,2) NOT NULL DEFAULT -1,
		PRIMARY KEY(productID)
	)");
	$mysql->query("CREATE TABLE Cart (
		productID SMALLINT NOT NULL,
		quantity SMALLINT NOT NULL,
		PRIMARY KEY(productID)
	)");
	$file = fopen("inventory.txt", "r");
	while (!feof($file)) {
		$inventory = fgetcsv($file, 2048, "|");
		if (!empty($inventory[7])) {
			$stock = ", stock";
			$stockValue = ", " . $inventory[7];
		} else {
			$stock = "";
			$stockValue = "";
		}
		if (!empty($inventory[8])) {
			$sale = ", originalPrice";
			$saleValue = ", " . $inventory[8];
		} else {
			$sale = "";
			$saleValue = "";
		}
		
		$mysql->query("INSERT INTO Inventory(productID, productName, department, brand, description, price, image".$stock.$sale.")
		VALUES(".$inventory[0].",'".$inventory[1]."','".$inventory[2]."','".$inventory[3]."','".$inventory[4]."',".$inventory[5].",'".$inventory[6]."'".$stockValue.$saleValue.")");
	}
	$mysql->query("CREATE TABLE CustomerInfo (
		orderID INT NOT NULL,
		firstName TINYTEXT NOT NULL,
		middleName TINYTEXT,
		lastName TINYTEXT NOT NULL,
		email TINYTEXT NOT NULL,
		tel TINYTEXT NOT NULL,
		bday DATE NOT NULL,
		address TINYTEXT NOT NULL,
		city TINYTEXT NOT NULL,
		province TINYTEXT NOT NULL,
		postalCode CHAR(6) NOT NULL,
		creditCard CHAR(16) NOT NULL,
		secCode CHAR(3) NOT NULL,
		expires DATE NOT NULL,
		PRIMARY KEY(orderID)
	)");
	$mysql->close();
	echo "SUCCESS!";
?>