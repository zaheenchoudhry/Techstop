<?php
	session_start();
	
	//empty cart by destroying current session
	if (isset($_GET["emptycart"]) && $_GET["emptycart"] == 1) { 
		$return_url = base64_decode($_GET["return_url"]);
		session_destroy();
		header('Location:'.$return_url);  // Put comment here
	}

	//add item in shopping cart
	if (isset($_POST["type"]) && $_POST["type"] == 'add') {
		$product_code = filter_var($_POST["product_code"], FILTER_SANITIZE_STRING);
		$product_qty = filter_var($_POST["product_qty"], FILTER_SANITIZE_NUMBER_INT); 
		$return_url = base64_decode($_POST["return_url"]); //return url
		
		if ($product_qty == "0" || $product_qty == "") {
			header('Location:'.$return_url);
			exit();
		}
    
		//MySqli query - get details of item from db using product code
		echo "SELECT name, price FROM Products WHERE productID = '$product_code' LIMIT 1";
		$mysql = new mysqli("localhost", "root", "", "Inventory");
		$results = $mysql->query("SELECT name, price FROM Products WHERE productID = '$product_code' LIMIT 1");
		$obj = $results->fetch_object();
    
		if ($results) {
			$new_product = array(array('name'=>$obj->name, 'code'=>$product_code, 'qty'=>$product_qty, 'price'=>$obj->price));
            // Put comment here
			if (isset($_SESSION["products"])) {
				$found = false; 
            
				foreach ($_SESSION["products"] as $cart_itm) {
					if($cart_itm["code"] == $product_code){ // The item exists in array
						$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$product_qty, 'price'=>$cart_itm["price"]);
						$found = true;
					} else {
						$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
					}	
				}
                // Put comment here
				if ($found == false) {  
					$_SESSION["products"] = array_merge($product, $new_product);
				} else {
					$_SESSION["products"] = $product;
				}
            } else {
				$_SESSION["products"] = $new_product;
			}
        }
        // Put comment here
		setcookie('AECCart', serialize($_SESSION["products"]), time() + 86400);
		header('Location:'.$return_url);	
	}

	//remove item from shopping cart
	if (isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"])) {
		$product_code = $_GET["removep"]; 
		$return_url = base64_decode($_GET["return_url"]);

		foreach ($_SESSION["products"] as $cart_itm) {
			if ($cart_itm["code"] != $product_code) { 
				$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
			}
			$_SESSION["products"] = $product;
		}
		setcookie('AECCart', serialize($_SESSION["products"]), time() + 86400);
		header('Location:'.$return_url);
	}
	
	//checkout
	if (isset($_GET["Checkout"])) {
		$return_url = base64_decode($_GET["return_url"]);
		$products = $_SESSION["products"];
		$mysql = new mysqli("localhost", "root", "", "Inventory");
		$receiptID = 0;
        
		for ($i = 0; $i < sizeof($products); $i += 1) {
			$results = $mysql->query("UPDATE Products SET inventory = inventory - ".$products[$i]["qty"]." WHERE productID = '".$products[$i]["code"]."'");
			$results = $mysql->query("INSERT INTO Cart(OrderID, receiptID, ProductID, quantity) VALUES (0, ".$receiptID.", '".$products[$i]["code"]."', ".$products[$i]["qty"].")");
            // Put comment here
			if ($mysql->error) {
                echo $mysql->error; exit(); 
            }
			if ($receiptID == 0) {
				$results = $mysql->query("SELECT LAST_INSERT_ID() as lastOrderId");
				if ($mysql->error) {
                    echo $mysql->error; 
                    exit(); 
                }
				$obj = $results->fetch_object();

				$receiptID = $obj->lastOrderId + 10000;
				$mysql->query("UPDATE Cart SET receiptID= ".$receiptID." WHERE receiptID = 0");	
				$_SESSION["receiptID"] = $receiptID;
				
			}	
		} 
		$mysql->query("UPDATE Products SET inventory = 0 WHERE inventory < 0");

		$_SESSION['purchaseproducts'] = $products;
		$_SESSION["products"] = null;
		header('Location:'.$return_url);
	}
?>