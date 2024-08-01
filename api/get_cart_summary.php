<?php
session_start();
include 'connection.php';

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cartQuantities = isset($_SESSION['cart_quantities']) ? $_SESSION['cart_quantities'] : [];
$discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;

$totalItems = 0;
$totalPrice = 0;

if (!empty($cartItems)) {
    $cartIds = implode(',', $cartItems);
    $cartQuery = "SELECT * FROM products WHERE product_id IN ($cartIds)";
    $result = $conn->query($cartQuery);

    if ($result && $result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            $product_id = $product['product_id'];
            $quantity = isset($cartQuantities[$product_id]) ? $cartQuantities[$product_id] : 1;
            $totalItems += $quantity;
            $totalPrice += $product['price'] * $quantity;
        }
    }
}

$shippingCost = 3;
$taxRate = 16 / 100;
$discountAmount = ($totalPrice * $discount) / 100;
$totalAfterDiscount = $totalPrice - $discountAmount;
$taxAmount = $totalAfterDiscount * $taxRate;
$totalCost = $totalAfterDiscount + $shippingCost + $taxAmount;

echo json_encode([
    'totalItems' => $totalItems,
    'totalPrice' => $totalPrice,
    'discount' => $discount,
    'totalCost' => $totalCost
]);
