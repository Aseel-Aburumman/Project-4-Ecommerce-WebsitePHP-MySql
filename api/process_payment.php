<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require '../connection.php';

session_start();

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(204); // No Content
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate Name on Card
        $card_name = isset($data['card_name']) ? $data['card_name'] : null;
        if (empty($card_name)) {
            $errors['card_name'] = 'Name on card is required';
        }

        // Validate Card Number
        $card_number = isset($data['card_number']) ? $data['card_number'] : null;
        if (!preg_match('/^\d{16}$/', $card_number)) {
            $errors['card_number'] = 'Invalid card number';
        }

        // Validate Expiration Date
        $exp_date = isset($data['exp_date']) ? $data['exp_date'] : null;
        if (!preg_match('/^(0[1-9]|1[0-2])\/?([0-9]{2})$/', $exp_date)) {
            $errors['exp_date'] = 'Invalid expiration date';
        }

        // Validate CVC
        $cvc = isset($data['cvc']) ? $data['cvc'] : null;
        if (!preg_match('/^[0-9]{3,4}$/', $cvc)) {
            $errors['cvc'] = 'Invalid CVC';
        }

        if (empty($errors)) {
            // Process the payment logic here
            $user_id = $_SESSION['user_id'];

            // Insert order details into the orders table
            $cart_summary = $_SESSION['cart_summary'];
            $total_price = $cart_summary['totalPrice'];
            $discount = $cart_summary['discount'];
            $taxes = $cart_summary['taxes'];
            $item_count = $cart_summary['itemCount'];

            $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
            $stmt->bind_param("id", $user_id, $total_price);
            if (!$stmt->execute()) {
                throw new Exception("Error inserting order details: " . $stmt->error);
            }

            $order_id = $stmt->insert_id;

            // Insert order items into the orderitems table
            $cart_quantities = $_SESSION['cart_quantities'];
            foreach ($cart_quantities as $product_id => $quantity) {
                // Fetch price from the database
                $stmt = $conn->prepare("SELECT price FROM products WHERE product_id = ?");
                $stmt->bind_param("i", $product_id);
                if (!$stmt->execute()) {
                    throw new Exception("Error fetching product price: " . $stmt->error);
                }
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();
                $price = $product['price'];

                $stmt = $conn->prepare("INSERT INTO orderitems (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting order item: " . $stmt->error);
                }
            }

            // Clear the cart session
            unset($_SESSION['cart']);
            unset($_SESSION['cart_quantities']);
            unset($_SESSION['cart_summary']);

            $response['success'] = true;
            $response['message'] = 'Payment successful';
        } else {
            $response['message'] = 'Validation errors';
            $response['errors'] = $errors;
        }
    } else {
        $response['message'] = 'Invalid request method';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
$conn->close();
