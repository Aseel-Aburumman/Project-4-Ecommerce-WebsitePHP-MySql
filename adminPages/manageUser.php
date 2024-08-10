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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - List of Clients</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="manageStyle.css">
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
    <div class="container-fluid">
        <div class="row">
            <nav style="padding:0; background-color: #8ba1fd61;" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <img style="margin-left: 20px;" src="../dist/images/Logo.png" alt="">
                    <hr style="margin-left: 20px; margin-right: 20px; color:white ;border-color:white">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a style="color: #2943b1;" class="sidebarItems" class="nav-link active" href="dashboard.php">
                                <i class="fa fa-cloud"></i>
                                Main dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="background-color: #F1F0F0; color: #2943b1;" class="sidebarItems" class="nav-link active" href="manageUser.php">
                                <i class="fa-solid fa-table-columns"></i>
                                Manage Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style=" color: #2943b1;" class="sidebarItems" class="nav-link" href="manageCategories.php">
                                <i class="fas fa-list"></i>
                                Manage Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="manageProducts.php">
                                <i class="fas fa-boxes"></i>
                                Manage Products
                            </a>
                        </li>
                        <li lass="nav-item"><a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="manageProductType.php"> <i class="fas fa-tags"></i> Manage Product Type</a></li>
                        <li lass="nav-item"><a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="manageCoupons.php">
                                <i class="fas fa-ticket-alt"></i>
                                Manage Coupons
                            </a></li>
                        <li lass="nav-item"><a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="manageOrders.php"> <i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                        <li lass="nav-item"><a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="editAdmin.php"><i class="fas fa-user-shield"></i> Your Profile</a></li>
                        <li class="nav-item"><a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 style="color: #3d62ff;" class="h2">Admin Dashboard</h1>
                    <p style="color: #3d62ff;" class="h5"><?php echo htmlspecialchars($firstTwoWords); ?></p>
                </div>

                <h2 style="color: #2943b1;">List of Users</h2>
                <div class="d-flex mb-3">
                    <form class="d-flex me-3" method="get" action="">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search Users" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <div>
                        <a style="background-color: #2041c2d6; " class=" btn btn-primary me-2" href="addUser.php" role="button">Add User</a>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : '';
                            $sql = $search ? "SELECT * FROM users WHERE username LIKE '%$search%' AND role_id=2" : "SELECT * FROM users WHERE role_id=2";
                            $result = $conn->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $conn->error);
                            }

                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['email']}</td>
                                    <td class='actions'>
                                    
                                        <a  href='editUser.php?user_id={$row['user_id']}'><i class='fa-solid fa-pen-to-square' style='color: #007BFF;'></i></a>
                                        <a  href='delete.php?user_id={$row['user_id']}'><i class='fa-solid fa-trash' style='color: #ff0000;'></i></a>
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