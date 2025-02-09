<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blossom Baby Store</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Helvetica, sans-serif;
            background-color: #f4f4f4;
        }

        a {
            color: #000;
            text-decoration: none;
        }

        /* Header */
        .header {
            background-color: #fff;
            box-shadow: 1px 1px 4px 0 rgba(0, 0, 0, .1);
            position: fixed;
            width: 100%;
            z-index: 3;
        }

        .header ul {
            margin: 0;
            padding: 0;
            list-style: none;
            overflow: hidden;
            background-color: #fff;
        }

        .header li {
            float: left;
        }

        .header li a {
            display: block;
            padding: 20px 20px;
            border-right: 1px solid #f4f4f4;
        }

        .header li a:hover {
            background-color: #f4f4f4;
        }

        .header .logo {
            display: block;
            float: left;
            font-size: 2em;
            padding: 10px 20px;
        }

        /* Mobile Menu */
        .header .menu {
            clear: both;
            max-height: 0;
            transition: max-height .2s ease-out;
        }

        .header .menu-icon {
            cursor: pointer;
            display: inline-block;
            float: right;
            padding: 28px 20px;
            position: relative;
            user-select: none;
        }

        .header .menu-icon .navicon {
            background: #333;
            display: block;
            height: 2px;
            width: 18px;
            position: relative;
            transition: background .2s ease-out;
        }

        .header .menu-icon .navicon:before,
        .header .menu-icon .navicon:after {
            background: #333;
            content: '';
            display: block;
            height: 100%;
            width: 100%;
            position: absolute;
            transition: all .2s ease-out;
        }

        .header .menu-icon .navicon:before {
            top: 5px;
        }

        .header .menu-icon .navicon:after {
            top: -5px;
        }

        /* Menu Toggle */
        .header .menu-btn {
            display: none;
        }

        .header .menu-btn:checked~.menu {
            max-height: 300px;
        }

        /* Desktop View */
        @media (min-width: 48em) {
            .header li {
                float: left;
            }

            .header li a {
                padding: 20px 30px;
            }

            .header .menu {
                clear: none;
                float: right;
                max-height: none;
            }

            .header .menu-icon {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="index.php" class="logo">Blossom Baby Store</a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>

        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="Shopping_cart.php">Shopping Cart</a></li>
            <li><a href="#">Account</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </header>
</body>

</html>