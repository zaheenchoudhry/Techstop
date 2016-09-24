<!DOCTYPE html>
<html>
        
<?php
    $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    session_start();
    include("sidebar.php");
    echo "<form action=\"addcart.php\" method=\"get\">";
    $mysql = new mysqli("localhost", "root", "", "Inventory");
    // Lists all items in the cart in a table
	$totalPrice = 0;		
    echo "<div id=\"carts\">";
    if (isset($_SESSION['products'])) {
        $products = $_SESSION["products"];
        echo "<table id='cart'>
            <tr class='heading'>
            <th>Model ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Remove from Cart</th>
            </tr>";
        for ($i = 0; $i < sizeof($products); $i += 1) {
            echo "<tr class='cProducts'>
                <td class='cartDetail' width='90'>".$products[$i]["code"]."</td>
                <td class='cartDetail' width='400'>".$products[$i]["name"]."</td>
                <td class='cartDetail' width='80'>$".$products[$i]["price"]."</td>
                <td class='cartDetail'>".$products[$i]["qty"]."</td>
                <td class='cartDetail'><button type=\"submit\" id=\"removep\" name=\"removep\" value=\"".$products[$i]["code"]."\">Delete</button></td>
                </tr>";
            $totalPrice += $products[$i]["price"] * $products[$i]["qty"];
        } 
        echo "</table>";
        echo "<h4 class=\"finalPrice\"><b>Total Price Cost:</b> $".number_format($totalPrice, 2)."</h4>";
        echo "<input type=\"submit\" name=\"Checkout\" value=\"Checkout\"/>";
    } else {
        echo "You have no items in your shopping cart!";
    }
    // Creates the last purchases box
    $totalPrice = 0;
    echo "<hr/>";
    echo "<p id='checkoutLabel'><b>Checkout Center</b></p><br>";
    if (isset($_SESSION['purchaseproducts'])) {
        $products = $_SESSION["purchaseproducts"];
        echo "<table id='checkout'>
            <tr class='heading'>
            <th>Model Number</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Receipt ID</th>
            </tr>";
        for ($i = 0; $i < sizeof($products); $i += 1) {
            echo "<tr class='lProducts'>
                <td class='checkoutDetail' width='150'>".$products[$i]["code"]."</td>
                <td class='checkoutDetail' width='400'>".$products[$i]["name"]."</td>
                <td class='checkoutDetail' width='90'>$".$products[$i]["price"]."</td>
                <td class='checkoutDetail' width='90'>".$products[$i]["qty"]."</td>
                <td class='checkoutDetail' width='90'>".$_SESSION["receiptID"]."</td>
                </tr>";
            $totalPrice += $products[$i]["price"] * $products[$i]["qty"];
        }
        echo "</table>";
    }
    echo "<h4 class=\"finalPrice\"><b>Total Price Paid:</b> $".number_format($totalPrice, 2)."</h4>";
    echo "</div>";
    $mysql->close();
    echo "<input type=\"hidden\" name=\"return_url\" value=\"".$current_url."\"/>";
    echo "</form>";
?>
</div>
</body>
</html>