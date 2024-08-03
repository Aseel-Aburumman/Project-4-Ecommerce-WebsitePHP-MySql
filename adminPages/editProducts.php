<?php
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
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
                        <?php foreach ($categories as $category): ?>
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
                        <?php foreach ($product_types as $product_type): ?>
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
    </div>
</body>
</html>
