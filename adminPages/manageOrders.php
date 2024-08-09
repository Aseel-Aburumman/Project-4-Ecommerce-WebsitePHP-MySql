<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: ../account (1).php");
    exit();
}

function getFirstTwoWords($string) {
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, 2));
}

$firstTwoWords = getFirstTwoWords($_SESSION['user_name']);
include '../connection.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - List of orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="manageStyle.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                            <i class="fa fa-cloud"></i>
                                Main dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manageUser.php">
                            <i class="fa-solid fa-table-columns"></i>
                                Manage Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageCategories.php">
                            <i class="fas fa-list"></i>
                                Manage Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageProducts.php">
                            <i class="fas fa-boxes"></i>
                                Manage Products
                            </a>
                        </li>
                        <li lass="nav-item"><a class="nav-link" href="manageProductType.php"> <i class="fas fa-tags"></i> Manage Product Type</a></li>
                        <li lass="nav-item"><a class="nav-link" href="manageCoupons.php">
                        <i class="fas fa-ticket-alt"></i>
                            Manage Coupons
                        </a></li>
                        <li lass="nav-item"><a class="nav-link" href="manageOrders.php"> <i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                        <li lass="nav-item"><a class="nav-link" href="editAdmin.php"><i class="fas fa-user-shield"></i> Your Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>   Logout</a></li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Admin Dashboard</h1>
                    <p class="h5"><?php echo htmlspecialchars($firstTwoWords); ?></p>
                </div>

                <h2>List of Orders</h2>
                <div class="d-flex mb-3">
                    <form class="d-flex me-3" method="get" action="">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search By Order ID" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order date</th>
                                <th>User name</th>
                                <th>Total</th>
                                <th>Coupon ID</th>
                                <th>status</th>
                                
                                
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : '';
                            $sql = $search ? 
                            "SELECT orders.order_id, orders.user_id, DATE(orders.order_date) AS order_date, orders.total, orders.coupon_id, orders.status_id, 
                                    order_status.status_name, users.username 
                             FROM orders 
                             INNER JOIN order_status ON orders.status_id = order_status.id 
                             INNER JOIN users ON orders.user_id = users.user_id
                             WHERE orders.order_id = '$search' 
                             ORDER BY orders.order_id" : 
                            "SELECT orders.order_id, orders.user_id, DATE(orders.order_date) AS order_date, orders.total, orders.coupon_id, orders.status_id, 
                                    order_status.status_name, users.username 
                             FROM orders 
                             INNER JOIN order_status ON orders.status_id = order_status.id 
                             INNER JOIN users ON orders.user_id = users.user_id
                             ORDER BY orders.order_id";
                            $result = $conn->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $conn->error);
                            }

                            while ($row = $result->fetch_assoc()) {
                                echo "
                               <tr>
        <td>{$row['order_id']}</td>
        <td>{$row['order_date']}</td>
        <td>{$row['username']}</td>
        <td>{$row['total']}</td>
        <td>{$row['coupon_id']}</td>
        <td>{$row['status_name']}</td>
        <td class='actions'>
            <a href='updateOrderStatus.php?order_id={$row['order_id']}&status=2' title='Accept'><i class='fa-solid fa-check' style='color: green;'></i></a>
            <a href='updateOrderStatus.php?order_id={$row['order_id']}&status=3' title='Reject'><i class='fa-solid fa-times' style='color: red;'></i></a>
        </td>
    </tr>
                                ";
                            }
                            

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Wwl5kL5MW/xyxF2YLVivBcc2xMMJ" crossorigin="anonymous"></script>
</body>
</html>
