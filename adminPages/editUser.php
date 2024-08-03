<?php
include '../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['user_id'])) {
    $id = $_GET['user_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        
      
        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $address = $conn->real_escape_string($_POST['address']);
        $building = $conn->real_escape_string($_POST['building']);
        $city = $conn->real_escape_string($_POST['city']);
        $phone = $conn->real_escape_string($_POST['phone']);

        $sql_user = "UPDATE users SET username='$name', email='$email' WHERE user_id=$id";
        if ($conn->query($sql_user) === TRUE) {
            
            $sql_check_billing = "SELECT * FROM billing_information WHERE user_id=$id";
            $result_billing = $conn->query($sql_check_billing);
            
            if ($result_billing->num_rows > 0) {
               
                $sql_billing = "UPDATE billing_information SET 
                                    firstname='$firstname', 
                                    lastname='$lastname', 
                                    address='$address', 
                                    building='$building', 
                                    city='$city', 
                                    phone='$phone' 
                                WHERE user_id=$id";
            } else {
                
                $sql_billing = "INSERT INTO billing_information (user_id, firstname, lastname, address, building, city, phone) VALUES 
                                ($id, '$firstname', '$lastname', '$address', '$building', '$city', '$phone')";
            }

            if ($conn->query($sql_billing) === TRUE) {
                header("Location: manageUser.php");
                exit();
            } else {
                echo "Error: " . $sql_billing . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_user . "<br>" . $conn->error;
        }
    }

    $sql = "SELECT u.*, b.firstname, b.lastname, b.address, b.building, b.city, b.phone FROM users u LEFT JOIN billing_information b ON u.user_id = b.user_id WHERE u.user_id=$id";
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
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Edit User</h2>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                </div>
            </div>

            <h2>Edit Billing Information</h2>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Building</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="building" value="<?php echo htmlspecialchars($row['building']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">City</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($row['city']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="manageUser.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
