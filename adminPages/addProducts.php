<?php
include '../connection.php';

$categories = [];
$product_types = [];

$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$sql_product_types = "SELECT * FROM producttypes";
$result_product_types = $conn->query($sql_product_types);
if ($result_product_types->num_rows > 0) {
    while ($row = $result_product_types->fetch_assoc()) {
        $product_types[] = $row;
    }
}

$name = '';
$email = '';
$password = '';
$role_id = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $product_type_id = $conn->real_escape_string($_POST['product_type_id']);
    $sql = "INSERT INTO products (product_name, description, price, category_id, product_type_id) VALUES ('$product_name','$description',$price,$category_id,$product_type_id)";
    if ($conn->query($sql) === TRUE) {
        header("Location: manageProducts.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Add Product</h2>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Product Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="product_name" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="price" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-6">
                    <select class="form-control" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Product Type</label>
                <div class="col-sm-6">
                    <select class="form-control" name="product_type_id" required>
                        <option value="">Select Product Type</option>
                        <?php foreach ($product_types as $product_type): ?>
                            <option value="<?= $product_type['product_type_id'] ?>"><?= $product_type['type_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="manageProducts.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
