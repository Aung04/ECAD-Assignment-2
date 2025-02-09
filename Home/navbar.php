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
                }

                /* header */

                .header {
                background-color: #fff;
                box-shadow: 1px 1px 4px 0 rgba(0,0,0,.1);
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

                .header li a {
                display: block;
                padding: 20px 20px;
                border-right: 1px solid #f4f4f4;
                text-decoration: none;
                }

                .header li a:hover,
                .header .menu-btn:hover {
                background-color: #f4f4f4;
                }

                .header .logo {
                display: block;
                float: left;
                font-size: 2em;
                padding: 10px 20px;
                text-decoration: none;
                }

                /* menu */

                .header .menu {
                clear: both;
                max-height: 0;
                transition: max-height .2s ease-out;
                }

                /* menu icon */

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
                position: relative;
                transition: background .2s ease-out;
                width: 18px;
                }

                .header .menu-icon .navicon:before,
                .header .menu-icon .navicon:after {
                background: #333;
                content: '';
                display: block;
                height: 100%;
                position: absolute;
                transition: all .2s ease-out;
                width: 100%;
                }

                .header .menu-icon .navicon:before {
                top: 5px;
                }

                .header .menu-icon .navicon:after {
                top: -5px;
                }

                /* menu btn */

                .header .menu-btn {
                display: none;
                }

                .header .menu-btn:checked ~ .menu {
                max-height: 240px;
                }

                .header .menu-btn:checked ~ .menu-icon .navicon {
                background: transparent;
                }

                .header .menu-btn:checked ~ .menu-icon .navicon:before {
                transform: rotate(-45deg);
                }

                .header .menu-btn:checked ~ .menu-icon .navicon:after {
                transform: rotate(45deg);
                }

                .header .menu-btn:checked ~ .menu-icon:not(.steps) .navicon:before,
                .header .menu-btn:checked ~ .menu-icon:not(.steps) .navicon:after {
                top: 0;
                }

                /* 48em = 768px */

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
  <a href="" class="logo">NP Baby Store</a>
  <input class="menu-btn" type="checkbox" id="menu-btn" />
  <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
  <ul class="menu">
    <li><a href="#">nav1</a></li>
    <li><a href="#">nav2</a></li>
    <li><a href="#">nav3</a></li>
    <li><a href="#">nav4</a></li>
  </ul>
</header>

