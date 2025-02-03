<?php
// delete_cart.php

include_once('mysqlConn.php');

// Get shopper ID from the session
session_start();
$shopperID = isset($_SESSION['shopperID']) ? $_SESSION['shopperID'] : 0;

if (isset($_POST['delete_cart'])) {
    $productID = $_POST['product_id'];

    // Add validation if needed

    // Delete the item from the cart in the database
    $deleteQuery = "DELETE FROM ShopCartItem
                    WHERE ShopCartID IN (SELECT ShopCartID FROM ShopCart WHERE ShopperID = $shopperID AND OrderPlaced = 0)
                    AND ProductID = $productID";
    mysqli_query($conn, $deleteQuery);

    // Redirect back to the shopping cart page
    header("Location: shopping_cart.php");
    exit();
}
?>
