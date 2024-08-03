<?php
session_start();
unset($_SESSION['wishlist']); // Clear the wishlist session data
unset($_SESSION['cart']); // Clear the wishlist session data
unset($_SESSION['cart_quantities']); // Clear the wishlist session data
unset($_SESSION['cart_summary']); // Clear the wishlist session data
unset($_SESSION['user_id']); // Clear the wishlist session data




header('Location: http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/index.php'); // Redirect to your main page or wherever you want
exit();
