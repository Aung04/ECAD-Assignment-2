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

function addItem()
{
    // Start session if not already started
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["ShopperID"])) {
        // Redirect to the login page if the session variable ShopperID is not set
        header("Location: login.php");
        exit;
    }

    // Include the database connection file
    include_once("db.php");

    // Validate if ProductID and Quantity are provided in the POST request
    if (!isset($_POST["ProductID"]) || !isset($_POST["Quantity"])) {
        die("Error: ProductID or Quantity missing.");
    }

    $ProductID = intval($_POST["ProductID"]);
    $Quantity = intval($_POST["Quantity"]);

    // Check if a shopping cart exists; if not, create a new shopping cart
    if (!isset($_SESSION["Cart"])) {
        // Create a shopping cart for the shopper
        $insertQuery = "INSERT INTO Shopcart (ShopperID) VALUES(?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("i", $_SESSION["ShopperID"]);
        $stmt->execute();
        $stmt->close();

        // Retrieve the newly created cart ID
        $getLastInsertIdQuery = 'SELECT LAST_INSERT_ID() AS ShopCartID';
        $result = $conn->query($getLastInsertIdQuery);
        $row = $result->fetch_array();
        $_SESSION["Cart"] = $row["ShopCartID"];
    }

    // Get the shopping cart ID
    $CartID = $_SESSION["Cart"];

    // Check if the product already exists in the cart
    $checkQuery = "SELECT Quantity FROM ShopcartItem WHERE ShopCartID = ? AND ProductID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $CartID, $ProductID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Product exists, update quantity
        $stmt->bind_result($existingQuantity);
        $stmt->fetch();
        $newQuantity = $existingQuantity + $Quantity;

        $updateQuery = "UPDATE ShopcartItem SET Quantity = ? WHERE ShopCartID = ? AND ProductID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("iii", $newQuantity, $CartID, $ProductID);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Product does not exist, insert new row
        $insertQuery = "INSERT INTO ShopcartItem (ShopCartID, ProductID, Quantity) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iii", $CartID, $ProductID, $Quantity);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $stmt->close();

    // Update the session variable for cart item count
    $countQuery = "SELECT SUM(Quantity) FROM ShopcartItem WHERE ShopCartID = ?";
    $countStmt = $conn->prepare($countQuery);
    $countStmt->bind_param("i", $CartID);
    $countStmt->execute();
    $countStmt->bind_result($totalItems);
    $countStmt->fetch();
    $_SESSION["NumCartItem"] = $totalItems; // Update the count dynamically
    $countStmt->close();

    // Close the database connection
    $conn->close();

    // Redirect to the shopping cart page
    header("Location: shoppingCart.php");
    exit();
}

function updateItem()
{
    // Check if the shopping cart exists
    if (!isset($_SESSION["Cart"])) {
        // Redirect to the login page if the session variable Cart is not set
        header("Location: login.php");
        exit;
    }

    // Include the database connection file
    include_once("db.php");



    // Close the database connection
    $conn->close();

    // Redirect the shopper to the shopping cart page
    header("Location: shoppingCart.php");
    exit();
}

function removeItem()
{
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