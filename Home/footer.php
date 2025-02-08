<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Baby Store Footer</title>
  <style>
    /* General Footer Styles */
    .footer {
      background-color: #f8f9fa;
      color: #333;
      padding: 20px 0;
      font-family: Arial, sans-serif;
    }

    .footer-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      padding: 0 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Footer Sections */
    .footer h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: #007bff;
    }

    .footer-about p {
      font-size: 0.9rem;
      color: #555;
    }

    .footer-nav ul,
    .footer-service ul {
      list-style: none;
      padding: 0;
    }

    .footer-nav li,
    .footer-service li {
      margin-bottom: 5px;
    }

    .footer-nav a,
    .footer-service a {
      text-decoration: none;
      color: #333;
      transition: color 0.3s;
    }

    .footer-nav a:hover,
    .footer-service a:hover {
      color: #007bff;
    }

    .footer-contact p {
      font-size: 0.9rem;
      margin: 5px 0;
    }

    /* Footer Bottom */
    .footer-bottom {
      text-align: center;
      padding: 10px 20px;
      background-color: #e9ecef;
      margin-top: 20px;
    }

    .footer-bottom p {
      font-size: 0.8rem;
      margin: 5px 0;
    }

    .social-icons a {
      margin: 0 5px;
      display: inline-block;
    }

    .social-icons img {
      width: 20px;
      height: 20px;
      transition: transform 0.3s;
    }

    .social-icons img:hover {
      transform: scale(1.1);
    }
  </style>
</head>
<body>
  <footer class="footer">
    <div class="footer-container">
      <!-- Footer Logo and Description -->
      <div class="footer-about">
        <h2 class="footer-logo">BabyCare</h2>
        <p>Your one-stop shop for all your baby's needs.</p>
      </div>

      <!-- Footer Navigation -->
      <div class="footer-nav">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="/about.html">About Us</a></li>
          <li><a href="/shop.html">Shop</a></li>
          <li><a href="/contact.html">Contact</a></li>
          <li><a href="/faq.html">FAQ</a></li>
        </ul>
      </div>

      <!-- Footer Customer Service -->
      <div class="footer-service">
        <h3>Customer Service</h3>
        <ul>
          <li><a href="/returns.html">Returns & Exchanges</a></li>
          <li><a href="/shipping.html">Shipping Policy</a></li>
          <li><a href="/privacy.html">Privacy Policy</a></li>
          <li><a href="/terms.html">Terms of Service</a></li>
        </ul>
      </div>

      <!-- Footer Contact Information -->
      <div class="footer-contact">
        <h3>Contact Us</h3>
        <p>Email: support@babycare.com</p>
        <p>Phone: +65</p>
        <p>Address: Ngee Ann Poly</p>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <p>&copy; 2025 BabyCare. All Rights Reserved.</p>
      <div class="social-icons">
        <a href="#"><img src="icons/facebook.svg" alt="Facebook"></a>
        <a href="#"><img src="icons/instagram.svg" alt="Instagram"></a>
        <a href="#"><img src="icons/twitter.svg" alt="Twitter"></a>
      </div>
    </div>
  </footer>
</body>
</html>
