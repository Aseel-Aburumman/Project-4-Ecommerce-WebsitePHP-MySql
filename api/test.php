<?php
session_start();

$user_id = $_SESSION['user_id'];
// $user_id = 3;



require '../connection.php';

// Fetch orders for the logged-in user
$ordersQuery = "SELECT * FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($ordersQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$ordersResult = $stmt->get_result();

if ($ordersResult && $ordersResult->num_rows > 0) {
    while ($order = $ordersResult->fetch_assoc()) {
        $order_id = $order['order_id'];
        $order_date = $order['order_date'];
        $total = $order['total'];
?>
        <div class="order">
            <h3>Order ID: <?php echo $order_id; ?></h3>
            <p>Order Date: <?php echo $order_date; ?></p>
            <p>Total: <?php echo '$' . number_format($total, 2); ?></p>
            <div class="order-items">
                <?php
                // Fetch order items for the current order
                $orderItemsQuery = "SELECT * FROM orderitems WHERE order_id = ?";
                $stmt = $conn->prepare($orderItemsQuery);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
                $orderItemsResult = $stmt->get_result();

                if ($orderItemsResult && $orderItemsResult->num_rows > 0) {
                    while ($orderItem = $orderItemsResult->fetch_assoc()) {
                        $product_id = $orderItem['product_id'];
                        $quantity = $orderItem['quantity'];
                        $price = $orderItem['price'];

                        // Fetch product details
                        $productQuery = "SELECT * FROM products WHERE product_id = ?";
                        $stmt = $conn->prepare($productQuery);
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $productResult = $stmt->get_result();
                        $product = $productResult->fetch_assoc();
                ?>
                        <div class="item" data-product-id="<?php echo $product_id; ?>">
                            <div class="image">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['product_name']; ?>">
                            </div>
                            <div class="name">
                                <p><?php echo $product['product_name']; ?></p>
                                <p><?php echo $product['description']; ?></p>
                            </div>
                            <div class="price">
                                <span><?php echo '$' . number_format($price, 2); ?></span>
                            </div>
                            <div class="quantity">
                                <span>Quantity: <?php echo $quantity; ?></span>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No items found for this order.</p>";
                }
                ?>
            </div>
        </div>
<?php
    }
} else {
    echo "<p>No orders found for this user.</p>";
}

$conn->close();
?>