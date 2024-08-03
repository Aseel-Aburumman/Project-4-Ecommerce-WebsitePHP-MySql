<?php

include '../connection.php';

function truncateText($text, $maxWords) {
    $words = explode(' ', $text);
    if (count($words) > $maxWords) {
        $words = array_slice($words, 0, $maxWords);
        return implode(' ', $words) . '...';
    }
    return $text;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - List of Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="manageStyle.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="manageUser.php">
                                Manage Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageCategories.php">
                                Manage Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageProducts.php">
                                Manage Products
                            </a>
                        </li>
                        <li lass="nav-item"><a class="nav-link" href="manageProductType.php">Manage Product Type</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="#logout">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Admin Dashboard</h1>
                    <p class="h5">Admin Name</p>
                </div>

                <h2>List of Products</h2>
                <div class="d-flex mb-3">
                    <form class="d-flex me-3" method="get" action="">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search clients" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <div>
                        <a class="btn btn-primary me-2" href="addProducts.php" role="button">Add Products</a>
                        <a class="btn btn-secondary" href="dashboard.php" role="button">Back</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>discount</th>
                                <th>Category id</th>
                                <th>Product type id</th>
                                
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : '';
                            $sql = $search ? "SELECT * FROM products WHERE product_name LIKE '%$search%' " : "SELECT * FROM products ";
                            $result = $conn->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $conn->error);
                            }

                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>{$row['product_id']}</td>
                                    <td>" . truncateText($row['product_name'], 2) . "</td>
                                    <td>" . truncateText($row['description'], 3) . "</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['discount']}</td>
                                    	
                                    <td>{$row['category_id']}</td>
                                    <td>{$row['product_type_id']}</td>
                                       <td class='actions'>
        
                                        <a class='btn btn-warning btn-sm' href='editProducts.php?product_id={$row['product_id']}'>Edit</a>
                                        <a class='btn btn-danger btn-sm' href='delete.php?product_id={$row['product_id']}'>Delete</a>
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
