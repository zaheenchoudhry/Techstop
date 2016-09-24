<!DOCTYPE html>
<html>

<?php
    function makeProductBox($querySearch, $current_url) {
        $mysql = new mysqli("localhost", "root", "", "Inventory");
        $results = $mysql->query($querySearch);
        
        while ($row = mysqli_fetch_array($results)) {
            echo "<div class=\"productbox\">
                <h4 class=\"name\">".$row[1]."</h4>
                <h5 class=\"id\"><b>Model Number:</b> ".$row[0]."</h5>
                <h5 class=\"category\"><b>Category:</b> ".$row[2]."</h5>
                <h5 class=\"company\"><b>Company:</b> ".$row[3]."</h5>
                <p class=\"description\"><b>Description:</b><br>".$row[4]."</p>
                <h5 class=\"price\"><b>Price:</b> ".$row[5]."</h5>
                <img class=\"image\" src=".$row[6]." height='150' width='150' alt=\"Product image here\"/>
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
        $mysql->close();
    }
    include("sidebar.php");
    $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $category = createArray("category");
    $company = createArray("company");
			
    if ($_GET['name'] == 'products') {
        makeProductBox("SELECT * FROM Products ORDER BY name", $current_url);
    }

    for ($i = 0; $i < sizeof($company); $i++) {
        $company[$i] = preg_replace('/\s+/', '', $company[$i]);
        if ($_GET['name'] == $company[$i]) {
            makeProductBox("SELECT * FROM Products WHERE company=\"".$company[$i]."\" ORDER BY name", $current_url);
            break;
        }
    }

    for ($i = 0; $i < sizeof($category); $i++) {
        $category[$i] = preg_replace('/\s+/', '', $category[$i]);
        if ($_GET['name'] == $category[$i]) {
            makeProductBox("SELECT * FROM Products WHERE category=\"".$category[$i]."\" ORDER BY name", $current_url);
            break;
        }
    }
    echo "<input type=\"hidden\" name=\"return_url\" value=\"$current_url\"/>";
?>
</body>
</html>