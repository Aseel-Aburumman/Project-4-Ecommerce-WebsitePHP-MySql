<?php 
include '../connection.php';

if(isset($_GET["user_id"])){
    $id = $conn->real_escape_string($_GET["user_id"]);
    $sql = "DELETE FROM users WHERE user_id = $id";
    $conn->query($sql);
    header("location: manageUser.php");
} 
else if (isset($_GET["product_type_id"])){
    $id = $conn->real_escape_string($_GET["product_type_id"]);
    $sql = "DELETE FROM producttypes WHERE product_type_id = $id";
    $conn->query($sql);
    header("location: manageProductType.php");
}  
else if (isset($_GET["product_id"])){
    $id = $conn->real_escape_string($_GET["product_id"]);
    $sql = "DELETE FROM products WHERE product_id = $id";
    $conn->query($sql);
    header("location: manageProducts.php");
}   
else if (isset($_GET["order_id"])){
    $id = $conn->real_escape_string($_GET["order_id"]);
    $sql = "DELETE FROM orders WHERE order_id = $id";
    $conn->query($sql);
    header("location: manageOrders.php");
}  
else if (isset($_GET["coupon_id"])){
    $id = $conn->real_escape_string($_GET["coupon_id"]);
    $sql = "DELETE FROM coupons WHERE id = $id";
    $conn->query($sql);
    header("location: manageCoupons.php");
}  
else if (isset($_GET["category_id"])){
    $id = $conn->real_escape_string($_GET["category_id"]);
    $sql = "DELETE FROM categories WHERE category_id = $id";
    $conn->query($sql);
    header("location: manageCategories.php");
} 

exit;
?>
