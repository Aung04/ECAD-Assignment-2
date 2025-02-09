<?php
session_start();
include 'db.php';
// Fetch categories
$category_sql = "SELECT * FROM Category ORDER BY CatName ASC";
$category_result = $conn->query($category_sql);
// Fetch products
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";
$product_sql = "SELECT * FROM Product WHERE 1=1";
if ($category_filter) {
    $product_sql .= " AND ProductID IN (SELECT ProductID FROM CatProduct WHERE CategoryID = $category_filter)";
}
if ($search_query) {
    $product_sql .= " AND (ProductTitle LIKE '%$search_query%' OR ProductDesc LIKE '%$search_query%')";
}
$product_sql .= " ORDER BY ProductTitle ASC";
$product_result = $conn->query($product_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: black;
            padding: 15px;
        }

        header h1 {
            margin: 0;
        }

        header form input {
            padding: 8px;
            font-size: 14px;
        }

        header form button {
            padding: 8px 12px;
            background: #ffcc00;
            border: none;
            cursor: pointer;
        }

        .container {
            display: flex;
            margin: 20px;
        }

        .sidebar {
            width: 20%;
            background: #f4f4f4;
            padding: 15px;
        }

        .sidebar h3 {
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 8px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #007bff;
        }

        .product-list {
            width: 80%;
            padding: 15px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background: white;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Clickable Product Image */
        .product-card img {
            width: 100%;
            max-height: 180px;
            object-fit: contain;
            cursor: pointer;
        }

        /* Styled "Add to Cart" Button */
        .add-to-cart {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
            margin-top: 10px;
            width: 100%;
        }

        .add-to-cart:hover {
            background: #218838;
        }

        .disabled-btn {
            background: gray;
            color: white;
            border: none;
            padding: 10px;
            cursor: not-allowed;
            border-radius: 3px;
            font-size: 14px;
            margin-top: 10px;
            width: 100%;
        }

        .cart-btn {
            background: #ffcc00;
            padding: 10px;
            text-decoration: none;
            color: black;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Blossom Baby Care</h1>
        <div class="search-bar">
            <form method="GET" action="index.php">
                <input type="text" name="search" placeholder="Search products..."
                    value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <a href="cart.php" class="cart-btn">🛒 View Cart (<span
                id="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>)</a>
    </header>
    <div class="container">
        <aside class="sidebar">
            <h3>Categories</h3>
            <ul>
                <li><a href="index.php">All Products</a></li>
                <?php while ($category = $category_result->fetch_assoc()): ?>
                    <li><a href="index.php?category=<?php echo $category['CategoryID']; ?>">
                            <?php echo $category['CatName']; ?></a></li>
                <?php endwhile; ?>
            </ul>
        </aside>
        <section class="product-list">
            <h2>Product Catalogue</h2>
            <div class="products-grid">
                <?php while ($product = $product_result->fetch_assoc()): ?>
                    <div class="product-card">
                        <!-- Clickable product image -->
                        <a href="product.php?id=<?php echo htmlspecialchars($product['ProductID']); ?>">
                            <img src="Images/Products/<?php echo htmlspecialchars($product['ProductImage']); ?>"
                                alt="<?php echo htmlspecialchars($product['ProductTitle']); ?>"
                                onerror="this.src='Images/default-placeholder.png';">
                        </a>
                        <!-- Clickable product title -->
                        <h3>
                            <a href="product.php?id=<?php echo htmlspecialchars($product['ProductID']); ?>">
                                <?php echo htmlspecialchars($product['ProductTitle']); ?>
                            </a>
                        </h3>
                        <div class="price-container">
                            <?php if ($product['Offered'] == 1): ?>
                                <p class="offer-label">🔥 On Offer!</p>
                                <p class="price"><del>$<?php echo number_format($product['Price'], 2); ?></del>
                                    <strong>$<?php echo number_format($product['OfferedPrice'], 2); ?></strong>
                                </p>
                            <?php else: ?>
                                <p class="price">$<?php echo number_format($product['Price'], 2); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="product-footer">
                            <?php if ($product['Quantity'] <= 0): ?>
                                <p class="out-of-stock">🚫 Out of Stock</p>
                                <button class="disabled-btn" disabled>Out of Stock</button>
                            <?php else: ?>
                                <button class="add-to-cart" data-id="<?php echo htmlspecialchars($product['ProductID']); ?>">
                                    🛒 Add to Cart
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".add-to-cart").forEach(button => {
                button.addEventListener("click", function () {
                    let productId = this.getAttribute("data-id");
                    fetch("add_to_cart.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "product_id=" + productId
                    })
                        .then(response => response.text())
                        .then(data => {
                            alert("Added to Cart!");
                            document.getElementById("cart-count").textContent = data; // Update cart count
                        })
                        .catch(error => console.error("Error:", error));
                });
            });
        });
    </script>
</body>

</html>

<header class="header">
    <a href="index.php" class="logo">
        <img src="images/store-icon.png" class="store-logo">
        Blossom Baby Store
    </a>
    <input class="menu-btn" type="checkbox" id="menu-btn" />
    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>

    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="Shopping_cart.php">Shopping Cart</a></li>
        <li><a href="#">Account</a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</header>