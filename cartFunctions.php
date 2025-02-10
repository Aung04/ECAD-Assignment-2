<?php
session_start();
include_once('db.php');
include_once('cartFunctions.php');
include("navbar.php");

$shopperID = isset($_SESSION['ShopperID']) ? $_SESSION['ShopperID'] : 0;

$query = "SELECT SCI.ProductID, P.ProductTitle, P.Price, SCI.Quantity
          FROM ShopcartItem SCI
          INNER JOIN Product P ON SCI.ProductID = P.ProductID
          WHERE SCI.ShopCartID IN (SELECT ShopCartID FROM ShopCart WHERE ShopperID = ? AND OrderPlaced = 0)";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopperID);
$stmt->execute();
$result = $stmt->get_result();

$totalAmount = 0;
?>

<h1>Shopping Cart</h1>

<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php $total = $row['Price'] * $row['Quantity']; ?>
            <tr>
                <td><?php echo $row['ProductTitle']; ?></td>
                <td><?php echo number_format($row['Price'], 2); ?></td>
                <td><?php echo $row['Quantity']; ?></td>
                <td><?php echo number_format($total, 2); ?></td>
                <td>
                    <form method="post" action="cartFunctions.php">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="ProductID" value="<?php echo $row['ProductID']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>