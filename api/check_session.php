<?php
session_start();
header('Content-Type: application/json');

$response = [
    'cart' => isset($_SESSION['cart']) ? $_SESSION['cart'] : [],
    'cart_quantities' => isset($_SESSION['cart_quantities']) ? $_SESSION['cart_quantities'] : [],
    'coupon' => isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null,
    'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
    'cart_summary' => isset($_SESSION['cart_summary']) ? $_SESSION['cart_summary'] : null


];

echo json_encode($response, JSON_PRETTY_PRINT);
