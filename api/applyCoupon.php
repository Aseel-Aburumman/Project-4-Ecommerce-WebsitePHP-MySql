<?php
session_start();
include '../connection.php'; // Ensure this file includes your database connection

$response = ['success' => false, 'message' => 'Invalid coupon code'];

if (isset($_POST['coupon_code'])) {
    $couponCode = $_POST['coupon_code'];
    $currentDate = date('Y-m-d');

    $query = $conn->prepare("SELECT * FROM coupons WHERE code = ? AND is_active = 1 AND expiry_date >= ?");
    $query->bind_param('ss', $couponCode, $currentDate);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $coupon = $result->fetch_assoc();
        $_SESSION['coupon'] = $coupon;
        $response = [
            'success' => true,
            'message' => 'Coupon applied! You get a discount of ' . $coupon['discount'] . '% (max $' . $coupon['max_discount_amount'] . ')'
        ];
    } else {
        $response['message'] = 'Invalid or expired coupon code';
    }
}

echo json_encode($response);
