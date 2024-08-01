<?php
session_start();
header('Content-Type: application/json');

$wishlistCount = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;

echo json_encode(['count' => $wishlistCount]);
