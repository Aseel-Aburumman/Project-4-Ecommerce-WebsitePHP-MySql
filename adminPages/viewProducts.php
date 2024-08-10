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

$categories = [];
$product_types = [];

$sql_categories = "SELECT category_id, category_name FROM categories";
$result_categories = $conn->query($sql_categories);
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$sql_product_types = "SELECT product_type_id, type_name FROM producttypes";
$result_product_types = $conn->query($sql_product_types);
if ($result_product_types->num_rows > 0) {
    while ($row = $result_product_types->fetch_assoc()) {
        $product_types[] = $row;
    }
}

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $conn->real_escape_string($_POST['product_name']);
        $price = $conn->real_escape_string($_POST['price']);
        $discount = $conn->real_escape_string($_POST['discount']);
        $description = $conn->real_escape_string($_POST['description']);
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $product_type_id = $conn->real_escape_string($_POST['product_type_id']);

        $sql = "UPDATE products SET 
                    product_name='$name', 
                    price='$price', 
                    discount='$discount', 
                    description='$description',
                    category_id='$category_id',
                    product_type_id='$product_type_id' 
                WHERE product_id=$id";

        if ($conn->query($sql) === TRUE) {
            header("Location: manageProducts.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $sql = "SELECT * FROM products WHERE product_id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
            <nav style="height:100vh;padding:0; background-color: #8ba1fd61;" class="col-md-3 col-lg-2 d-md-block sidebar">
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
                            <a style="color: #2943b1;" class="sidebarItems" class="nav-link active" href="manageUser.php">
                                <i class="fa-solid fa-table-columns"></i>
                                Manage Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="color: #2943b1;" class="sidebarItems" class="nav-link" href="manageCategories.php">
                                <i class="fas fa-list"></i>
                                Manage Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="background-color: #F1F0F0;color: #2943b1;" class="sidebarItems" class="nav-link" href="manageProducts.php">
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
                <h2 style="color: #2943b1;">Products Detail</h2>

                <?php
                include 'product-details.php';
                ?>
                <!-- <div class="container my-5">
                    <h2>Edit Product</h2>
                    <form action="" method="post">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="description" rows="3" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Discount</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="discount" value="<?php echo htmlspecialchars($row['discount']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="category_id" required>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?php echo $category['category_id']; ?>" <?php if ($row['category_id'] == $category['category_id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product Type</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="product_type_id" required>
                                    <?php foreach ($product_types as $product_type) : ?>
                                        <option value="<?php echo $product_type['product_type_id']; ?>" <?php if ($row['product_type_id'] == $product_type['product_type_id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($product_type['type_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="offset-sm-3 col-sm-3 d-grid">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            <div class="col-sm-3 d-grid">
                                <a class="btn btn-outline-primary" href="manageProducts.php" role="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div> -->
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Wwl5kL5MW/xyxF2YLVivBcc2xMMJ" crossorigin="anonymous"></script>
</body>

</html>