<!DOCTYPE html>
<html>

    <?php 
        include("sidebar.php"); 
    ?>

    <div id="refundBox">
        <h3 id="rTitle">Refund Items</h3>
        <p id="rLabel"><b>In order to refund your items, you must enter your receipt number in the title box below.</b></p>
        <form action="refund.php" method="post" id="refundForm">
            <input type="number" id="receipt" name="receipt" placeholder="Enter receipt number"/>
            <input type="submit" id="rButton" value="Refund!"/>
        </form>
    </div>    
</body>
</html>