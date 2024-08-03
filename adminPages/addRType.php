<?php
include '../connection.php';

$name = '';
$email = '';
$password = '';
$role_id = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productT_name = $conn->real_escape_string($_POST['productT_name']);
    $sql = "INSERT INTO producttypes (type_name) VALUES ('$productT_name')";
    if ($conn->query($sql) === TRUE) {
        header("Location: manageProductType.php");
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
        <h2>Add Product Type</h2>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Product Type Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="productT_name" required>
                </div>
            </div>
            
           
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Add Product Type</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="manageProductType.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
