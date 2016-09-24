<head>
    <meta charset="utf-8">
    <title id='main'>Amazing Electronic Center</title>
    <link rel="stylesheet" type= "text/css" href="main.css">
</head>
    
<body>
    <div id="mainContainer">
    <h1 id="mainTitle">Amazing Electronic Center</h1>
    <h2 id="mainSlogan">Amazing Quality, Amazing Price</h2>
    <img id="logo" src="logo.gif" alt="Imagine a logo here"/>
    <ul id="navBar">
        <li><a id = "home" href="index.php">Home</a></li>
        <li><a id = "products" href="browse.php?name=products">All Products</a></li>
        <li><a id = "cart" href="listcart.php">Cart</a></li>
        <li><a id = "refund" href="refundPage.php">Refund Items</a></li>
        <li>
            <form id="search" action="search.php" method="get">
                <input type="text" id="search_field" name="searchBar" maxlength="20" placeholder="Search Website" required="required"/>
                <input type="submit" id="search_button" name="submit" value="Go"/>
            </form>
        </li>
    </ul>

    <?php
        function createArray($sqlContent) {
            $mysql = new mysqli("localhost", "root", "", "Inventory");
            $results = $mysql->query("SELECT DISTINCT $sqlContent FROM Products ORDER BY $sqlContent");
            $index = 0;
        
            while ($row = mysqli_fetch_array($results)) {
                $content[$index] = $row[$sqlContent];
                $index++;
            }
            $mysql->close();
            return $content;
        }
            
        function createSideBar($content, $tableTopic) {
            echo "<table id=\"c$tableTopic\">
                <tr>
                    <th>C$tableTopic Search</th>
                </tr>";
	
            for ($i = 0; $i < sizeof($content); $i++) {
                $content[$i] = preg_replace('/\s+/', '', $content[$i]);
                echo "<tr>
                    <td><a href=\"browse.php?name=$content[$i]\">".$content[$i]."</a></td>
                    </tr>";
            }
            echo "</table>";
        }
        $company = createArray("company");
        $category = createArray("category");
        createSideBar($company, "ompany");
        createSideBar($category, "ategory");
?>