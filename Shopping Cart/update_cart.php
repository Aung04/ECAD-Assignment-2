<?php
// update_cart.php

include_once('mysqlConn.php');

// Get shopper ID from the session
session_start();
$shopperID = isset($_SESSION['shopperID']) ? $_SESSION['shopperID'] : 0;

if (isset($_POST['update_cart'])) {
    $productID = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];

    // Add validation if needed

    // Update the quantity in the database
    $updateQuery = "UPDATE ShopCartItem SET Quantity = $newQuantity
                    WHERE ShopCartID IN (SELECT ShopCartID FROM ShopCart WHERE ShopperID = $shopperID AND OrderPlaced = 0)
                    AND ProductID = $productID";
    mysqli_query($conn, $updateQuery);

    // Redirect back to the shopping cart page
    header("Location: shopping_cart.php");
    exit();
}
?>
