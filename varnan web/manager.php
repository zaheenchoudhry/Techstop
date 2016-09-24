<?php
	session_start();
	$con = mysqli_connect("localhost", "root", "");

	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: ".mysqli_connect_error();
	}
	// Create database, deletes tables if it exists
	$mysql = "CREATE DATABASE Inventory";
	if (mysqli_query($con,$mysql)) {
		echo "Connection successful, database created.";
	} else {
		$mysql = new mysqli("localhost", "root", "", "Inventory");
		$mysql->query("DROP TABLE Products");
		$mysql->query("DROP TABLE Cart");
	}

	$mysql = new mysqli("localhost", "root", "", "Inventory");
	// Creates the inventory table
	$mysql->query("CREATE TABLE Products (
			productID VARCHAR(30),
			name VARCHAR(200),
			category VARCHAR(60),
			company VARCHAR(60),
			description VARCHAR(500),
			price VARCHAR(60),
			image VARCHAR(60),
			inventory INT
			)");
	
	// Creates the Cart Table
	$mysql->query("CREATE TABLE Cart (
			orderID INT AUTO_INCREMENT,
			receiptID INT,
			productID VARCHAR(30),
			quantity INT,
			PRIMARY KEY(orderID),
			refunded TINYINT DEFAULT 0
			)");
	
    // Error check in case the first one fails
	if ($mysql->error) {
        echo $mysql->error; 
        exit(); 
    }
		
	// Seperates the CSV values into the Inventory table
	if (($handle = fopen("inventory.txt", "r")) !== FALSE) { 
        while (($lineArray = fgetcsv($handle, 1024, ',')) !== FALSE) {
			$line = "'".implode("','", $lineArray)."'";
			$line = "INSERT INTO Products (productID ,name, category, company, description, price, image, inventory)
				VALUES (".$line.");";
			$mysql->query($line);
        } 
        fclose($handle); 
	}
	echo "Database store created successfully <br>";
	$_SESSION['products'] = null;
	$_SESSION['purchaseproducts'] = null;
	setcookie('AECCart', "", time() - 1);  // Cookies set up to temporarily hold database items
	$mysql->close();
	$con->close();
?>