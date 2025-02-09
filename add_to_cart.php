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
    if (!isset($_SESSION["ShopperID"])) {
        // Redirect to the login page if the session variable ShopperID is not set
        header("Location: login.php");
        exit;
    }

    // Include the database connection file
    include_once("mysql_conn.php");

    // Check if a shopping cart exists; if not, create a new shopping cart
    if (!isset($_SESSION["Cart"])) {
        // Create a shopping cart for the shopper
        $insertQuery = "INSERT INTO Shopcart (ShopperID) VALUES(?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("i", $_SESSION["ShopperID"]);
        $stmt->execute();
        $stmt->close();

        $getLastInsertIdQuery = 'SELECT LAST_INSERT_ID() AS ShopCartID';
        $result = $conn->query($getLastInsertIdQuery);
        $row = $result->fetch_array();
        $_SESSION["Cart"] = $row["ShopCartID"];
    }

    // Check if the ProductID exists in the shopping cart
    // If it does, update the quantity; otherwise, add the item to the shopping cart
    // Note: You may need to adjust the SQL queries based on your database schema

    // Close the database connection
    $conn->close();

    // Update the session variable used for counting the number of items in the shopping cart
    if (isset($_SESSION["NumCartItem"])) {
        $_SESSION["NumCartItem"] += 1; // You may need to adjust this based on your logic
    } else {
        $_SESSION["NumCartItem"] = 1;
    }

    // Redirect the shopper to the shopping cart page
    header("Location: shoppingCart.php");
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
    include_once("mysql_conn.php");

    // ... (your existing code for updating items)

    // Close the database connection
    $conn->close();

    // Redirect the shopper to the shopping cart page
    header("Location: shoppingCart.php");
    exit();
}

function removeItem() {
    // Check if the shopping cart exists
    if (!isset($_SESSION["Cart"])) {
        // Redirect to the login page if the session variable Cart is not set
        header("Location: login.php");
        exit;
    }

    // ... (your existing code for removing items)

    // Redirect the shopper to the shopping cart page
    header("Location: shoppingCart.php");
    exit();
}
?>
