<!DOCTYPE html>
<html>

<?php
	include("sidebar.php");
    $mysql = new mysqli("localhost", "root", "", "Inventory");
    $receipt = htmlentities($_POST['receipt']);
    
    $totalPrice = 0;
    $results = $mysql->query("SELECT * FROM Cart WHERE refunded = 0 AND receiptID = '$receipt'");
	$update = $mysql->query("UPDATE Cart SET refunded = 1 WHERE receiptID = '$receipt'");
	
    echo "<div id='refundBar'>";
    echo "<p1><b><i>You have refunded the following items!</i></b></p1><br/><hr/>";

    while ($row = mysqli_fetch_array($results)) {
	
		$update = $mysql->query("UPDATE Products SET inventory = inventory + ".$row[3]." WHERE productID = '$row[2]'");
        $inv = $mysql->query("SELECT * FROM Products WHERE productID = '$row[2]'");
        
        while ($invInfo = mysqli_fetch_array($inv)) {
            $totalPrice = $totalPrice + ($invInfo[5] * $row[3]);
        
            echo "<div class='refundProduct'> <h4 class=\"rName\">".$invInfo[1]."</h3>
                    <h5 class=\"rId\"><b>Model Number:</b> ".$row[2]."</h4>
                    <h5 class=\"rCategory\"><b>Category:</b> ".$invInfo[2]."</h5>
                    <h5 class=\"rCompany\"><b>Company:</b> ".$invInfo[3]."</h5>
                    <h5 class=\"rPrice\"><b>Price:</b> $".number_format($invInfo[5], 2)."</h5>
                    <img class=\"rImage\" src=\"".$invInfo[6]."\" style=\"width: 150px; height: 150px; left: 0px;\"/>
                    <h5 class=\"rStock\"><b>Quantity:</b> ".$row[3]."</h5>
                    <hr/>
					</div>";
        }
    }
    // Puts an error message if there is no items in this receipt (most likely an invalid receipt number)
    if ($totalPrice != 0) {
        echo "<h4 class=\"finalPrice\"><b>Total Cost:</b> $".number_format($totalPrice, 2)."</h4><hr/>";
    } else {
        echo "<h4 class=\"finalPrice\"><b>This is not a valid receipt number!</b></h4><hr/>";
    }
    echo "</div>";
?>
</body>    
</html>