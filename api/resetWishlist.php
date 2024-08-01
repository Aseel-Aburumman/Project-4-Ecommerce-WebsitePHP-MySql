<?php
session_start();
unset($_SESSION['wishlist']); // Clear the wishlist session data
header('Location: http://localhost/ecommercebreifdb/index.php'); // Redirect to your main page or wherever you want
exit();
