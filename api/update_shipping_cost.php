<?php
session_start();
include '../connection.php';

$shippingCost = isset($_POST['shippingCost']) ? floatval($_POST['shippingCost']) : 3.00;
$_SESSION['shippingCost'] = $shippingCost;

// Recalculate the cart summary
$itemTotalPrice = isset($_SESSION['itemTotalPrice']) ? $_SESSION['itemTotalPrice'] : 0.0;
$discountAmount = isset($_SESSION['discountAmount']) ? $_SESSION['discountAmount'] : 0.0;
$taxRate = 0.16;
$taxes = $itemTotalPrice * $taxRate;
$totalPrice = ($itemTotalPrice + $shippingCost - $discountAmount + $taxes);

$_SESSION['cart_summary'] = [
    'itemTotalPrice' => $itemTotalPrice,
    'discountAmount' => $discountAmount,
    'taxes' => $taxes,
    'totalPrice' => $totalPrice
];

echo json_encode(['success' => true, 'newTotal' => $totalPrice]);
