<?php
session_start();
header('Content-Type: application/json');

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
echo json_encode(['count' => $cartCount]);
