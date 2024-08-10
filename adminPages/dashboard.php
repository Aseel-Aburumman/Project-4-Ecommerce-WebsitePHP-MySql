<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: ../account (1).php");
    exit();
}

function getFirstTwoWords($string)
{
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, 2));
}

$firstTwoWords = getFirstTwoWords($_SESSION['user_name']);
include '../connection.php';

$count_admins = 0;
$count_users = 0;
$count_orders = 0;
$category_counts = [];
$sum_total = 0;

// Count users by role
$sql = "SELECT role_id, COUNT(*) AS count FROM users GROUP BY role_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['role_id'] == 1) {
            $count_admins = $row['count'];
        } elseif ($row['role_id'] == 2) {
            $count_users = $row['count'];
        }
    }
}

// Count products by category and get category names
$sql = "SELECT categories.category_name, COUNT(products.product_id) AS countC 
        FROM products 
        JOIN categories ON products.category_id = categories.category_id 
        GROUP BY products.category_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category_counts[$row['category_name']] = $row['countC'];
    }
}

// Count orders
$sql = "SELECT COUNT(order_id) AS countOrders FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count_orders = $row['countOrders'];
}

// Calculate total sales
$sql = "SELECT SUM(total) AS total FROM orders";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        img {
            margin-left: 20px;
        }

        hr {
            margin-left: 20px;
            margin-right: 20px;
            color: white;
            border-color: white
        }

        ul {
            color: #3d62ff;
        }

        .sidebarItems {
            font-weight: bolder;
            color: #3d62ff;
        }

        .card>h3,
        .card>p {
            color: #2943b1;
        }
    </style>
</head>

<body>
    <div class="container">

        <div style="background-color: #8ba1fd61;" class="sidebar">
            <img style="margin-left: 20px;" src="../dist/images/Logo.png" alt="">
            <hr style="margin-left: 20px; margin-right: 20px; color:white ;border-color:white">
            <ul>
                <li><a style="background-color: #F1F0F0; color: #2943b1; font-weight: bold;" href="dashboard.php"><i class="fa fa-cloud"></i> Main Dashboard</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="manageUser.php"><i class="fa-solid fa-table-columns"></i> Manage Users</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="manageCategories.php"><i class="fas fa-list"></i> Manage Categories</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="manageProducts.php"><i class="fas fa-boxes"></i> Manage Products</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="manageProductType.php"><i class="fas fa-tags"></i> Manage Product Type</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="manageCoupons.php"><i class="fas fa-ticket-alt"></i> Manage Coupons</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="manageOrders.php"><i class="fas fa-ticket-alt"></i> Manage Orders</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="editAdmin.php"><i class="fas fa-user-shield"></i> Your Profile</a></li>
                <li><a style="color: #2943b1;" class="sidebarItems" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="welcome-message">
                <h2 style="color: #3d62ff;">Admin Dashboard</h2>
                <p style="color: #3d62ff;" class="admin-name"><?php echo htmlspecialchars($firstTwoWords); ?></p>
            </div>
            <div class="dashboard-container">
                <div class="dashboard">
                    <div style="background-color: #8ba1fd8c;" class="card">
                        <h3><i class="fas fa-shopping-cart"></i> Number of Orders</h3>
                        <p><?php echo $count_orders ?></p>
                    </div>
                    <div style="background-color: #8ba1fd8c;" class="card">
                        <h3><i class="fas fa-user"></i> Number of Users</h3>
                        <p><?php echo $count_users ?></p>
                    </div>
                    <div style="background-color: #8ba1fd8c;" class="card">
                        <h3><i class="fas fa-user-shield"></i> Number of Admins</h3>
                        <p><?php echo $count_admins ?></p>
                    </div>
                    <?php foreach ($category_counts as $category_name => $count): ?>
                        <div style="background-color: #8ba1fd8c;" class="card">
                            <h3><i class="fas fa-box"></i> Items in <?php echo htmlspecialchars($category_name); ?></h3>
                            <p><?php echo $count; ?></p>
                        </div>
                    <?php endforeach; ?>
                    <div style="background-color: #8ba1fd8c;" class="card">
                        <h3><i class="fas fa-dollar-sign"></i> Total Sales</h3>
                        <p><?php echo $sum_total ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>