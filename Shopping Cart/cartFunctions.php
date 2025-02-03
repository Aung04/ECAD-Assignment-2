<?php
session_start();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            addItem();
            break;
        case 'update':
            updateItem();
            break;
        case 'delete':
            removeItem();
            break;
    }
}

function addItem() {
    // Check if the user is logged in
    if (!isset($_SESSION["shopperID"])) {
        // Redirect to the login page if the session variable ShopperID is not set
        header("Location: login.php");
        exit;
    } else {
        $shopperID = isset($_SESSION['shopperID']) ? $_SESSION['shopperID'] : 0;
    }

    // Include the database connection file
    include_once("mysqlConn.php");

    // Check if a shopping cart exists; if not, create a new shopping cart
    $cartQuery = "SELECT ShopCartID FROM ShopCart WHERE ShopperID = $shopperID AND OrderPlaced = 0";
    $existingCartResult = mysqli_query($conn, $cartQuery);

    if (mysqli_num_rows($existingCartResult) == 0) {
        // Create a shopping cart for the shopper
        $insertQuery = "INSERT INTO Shopcart (ShopperID) VALUES(?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("i", $shopperID);
        $stmt->execute();
        $stmt->close();

        $getLastInsertIdQuery = 'SELECT LAST_INSERT_ID() AS ShopCartID';
        $result = $conn->query($getLastInsertIdQuery);
        $row = $result->fetch_array();
        $_SESSION["Cart"] = $row["ShopCartID"];
    } else {
        $existingCart = mysqli_fetch_assoc($existingCartResult);
        $_SESSION["Cart"] = $existingCart["ShopCartID"];
    }

    // Check if the ProductID exists in the shopping cart
    // If it does, update the quantity; otherwise, add the item to the shopping cart
    // Note: You may need to adjust the SQL queries based on your database schema

    // Check if a product is being added to the cart
    if (isset($_POST['product_id'])) {
        $productID = $_POST['product_id'];
        $price = $_POST['price'];

        // Check if the product is already in the cart
        $existingCartItemQuery = "SELECT * FROM ShopCartItem 
                                WHERE ShopCartID IN (SELECT ShopCartID FROM ShopCart WHERE ShopperID = $shopperID AND OrderPlaced = 0)
                                AND ProductID = $productID";
        $existingCartItemResult = mysqli_query($conn, $existingCartItemQuery);

        if (mysqli_num_rows($existingCartItemResult) > 0) {
            // Product already in the cart, update quantity
            $existingCartItem = mysqli_fetch_assoc($existingCartItemResult);
            $newQuantity = $existingCartItem['Quantity'] + 1;

            $updateQuery = "UPDATE ShopCartItem SET Quantity = $newQuantity
                            WHERE ShopCartID = {$existingCartItem['ShopCartID']} AND ProductID = $productID";
            mysqli_query($conn, $updateQuery);
        } else {
            // Product not in the cart, insert as a new item
            $newQuantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
            $insertQuery = "INSERT INTO ShopCartItem (ShopCartID, ProductID, Price, Quantity)
                            VALUES ($_SESSION[Cart], $productID, $price, $newQuantity)";
            mysqli_query($conn, $insertQuery);
        }
    }

    // Close the database connection
    $conn->close();

    // Update the session variable used for counting the number of items in the shopping cart
    if (isset($_SESSION["NumCartItem"])) {
        $_SESSION["NumCartItem"] += $newQuantity; // Update the total quantity
    } else {
        $_SESSION["NumCartItem"] = $newQuantity;
    }

    // Redirect the shopper to the shopping cart page
    header("Location: Shopping_Cart.php");
    exit();
}


function updateItem() {
    // Check if the shopping cart exists
    if (!isset($_SESSION["Cart"])) {
        // Redirect to the login page if the session variable Cart is not set
        header("Location: login.php");
        exit;
    }

    // Include the database connection file
    include_once("mysqlConn.php");

    
    $productID = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];
    $shopperID = isset($_SESSION['shopperID']) ? $_SESSION['shopperID'] : 0;

    // Add validation if needed

    // Update the quantity in the database
    $updateQuery = "UPDATE ShopCartItem SET Quantity = $newQuantity
                    WHERE ShopCartID IN (SELECT ShopCartID FROM ShopCart WHERE ShopperID = $shopperID AND OrderPlaced = 0)
                    AND ProductID = $productID";

    if (mysqli_query($conn, $updateQuery)) {
        // Quantity updated successfully
        echo "Quantity updated successfully!";
    } else {
        // Error updating quantity
        echo "Error updating quantity: " . mysqli_error($conn);
    }

    // Close the database connection
    $conn->close();

    // Redirect the shopper to the shopping cart page
    header("Location: Shopping_Cart.php");
    exit();
}


function removeItem() {
    // Check if the shopping cart exists
    if (!isset($_SESSION["Cart"])) {
        // Redirect to the login page if the session variable Cart is not set
        header("Location: login.php");
        exit;
    }

    // Include the database connection file
    include_once("mysqlConn.php");

    // ... (your existing code for removing items)
    $productID = $_POST['product_id'];
    $shopperID = isset($_SESSION['shopperID']) ? $_SESSION['shopperID'] : 0;

    // Add validation if needed

    // Delete the item from the cart in the database
    $deleteQuery = "DELETE FROM ShopCartItem
                    WHERE ShopCartID IN (SELECT ShopCartID FROM ShopCart WHERE ShopperID = $shopperID AND OrderPlaced = 0)
                    AND ProductID = $productID";
    mysqli_query($conn, $deleteQuery);

    // Redirect the shopper to the shopping cart page
    header("Location: Shopping_Cart.php");
    exit();
}
?>
