<!DOCTYPE html>
<html>

    <?php
	   $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        session_start();
        include("sidebar.php");
        echo "<h3 id='indexLabel'>Currently in Stock!</h3>";

        if (isset($_COOKIE['AECCart'])) {
            $_SESSION["products"] = unserialize($_COOKIE['AECCart']);
        }
        $mysql = new mysqli("localhost", "root", "", "Inventory");
        $results = $mysql->query("SELECT * FROM Products");
        $tableSize = mysqli_num_rows($results); // Counts no. of rows in database table
		
        for ($i = 0; $i < 3; $i += 1) {
            $product = rand(1, $tableSize);
            $results = $mysql->query("SELECT * FROM Products WHERE image=\"productimages/".$product.".jpg\" AND inventory > 0");

            while ($row = mysqli_fetch_array($results)) {
                echo "<div class=\"productbox\">
                    <h4 class=\"name\">".$row[1]."</h4>
                    <h5 class=\"id\"><b>Model Number:</b> ".$row[0]."</h5>
                    <h5 class=\"category\"><b>Category:</b> ".$row[2]."</h5>
                    <h5 class=\"company\"><b>Company:</b> ".$row[3]."</h5>
                    <p class=\"description\"><b>Description:</b><br/>".$row[4]."</p>
                    <h5 class=\"price\"><b>Price:</b> ".$row[5]."</h5>
                    <img class=\"image\" src=".$row[6]." height=150 width=150 alt=\"Product image here\"/>
                    <h5 class=\"inventory\"><b>Quantity:</b> ".$row[7]."</h5>";
                // Adds the stock bar or indicates if the product is sold out
                if ($row[7] == 0) {
                    echo "<p2 id='outOfStock'>Out of Stock</p2>";
                } else {
                    echo "<form action=\"addcart.php\" class=\"quantity\" method=\"post\">
                        Quantity (between 1 and ".$row[7]."): <input type=\"number\" name=\"product_qty\" min=\"1\" max=\"$row[7]\"/>
                        <input type=\"hidden\" name=\"product_code\" value=\"".$row[0]."\"/>
                        <input type=\"hidden\" name=\"return_url\" value=\"".$current_url."\"/>
                        <button type = \"submit\" name=\"type\" value = \"add\">Add to Cart</button>
                        </form>";
                }
                echo "</div>";
            }
        }
    ?>
    </div>
    </body>
</html>