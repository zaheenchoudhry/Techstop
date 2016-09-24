<?php
	$current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	session_start();
	include("sidebar.php");
	
	function highlightWords($text, $words) {
		foreach ($words as $word) {
			$word = preg_quote($word);
			$text = preg_replace("/\b($word)\b/i", '<span class="highlight_word">\1</span>', $text);
			$text = str_ireplace($word, '<span class="highlight_word">'.$word.'</span>', $text);
		}
        return $text;
	}
	
	if (isset($_GET['searchBar'])) {
		$search = htmlentities($_GET['searchBar']);
		$mysql = new mysqli("localhost", "root", "", "Inventory");
		$contents = $mysql->query("SELECT * FROM Products WHERE name REGEXP '$search' 
												OR company REGEXP '$search' 
												OR description REGEXP '$search' ORDER BY name");
        
		while ($row = mysqli_fetch_array($contents)) {
			$searchTerms = array(strtoupper($search));
			$row[1] = highlightWords($row[1],$searchTerms);  // Highlights match in Product Name
			$row[3] = highlightWords($row[3],$searchTerms);  // Highlights match in Company Name
			$row[4] = highlightWords($row[4],$searchTerms);  // Highlights match in Description
			
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
    }
?>