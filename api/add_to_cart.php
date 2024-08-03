<?php
session_start();
header('Content-Type: application/json');

include '../connection.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($input['product_id'])) {
    $productId = $input['product_id'];

    $sqlProduct = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sqlProduct);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $resultProduct = $stmt->get_result();

    if ($resultProduct->num_rows > 0) {
        $product = $resultProduct->fetch_assoc();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!isset($_SESSION['cart_quantities'])) {
            $_SESSION['cart_quantities'] = [];
        }

        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $productId;
            $_SESSION['cart_quantities'][$productId] = 1;
        } else {
            $_SESSION['cart_quantities'][$productId] += 1;
        }

        $itemCount = 0;
        $itemTotalPrice = 0;
        foreach ($_SESSION['cart'] as $id) {
            $quantity = $_SESSION['cart_quantities'][$id];
            $sqlProduct = "SELECT price FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($sqlProduct);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultProduct = $stmt->get_result();
            if ($resultProduct->num_rows > 0) {
                $product = $resultProduct->fetch_assoc();
                $itemCount += $quantity;
                $itemTotalPrice += $product['price'] * $quantity;
            }
        }

        $discount = isset($_SESSION['coupon']['discount']) ? $_SESSION['coupon']['discount'] : 0;
        $discountAmount = $itemTotalPrice * ($discount / 100);
        $taxes = $itemTotalPrice * 0.16;
        $totalPrice = $itemTotalPrice - $discountAmount + $taxes;

        $_SESSION['cart_summary'] = [
            'itemCount' => $itemCount,
            'itemTotalPrice' => $itemTotalPrice,
            'discount' => $discount,
            'discountAmount' => $discountAmount,
            'taxes' => $taxes,
            'totalPrice' => $totalPrice
        ];

        echo json_encode(["status" => "success", "message" => "Product added to cart."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
