<?php
session_start();
include 'db.php';

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$product_sql = "SELECT * FROM Product WHERE ProductID = $product_id";
$product_result = $conn->query($product_sql);
$product = $product_result->fetch_assoc();

// If product does not exist, show error
if (!$product) {
    die("Product not found!");
}

// Get the stock quantity
$stock_quantity = $product['Quantity'];

// Fetch product specifications from `productspec` table
$specs_sql = "SELECT SpecVal FROM productspec WHERE ProductID = $product_id ORDER BY Priority ASC";
$specs_result = $conn->query($specs_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['ProductTitle']); ?></title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            max-width: 2000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            
        }

        .product-image {
            flex: 1;
            text-align: center;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-details {
            flex: 1;
            padding: 20px;
        }

        .product-title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 26px;
            color: gray;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* Quantity Selector with Stock Info */
        .quantity-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .quantity-container input {
            width: 60px;
            padding: 8px;
            font-size: 18px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .stock-info {
            font-size: 16px;
            color: gray;
        }

        .add-to-cart {
            background: black;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 30px;
            font-size: 16px;
            margin-top: 10px;
            width: 30%;
        }

        .add-to-cart:hover {
            background: #444;
        }

        .specifications {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 24px;
        }

        .specifications ul {
            list-style-type: none;
            padding: 0;
        }

        .specifications ul li {
            font-size: 22px;
            padding: 5px 0;
        }

        .back-btn {
            position: absolute;
            top: 60px;
            left: 60px;
            font-size: 60px;
            text-decoration: none;
            color: black;
        }

        .back-btn:hover {
            opacity: 0.7;
        }
    </style>
</head>
<body>

<a href="index.php" class="back-btn">←</a>

<div class="container">
    <!-- Product Image -->
    <div class="product-image">
        <img src="Images/Products/<?php echo htmlspecialchars($product['ProductImage']); ?>" 
             alt="<?php echo htmlspecialchars($product['ProductTitle']); ?>" 
             onerror="this.src='Images/default-placeholder.png';">
    </div>

    <!-- Product Details -->
    <div class="product-details">
        <h1 class="product-title"><?php echo htmlspecialchars($product['ProductTitle']); ?></h1>
        <p class="product-price">$<?php echo number_format($product['Price'], 2); ?></p>

        <p class="product-description"><?php echo htmlspecialchars($product['ProductDesc']); ?></p>

        <div class="quantity-container">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $stock_quantity; ?>">
            <span class="stock-info">(<?php echo $stock_quantity; ?> left in stock)</span>
        </div>

        <button class="add-to-cart" data-id="<?php echo $product['ProductID']; ?>">Add to cart</button>

        <div class="specifications">
            <h4>Product Specs</h4>
            <ul>
                <?php if ($specs_result->num_rows > 0): ?>
                    <?php while ($spec = $specs_result->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($spec['SpecVal']); ?></li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li>No specifications available.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".add-to-cart").addEventListener("click", function() {
        let productId = this.getAttribute("data-id");
        let quantity = document.getElementById("quantity").value;

        fetch("add_to_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "product_id=" + productId + "&quantity=" + quantity
        })
        .then(response => response.text())
        .then(data => {
            alert("Added to Cart!");
        })
        .catch(error => console.error("Error:", error));
    });
});
</script>

</body>
</html>
