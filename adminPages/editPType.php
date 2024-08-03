<?php
 include '../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['product_type_id'])) {
    $id = $_GET['product_type_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $name = $conn->real_escape_string($_POST['type_name']);
        $price = $conn->real_escape_string($_POST['price']);
      
        

        $sql = "UPDATE producttypes SET type_name='$name' WHERE product_type_id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: manageProductType.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    $sql = "SELECT * FROM producttypes WHERE product_type_id=$id";
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
    <title>Edit Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Edit type</h2>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Type Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="type_name" value="<?php echo htmlspecialchars($row['type_name']); ?>" required>
                </div>
            </div>
           
            
          
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="manageProductType.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
