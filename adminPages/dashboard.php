
<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}


function getFirstTwoWords($string) {
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, 2));
}

$firstTwoWords = getFirstTwoWords($_SESSION['user_name']);
include '../connection.php';


$count_admins = 0;
$count_users = 0;
$count_orders = 0;
$count_items1 = 0;
$count_items2 = 0;
$count_items3 = 0;
$sum_total=0;

$sql = "SELECT role_id, COUNT(*) AS count FROM users GROUP BY role_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['role_id'] == 2) {
            $count_admins = $row['count'];
        } elseif ($row['role_id'] == 1) {
            $count_users = $row['count'];
        }
    }
}
//-----------------------------------------------------
$sql = "SELECT category_id , COUNT(*) AS countC FROM products GROUP BY category_id ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['category_id'] == 1) {
            $count_items1 = $row['countC'];
        } elseif ($row['category_id'] == 2) {
            $count_items2 = $row['countC'];
        } elseif ($row['category_id'] == 3) {
            $count_items3  = $row['countC'];
        }
    }
}
//---------------------------------------

$sql = "SELECT  COUNT(order_id) AS countOrders FROM orders ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count_orders = $row['countOrders'];
}
//-------------------------------
$sql = "SELECT sum(total) as total FROM orders ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sum_total = $row['total'];
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
            <li><a href="dashboard.php">Main dashboard</a></li>

                <li><a href="manageUser.php">Manage Users</a></li>
                <li><a href="manageCategories.php">Manage Categories</a></li>
                <li><a href="manageProducts.php">Manage Products</a></li>
                <li><a href="manageProductType.php">Manage Product Type</a></li>
                <li><a href="manageCoupons.php">Manage Coupons</a></li>
                <li><a href="../account (1).php">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="welcome-message">
                <h2>Admin Dashboard</h2>
                <p class="admin-name"><?php echo htmlspecialchars($firstTwoWords); ?></p>
            </div>
            <div class="dashboard-container">
                <div class="dashboard">
                    <div class="card">
                        <h3>Number of Orders</h3>
                        <p><?php echo $count_orders?></p>
                    </div>
                    <div class="card">
                        <h3>Number of Users</h3>
                        <p><?php echo $count_users ?></p>
                    </div>
                    <div class="card">
                        <h3>Number of Admins</h3>
                        <p><?php echo $count_admins ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Items in Category 1</h3>
                        <p><?php echo $count_items1?></p>
                    </div>
                    <div class="card">
                        <h3>Total Items in Category 2</h3>
                        <p><?php echo $count_items2?></p>
                    </div>
                    <div class="card">
                        <h3>Total Items in Category 3</h3>
                        <p><?php echo $count_items3?></p>
                    </div>
                    <div class="card">
                        <h3>Total sales</h3>
                        <p><?php echo $sum_total?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
