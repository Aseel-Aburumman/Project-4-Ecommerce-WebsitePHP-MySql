<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $conn->real_escape_string($_POST['code']);
    $discount = $conn->real_escape_string($_POST['discount']);
    $max_discount_amount = $conn->real_escape_string($_POST['max_discount_amount']);
    $expiry_date = $conn->real_escape_string($_POST['expiry_date']);
    
    $sql = "INSERT INTO coupons (code, discount, max_discount_amount, is_active, expiry_date) 
            VALUES ('$code', '$discount', '$max_discount_amount', 1, '$expiry_date')";
    if ($conn->query($sql) === TRUE) {
        header("Location: manageCategories.php");
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
    <title>Add Coupon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Add Coupon</h2>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Coupon Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="code" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Discount (%)</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="discount" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Max Discount Amount</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="max_discount_amount" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Expiry Date</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="expiry_date" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Add Coupon</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="manageCoupons.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
