<?php
session_start();
include '../connection.php'; // Ensure this file includes your database connection

$itemCount = 0;
$itemTotalPrice = 0.0;
$shippingCost = 3.00;
$discount = 0;
$maxDiscountAmount = 0;
$discountAmount = 0;
$taxRate = 0.16;
$taxes = 0.0;
$totalPrice = 0.0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartIds = implode(',', $_SESSION['cart']);
    $cartQuery = "SELECT * FROM products WHERE product_id IN ($cartIds)";
    $result = $conn->query($cartQuery);

    if ($result && $result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            $product_id = $product['product_id'];
            $quantity = isset($_SESSION['cart_quantities'][$product_id]) ? $_SESSION['cart_quantities'][$product_id] : 0;
            $itemCount += $quantity;
            $itemTotalPrice += $product['price'] * $quantity;
        }
    }
}

if (isset($_SESSION['coupon'])) {
    $discount = $_SESSION['coupon']['discount'];
    $maxDiscountAmount = $_SESSION['coupon']['max_discount_amount'];
    $discountAmount = min(($itemTotalPrice * $discount / 100), $maxDiscountAmount);
}

$taxes = $itemTotalPrice * $taxRate;
$totalPrice = ($itemTotalPrice + $shippingCost - $discountAmount + $taxes);

$summary = [
    'itemCount' => $itemCount,
    'itemTotalPrice' => $itemTotalPrice,
    'discount' => $discount,
    'discountAmount' => $discountAmount,
    'taxes' => $taxes,
    'totalPrice' => $totalPrice
];

$_SESSION['cart_summary'] = $summary;

echo json_encode($summary);
