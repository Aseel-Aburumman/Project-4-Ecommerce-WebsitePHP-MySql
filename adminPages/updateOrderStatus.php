<?php
include '../connection.php';

if (isset($_GET['order_id']) && isset($_GET['status'])) {
    $order_id = $conn->real_escape_string($_GET['order_id']);
    $status = $conn->real_escape_string($_GET['status']);
    
    $sql = "UPDATE orders SET status_id = '$status' WHERE order_id = '$order_id' ";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: manageOrders.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
} else {
    header("Location: manageOrders.php");
    exit();
}
?>
