<?php



class User {

    private $conn;


    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($fullName, $email, $password) {
        // Prepare the SQL statement
        $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, 2)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            // Handle prepare statement error
            die("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        $stmt->bind_param('sss', $fullName, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            // Handle execution error
            die("Execute failed: " . $stmt->error);
        }
    }

    public function login($email, $password) {
        // Prepare the SQL statement
        $sql = "SELECT password FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            // Handle prepare statement error
            die("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        $stmt->bind_param('s', $email);

        // Execute the statement
        $stmt->execute();

        // Store the result
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            // Initialize the variable before binding the result
            $storedPassword = '';
            // Bind the result to the variable
            $stmt->bind_result($storedPassword);
            $stmt->fetch();

            // Verify the password
            if ($password === $storedPassword) {
                return true;
            }
        }

        return false;
    }


    public function getUsername($email) {
        $stmt = $this->conn->prepare("SELECT username FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['username'];
        }
        return null;
    }

    public function getRoleId($email) {
        $stmt = $this->conn->prepare("SELECT role_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['role_id'];
        }
        return null;
    }
}
?>
