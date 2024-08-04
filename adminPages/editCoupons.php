<?php
include '../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['category_id'])) {
    $id = $_GET['category_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = $conn->real_escape_string($_POST['code']);
        $discount = $conn->real_escape_string($_POST['discount']);
        $max_discount_amount = $conn->real_escape_string($_POST['max_discount_amount']);
        $is_active = $conn->real_escape_string($_POST['is_active']);
        $expiry_date = $conn->real_escape_string($_POST['expiry_date']);

        $sql = "UPDATE coupons SET code='$code', discount='$discount', max_discount_amount='$max_discount_amount', is_active='$is_active', expiry_date='$expiry_date' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: manageCoupons.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $sql = "SELECT * FROM coupons WHERE id=$id";
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
    <title>Edit Coupon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Coupon</h2>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Coupon Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="code" value="<?php echo htmlspecialchars($row['code']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Discount (%)</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="discount" value="<?php echo htmlspecialchars($row['discount']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Max Discount Amount</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="max_discount_amount" value="<?php echo htmlspecialchars($row['max_discount_amount']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Expiry Date</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="expiry_date" value="<?php echo htmlspecialchars($row['expiry_date']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Is Active</label>
                <div class="col-sm-6">
                    <select class="form-control" name="is_active" required>
                        <option value="1" <?php echo ($row['is_active'] == 1) ? 'selected' : ''; ?>>True</option>
                        <option value="0" <?php echo ($row['is_active'] == 0) ? 'selected' : ''; ?>>False</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="manageCoupons.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
